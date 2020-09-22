<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use App\LogError;
use App\Providers\SocialFacebookAccountService;
use App\Exceptions\GeneralException;
use Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Armanagement;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {
		$link = Socialite::driver('facebook')->redirect();
		$ban = "curl -X BAN " . $link;
		exec($ban);
        return $link;
    }
    public function callback(SocialFacebookAccountService $service)
    {		
		try {
			$user = $service->createOrGetUser(Socialite::driver('facebook')->user());	
			$usr = $user['user'];
			$status = $user['status'];
			$fb_id = $user['fb_id'];			
			if($status == "go" || $status == "new account") {
				session(['user' => $usr]);      			
				session(['loggedin' => 'yes']);		
				$loc = session('location');
				try {
				  $arwebsite = Armanagement::where('location', $loc)->firstOrFail();
				  $url = $arwebsite->domainname;
				} catch (ModelNotFoundException $ex) {				  
				  $url = "phillipisland.guide";
				}
				$rt = route('home'). "?loc=" . $loc . "&url=". $url;
				return redirect()->away($rt);				
			} else if($status == "no email") {
				return view('site.no_email', ['title' => 'No Email Page', 'runningbg' => session('runningbg')]);
			} else if($status == "email found") {
				if($usr->customer_emailvalidated == true || $usr->customer_emailvalidated == 1 || $usr->customer_emailvalidated == '1') {
					$c = User::where('customer_id', $usr->customer_id)->update(['customer_facebook_id' => $fb_id]);
					$upusr = User::where('customer_id', $usr->customer_id)->first();
					session(['user' => $upusr]);      			
					session(['loggedin' => 'yes']);    
					return redirect()->route('home');
				} else {
					$log = $this->saveLog('email', $usr->customer_id, $usr->customer_email);
					return view('site.confirm_email', ['title' => 'Email Confirmation Page', 'user' => $usr, 'runningbg' => session('runningbg')]);
				}
			} else if($status == "fbid found") {
				$log = $this->saveLog('fb_id', $usr->customer_id, $usr->customer_facebook_id);
				return view('site.confirm_fb', ['title' => 'Facebook Confirmation Page', 'user' => $usr, 'runningbg' => session('runningbg')]);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	
	public function saveLog($missing, $cid, $param) {
		$msg = "Login with facebook but email was already found in the database that's different from the email coming from the facebook.";
		if($missing == "fb_id") {
			$msg = "Login with facebook but facebook id was already found in the database with no specified email.";
		}
		$data = [
			'customer_id' => $cid, 
			'missing' => $missing,
			'error_message' => $msg, 		
			'parameter' => $param, 
		];
		$log = LogError::create($data);
		return true;
	}
}

