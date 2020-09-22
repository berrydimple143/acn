<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\User;
use App\Privilege;
use App\Mail\SiteShared;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\LogError;
use Storage;

class FrontController extends Controller {
    public function mobile($email) {
		try {
			if(session('throttled') == 'yes') {
				$exp = session('throttle_start');
				$now = Carbon::now();
				if($now->gt($exp)) {
					return $this->showForm($email);
				} else {
					return view('site.throttled', ['title' => 'Throttle Page', 'runningbg' => session('runningbg')]);
				}		
			} else {
				return $this->showForm($email);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function showForm($email) {
		try {
			session(['pagecounter' => 1]);
			session(['throttled' => 'no']);
			session(['throttle_start' => null]);
			return view('site.mobile', ['title' => 'Mobile Page', 'email' => $email, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function checkEmail($email) {
		try {
			$user = User::where('customer_email', $email)->orWhere('customer_facebook_id', $email)->firstOrFail();
			$go = "found";               
		} catch (ModelNotFoundException $ex) {
			$go = "not found";
		}
		return $go;
    }
    public function create_user(Request $request) {
		try {
			$mobile = $request->input('mobile', '');
			$firstname = $request->input('firstname', '');
			$lastname = $request->input('lastname', '');
			$email = $request->input('email', '');
			$hasEmail = $this->checkEmail($email);
			if($hasEmail == "found") {
				return view('site.email_exist', ['title' => 'Email already exist.', 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'mobile' => $mobile, 'runningbg' => session('runningbg')]);
			} else {
					$now = Carbon::now();
					$ddate = str_replace_array('-', ['', ''], $now->toDateTimeString());
					$ddate = substr($ddate, 2);
					$ddate = str_replace_array(' ', [''], $ddate);
					$ddate = str_replace_array(':', ['', ''], $ddate);
					$p_id = "4C".$ddate;
					$date_created = $now->toDateTimeString();
					$password = str_random(10);
					$privilege = Privilege::where('level', 'Local Resident')->first();
					$loc = session('location');
					$url = session('url');
					$data = [
						"customer_id" => $p_id,
						"customer_emailvalidated" => 0,
						"customer_level" => 'Local Resident',
						"date_created" => $date_created,
						"customer_status" => "NEW",
						"customer_ip" => \Request::ip(),
						"customer_name" => $firstname,
						"customer_surname" => $lastname,
						"customer_middlename" => '',
						"customer_nickname" => '',
						"customer_mobile" => $mobile,
						"customer_mobilevalidated" => 1,
						"customer_password" => $password,
						"customer_email" => $email,					
						"customer_distribution" => "YES",
						"membership_key" => '',
						"customer_homeportal" => $loc,
						"customer_currentportal" => $loc,
						"customer_homeurl" => $url,
						"customer_currenturl" => $url,
						"ad_limit" => $privilege->ad_limit,
						"article_limit" => $privilege->article_limit,
						"photo_limit" => $privilege->photo_limit,
						"event_limit" => $privilege->event_limit,
					 ];
					 $u = User::create($data);
					 session(['user' => $u]);
					 session(['loggedin' => 'yes']);
					 $loginrt = route('home'). "?loc=" . $loc. "&url=". $url;
					 return view('site.code_successful', ['title' => 'Code Successful Page', 'loginrt' => $loginrt, 'runningbg' => session('runningbg')]);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function mobile_confirmed(Request $request) {
		try {
			$right_code = $request->input('SMS_key', '');
			$code = $request->input('code', '');
			$mobile = $request->input('mobile', '');
			$firstname = $request->input('firstname', '');
			$lastname = $request->input('lastname', '');
			$email = $request->input('email', '');	
			$rt = route('mobile', ['email' => $email]);	
			if($code == $right_code) {	
				$mobile = preg_replace('/\s/', '', $mobile);
				$mobile = substr($mobile, -9);								
				try {						
					$mb = '%'.$mobile.'%';
					$user = User::where('customer_mobile', 'like', $mb)->firstOrFail();
					$cid = $user->customer_id;
					$data = [
						'customer_mobile' => $mobile,
						'customer_mobilevalidated' => 1,						
					];
					if($email != "none") {
						$log = LogError::where('parameter', $email)->delete();
						$data = [
							'customer_mobile' => $mobile,
							'customer_mobilevalidated' => 1,
							'customer_facebook_id' => '',
						];
					}		
					$c = User::where('customer_id', $cid)->update($data);
					$usr = User::where('customer_id', $cid)->first();					
					session(['user' => $usr]);
					session(['loggedin' => 'yes']);					
					return redirect()->route('home');		
				} catch (ModelNotFoundException $ex) {
					$hasEmail = $this->checkEmail($email);
					if($hasEmail == "found") {					
						$usr = User::where('customer_email', $email)->orWhere('customer_facebook_id', $email)->first();
						$cid = $usr->customer_id;
						$data = [
							'customer_mobile' => $mobile,
							'customer_mobilevalidated' => 1,
						];
						$c = User::where('customer_id', $cid)->update($data);
						$up_user = User::where('customer_id', $cid)->first();
						session(['user' => $up_user]);
						session(['loggedin' => 'yes']);
						return redirect()->route('home');
					} else {
						return view('site.user_form', ['title' => 'Code Successful Page', 'mobile' => $mobile, 'runningbg' => session('runningbg')]); 
					}
				}
			} else {	
				$pc = (int)session('pagecounter');
				if($pc <= 3) {	
					$pc += 1; 
					session(['pagecounter' => $pc]);	
					return view('site.error', ['title' => 'Wrong code.', 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'mobile' => $mobile, 'SMS_key' => $right_code, 'runningbg' => session('runningbg')]);
				} else {
					$now = Carbon::now();
					$time = $now->addMinute();
					session(['throttled' => 'yes']);
					session(['throttle_start' => $time]);
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
				}
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function getMobileLength($m) {
		$fchar = 7;		
		$len = strlen($m);
		if($len == 10) {
				$fchar = (string)substr($m, 0, 2);
		} else if($len == 9) {
				$fchar = (string)substr($m, 0, 1);
		}
		return $fchar;
    }
    public function post_mobile(Request $request) {
		try {
			$email = $request->input('email', '');
			$rt = route('mobile', ['email' => $email]);
			$mobile = $request->input('mobile', '');		
			$mobile = preg_replace('/\s/', '', $mobile);
			if($this->getMobileLength($mobile) == "04" || $this->getMobileLength($mobile) == "4") {
				$SMS_key = mt_rand(100001, 999999);
				$SMS_success = $this->sendSMSCode($mobile, $SMS_key);
				if($SMS_success == "NO" || $SMS_success == "EMPTY") {
							return view('site.send_error', ['title' => 'Error sending sms ...', 'route' => $rt, 'runningbg' => session('runningbg')]);
					} else {
							return view('site.sent', ['title' => 'Code Area', 'SMS_key' => $SMS_key, 'mobile' => $mobile, 'email' => $email, 'runningbg' => session('runningbg')]);
					}	
			} else {
				return view('site.send_error', ['title' => 'Invalid mobile phone number ...', 'route' => $rt, 'runningbg' => session('runningbg')]);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function sendSMSCode($mobile, $SMS_key) {
		try {
			$GLOBALS['sms_send'] = 'on';
			$SMS_gateway_account = '4ustralia';
			$SMS_gateway_password = 'Morris#Perry#0870';
			$SMS_channel_count = 1;
			$SMS_gateway = '101.167.174.131';
			$SMS_port = '1025';
			$SMS_destination = '61' . substr($mobile, -9);
			$SMS_success = "EMPTY";
			$rt2 = route('login');
			$SMS_message = 'Your code is "' . $SMS_key . '"';
			$ch = curl_init();
			$SMS_outbound = '0';
			$SMS_gateway_password_encoded = curl_escape($ch, $SMS_gateway_password);
			$SMS_message_encoded = curl_escape($ch, $SMS_message);
			$SMS_outbound = 'http://' . $SMS_gateway . ':' . $SMS_port . '/cgi/WebCGI?1500101=account=' . $SMS_gateway_account . '&password=' . $SMS_gateway_password_encoded . '&port=' . $SMS_channel_count . '&destination=' . $SMS_destination . '&content=' . $SMS_message_encoded;
			curl_setopt($ch, CURLOPT_URL, $SMS_outbound);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$SMS_result = curl_exec($ch);
			if ((strpos($SMS_result, 'Response: Success') !== false) && ((strpos($SMS_result, 'Message: Commit successfully!') !== false))) {
					$SMS_success = 'YES';
			} else {
					$SMS_success = 'NO';
			}
			curl_close($ch);
			return $SMS_success;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }	
    public function share() {
		try {
			return view('site.share', ['title' => 'Tell a friend Page', 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function post_share(Request $request) {
		try {
			$from = $request->input('email');
			$headers = "From: $from";
			$ml = @mail($request->input('friendmail'), $request->input('subject'), $request->input('message'), $headers, "-f " . $from);
			if(!$ml) {
				return view('site.mail_failed', ['title' => 'Tell a friend failed', 'runningbg' => session('runningbg')]);
			} else {
				return view('site.shared', ['title' => 'Tell a friend successful', 'runningbg' => session('runningbg')]);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
