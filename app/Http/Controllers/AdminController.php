<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Advertisement;
use App\Article;
use App\Event;
use App\User;
use App\Country;
use App\Photo;
use App\PaymentDetail;
use App\Banner;
use App\Portrait;
use App\Domain;
use App\EmailTemplate;
use App\Logo;
use App\Sponsorship;
use App\Armanagement;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\FrontController;
use App\Exceptions\SkippycoinException;
use App\Exceptions\GeneralException;
use App\Rules\Facebook;
use App\Console\Commands\DeleteUnused;
use Storage;

class AdminController extends Controller {        
	public $getkey = "";
	public $getcid = "";
	public $datedecrypted = "";
	public $keyepochtime = "";
	
    /* This method is responsible for code testing */
	public function test_code() {
		$done = new  DeleteUnused();
		$photos = public_path('/publicimages/large_images/*.*');
		$i = $done->clean_up($photos, 'photo');
		$thumbs = public_path('/publicimages/thumbs/*.*');
		$t = $done->clean_up($thumbs, 'photo');
		
		$banners = public_path('/publicimages/banners/*.*');
		$b = $done->clean_up($banners, 'banner');
		$bthumbs = public_path('/publicimages/banners/thumbs/*.*');
		$bt = $done->clean_up($bthumbs, 'banner');
		
		$portraits = public_path('/publicimages/portraits/*.*');
		$p = $done->clean_up($portraits, 'portrait');
		
		$logos = public_path('/publicimages/logos/*.*');
		$l = $done->clean_up($logos, 'logo');
		return $l;
	}
    
    /* This method is responsible for updating the session variables especially when moving from one location or portal to another */
	public static function updateSession($unsafe_loc, $unsafe_url) {
        $safeurl = "broome.town";
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ipaddr = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }         
		$gotloc = $unsafe_loc; 
		$safeloc = preg_replace("/[^a-zA-Z0-9-]/", "", $gotloc);	  
		$goturl = $unsafe_url; 
		$safeurl = preg_replace("/[^a-zA-Z0-9-.]/", "", $goturl);		 
		session(['location' => $safeloc]);    
		session(['url' => $safeurl]); 
		session(['ipaddr' => $ipaddr]);          
        return $safeurl;
    }
    
    /* This method is responsible for updating the site's background picture whenever moving to another location/portal */
	public static function updateBackground($arsite, $server, $vbg, $uri, $rpath) {
		try {
			$bgcreditstring = "";
			$bgcrediturl = "";        
			$backgroundphotorequired = "YES";
			$defaultbg = "commonimages/backgrounds/default/default.jpg";  		
			$currentpage = '';
			$runningbg = "";
			$serveruri = $uri;					
			$rootpath = $rpath;
			$currentpage = $serveruri;        		
			$oldviewbg = $vbg;		
			$longstate = "";
			$domainname = "";
			$location = "";
			$flavor = "";
			$localname = "";
			$googlemeta = '';
			$bingmeta = '';
			$currentpageurl = '';
			if($arsite != "Not Found") {
				$longstate = $arsite->longstate;
				$domainname = $arsite->domainname;
				$location = $arsite->location;
				$flavor = $arsite->flavor;    
				$localname = $arsite->localname;          
				$currentpage = strip_tags(substr($currentpage, 0, 120));            
				$currentpageurl = 'http://' . $domainname . $currentpage;            
				if (($currentpage == "/index.php") or ($currentpage == "/")) {                                  
					try {
					  $dom = Domain::where('domain', $server)->firstOrFail();
					  $googlemeta = $dom->googlemeta;
					  $bingmeta = $dom->bingmeta;
					} catch (ModelNotFoundException $ex) {
					  $googlemeta = '';
					  $bingmeta = '';
					}       
				}            
				$bestdir = 'commonimages/backgrounds/locations/' . $location;            
				$bestbg = "commonimages/backgrounds/locations/" . $location . ".jpg";
				$flavorbg = "commonimages/backgrounds/flavors/" . $flavor . ".jpg";            
				$bgfiles = glob($bestdir . '/*.jpg');
				 if(file_exists($bestbg)) {
					 $runningbg = $bestbg;
				} else if ($bgfiles) {		
					if (count($bgfiles) > 1) {
						if (($currentpage == "/") or ($currentpage == "/index.php") or ($currentpage == "/View-Background.php")) {
						
						} else {    
							shuffle($bgfiles);
						}
					}
					$runningbg = $bgfiles[0];   					
				} else if (file_exists($flavorbg)) {
					$runningbg = $flavorbg;
					$bgcredit = str_replace(".jpg", ".txt", $runningbg);
					if (file_exists($bgcredit)) {
						$printbgcredit = "YES";
						$creditfile = fopen($bgcredit, "r");
						$creditarray = (fgetcsv($creditfile));
						fclose($creditfile);
						$bgcreditstring = $creditarray[0];
						if (!empty($creditarray[1])) {
							$bgcrediturl = $creditarray[1];
						}
					}					
				} else {
					$runningbg = $defaultbg;
				}
			} else {
				$runningbg = $defaultbg;
			}		
			$newbg = $runningbg;
			if(str_contains($serveruri, 'viewbg=')) {
				$newbg = str_after($serveruri, 'viewbg=');
			}
			session(['bgcrediturl' => $bgcrediturl]);
			session(['bgcreditstring' => $bgcreditstring]);
			session(['currentpage' => $currentpage]);
			session(['serveruri' => $serveruri]);
			session(['runningbg' => $newbg]);
			session(['longstate' => $longstate]);
			session(['location' => $location]);   
			session(['localname' => $localname]);
			session(['rootpath' => $rootpath]);     
			session(['googlemeta' => $googlemeta]);    
			session(['bingmeta' => $bingmeta]);   
			session(['currentpageurl' => $currentpageurl]);   
			session(['server' => $server]);  	
			return $newbg;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    
    /* This method is responsible for  */
	public static function updateMenu() { 
		try {
			$number_of_images = 1;  
			date_default_timezone_set('Australia/Sydney');
			$jd=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
			$day = (jddayofweek($jd,1)); 
			if ($day == 'Sunday'){
				$number_of_images = $number_of_images + 1;
			}
			$imagefilename = 'Australia' . (((time()/30)%$number_of_images)+1).'.png';
			$currentpage = $_SERVER['REQUEST_URI'];
			$menuanimationselection = array("fadeIn", "fadeInUp", "pulse", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "slideInUp", "zoomIn", "zoomInLeft", "zoomInRight", "zoomInUp");
			$randommenuanimationselection = array_rand($menuanimationselection, 4);
			$menuanimationselection1 = $menuanimationselection[$randommenuanimationselection[0]];
			$menuanimationselection2 = $menuanimationselection[$randommenuanimationselection[1]];
			$menuanimationselection3 = $menuanimationselection[$randommenuanimationselection[2]];
			$menuanimationselection4 = $menuanimationselection[$randommenuanimationselection[3]];
			$menuanimationstring = $menuanimationselection1 . " " . $menuanimationselection2 . " " . $menuanimationselection3 . " " . $menuanimationselection4;
			
			$path = "/var/www/html/44/common/Counter.php";
			if(file_exists($path)){
				include($path);
			}else {
				$errormessage = "WARNING I cannot find the Stats Counter I was expecting " . $path;
				$errorstamp = "SITE " . $_SERVER['HTTP_HOST'] . " FILE " . $_SERVER['SCRIPT_FILENAME'] . " " . date ("D M j G:i:s T Y",time());
				$error = $errormessage . "<br>" . $errorstamp . "<br>" . "<hr>" . "\r\n";				
			} 
			session(['imagefilename' => $imagefilename]);   
			session(['menuanimationstring' => $menuanimationstring]);  
			return $menuanimationstring; 
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function index(Request $request) {
			$newloc = $request->query('loc');
			$newurl = $request->query('url');
			$newbg = $request->query('viewbg');
			$newuri = $request->server('REQUEST_URI');
			$newrootpath = $request->server('DOCUMENT_ROOT');			
			if(self::isLogin()) {
				try {
					if(isset($_GET['loc']) and isset($_GET['url']) and (!isset($_GET['viewbg']))) {
						$server = self::updateSession($_GET['loc'], $_GET['url']);
						try {
						  $arwebsite = Armanagement::where('domainname', $server)->firstOrFail();
						} catch (ModelNotFoundException $ex) {
						  $arwebsite = "Not Found";
						}
						$newbg = session('viewbg', '');
						$newuri = session('uri', '');
						$newrootpath = session('rootpath', '');
						$bg = self::updateBackground($arwebsite, $server, $newbg, $newuri, $newrootpath);
						$menu = self::updateMenu();
						$data = [
							'customer_currentportal' => $_GET['loc'],
							'customer_currenturl' => $_GET['url']
						];
						$c = User::where('customer_id', session('user')->customer_id)->update($data);			
						$usr = User::where("customer_id", session('user')->customer_id)->first();
						session(['user' => $usr]);
					}
					$email_validated = session('user')->customer_emailvalidated;
					$mobile_validated = session('user')->customer_mobilevalidated;
					$fb = session('user')->customer_facebook;
					$twitter = session('user')->customer_twitter;
					$linkedin = session('user')->customer_linkedin;
					$csid = session('user')->customer_id;
					$fb_btn_class = "btn btn-primary";
					$twt_btn_class = "btn btn-info";
					$lnkin_btn_class = "btn btn-success";
					$invalids = "no";			
					$message = $cstatus = "";
					$email_btn_class = $mobile_btn_class = "btn btn-danger";
					if($email_validated) { 
						$email_btn_class = "btn btn-success"; 
					} else {
						$message = "Validate your Email to Post Articles, Ads or Events";
						$invalids = "yes"; 
					}
					if($mobile_validated) { 
						$mobile_btn_class = "btn btn-success"; 
					} else { 
						$message = "Validate your Mobile to Post Articles, Ads or Events";
						$invalids = "yes"; 
					}
					if(!$mobile_validated and !$email_validated) {
						$message = "Validate your Mobile and Email to Post Articles, Ads or Events";
					}
					if($fb == "") { $fb_btn_class = "btn btn-warning"; }
					if($twitter == "") { $twt_btn_class = "btn btn-warning"; }
					if($linkedin == "") { $lnkin_btn_class = "btn btn-warning"; }										
					$arm = Armanagement::where('location', session('user')->customer_homeportal)->where('preferred', 'YES')->first();					
					$cstm = User::where('customer_id', $csid)->update(['customer_homeurl' => $arm->domainname]);					
					$numOfAds = Advertisement::where('customer_id', $csid)->count();					
					$numOfArticle = Article::where('customer_id', $csid)->count();
					$numOfEvent = Event::where('customer_id', $csid)->count();
					$numOfImages = Photo::where('customer_id', $csid)->count();
					$numOfBanners = Banner::where('customer_id', $csid)->count();
					$numOfPortraits = Portrait::where('customer_id', $csid)->count();
					$numOfLogos = Logo::where('customer_id', $csid)->count();	
					$expired_article = 'no';
					$now = Carbon::now();
					$articles = Article::where('customer_id', $csid)->get();
					foreach($articles as $article) {
						$xd = new Carbon($article->expiry_date);
						if($xd > $now) {
							$expired_article = 'yes';
						}
					}
					try {
					  $portrait = Portrait::where('customer_id', $csid)->where('primary_portrait', 'Yes')->firstOrFail();			  			  
					  $profile_image = asset('publicimages/portraits/' . $portrait->filename); 
					  $plink = route('home');
					} catch (ModelNotFoundException $ex) {
					  $profile_image = asset('images/noimage.png');
					  $plink = route('portraits');
					}
					try {
					  $logo = Logo::where('customer_id', $csid)->where('primary_logo', 'Yes')->firstOrFail();	
					  $primary_logo = asset('publicimages/logos/' . $logo->filename); 
					} catch (ModelNotFoundException $ex) {
					  $primary_logo = 'none';					  
					}								
					if(session('user')->customer_status == "DELETE") {
						$cstatus = "Your Account has been scheduled for Delete";
					}
					$clevel = session('user')->customer_level;
					$ad_bg = $article_bg = $portrait_bg = $membership_bg = $event_bg = $photo_bg = $banner_bg = $logo_bg = 'bg-orange';	
					if($clevel != 'Local Resident') {
						$membership_bg = 'bg-green';
					}
					if($numOfLogos > 0) {
						$logo_bg = 'bg-green';
					}
					if($numOfImages > 0) {
						$photo_bg = 'bg-green';
					}
					if($numOfBanners > 0) {
						$banner_bg = 'bg-green';
					}
					if($numOfEvent > 0) {
						$event_bg = 'bg-green';
					}
					if($numOfArticle > 0) {
						$article_bg = 'bg-green';
					}
					if($numOfPortraits > 0) {
						$portrait_bg = 'bg-green';
					}
					if($expired_article == 'yes') {
						$article_bg = 'bg-red';
					}
					if($numOfAds > 0) {
						$ad_bg = 'bg-green';
					}
					if(Advertisement::where('customer_id', $csid)->where('ad_status', 'DELETE')->count() > 0) {
						$ad_bg = 'bg-red';
					}
					return view('admin.home', [
						'title' => 'Homepage', 						
						'ad_bg' => $ad_bg,		
						'article_bg' => $article_bg,
						'portrait_bg' => $portrait_bg,
						'membership_bg' => $membership_bg,
						'event_bg' => $event_bg,
						'photo_bg' => $photo_bg,
						'banner_bg' => $banner_bg,
						'logo_bg' => $logo_bg,
						'cstatus' => $cstatus, 
						'numOfAds' => $numOfAds, 						
						'numOfImages' => $numOfImages, 
						'numOfArticle' => $numOfArticle, 
						'numOfEvent' => $numOfEvent, 
						'numOfBanners' => $numOfBanners, 
						'numOfPortraits' => $numOfPortraits, 
						'numOfLogos' => $numOfLogos,			
						'email_btn_class' => $email_btn_class, 
						'mobile_btn_class' => $mobile_btn_class, 
						'profile_image' => $profile_image, 	
						'primary_logo' => $primary_logo,
						'fb_btn_class' => $fb_btn_class, 
						'twt_btn_class' => $twt_btn_class, 				
						'invalids' => $invalids,
						'message' => $message,
						'plink' => $plink,
						'lnkin_btn_class' => $lnkin_btn_class, 
						'runningbg' => session('runningbg')
					]);									
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {				
				return redirect('login')->with('loc', $newloc)->with('url', $newurl)->with('viewbg', $newbg)->with('uri', $newuri)->with('rootpath', $newrootpath);				
			}
    }
	public function marketing() {
		if(self::isLogin()) {
			try {
				return view('admin.marketing', [
					'title' => 'Marketing Tools', 
					'runningbg' => session('runningbg')
				]);	
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
			return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
		} 
	}
	public function paypal_data() {
        $details = PaymentDetail::where('customer_id', session('user')->customer_id);
        return Datatables::of($details)			
            ->addColumn('payment_status', function ($detail) {
				$stat = '<span class="badge bg-red">cancelled</span>';
				if($detail->payment_status == "Active") {
					$stat = '<span class="badge bg-green">active</span>';
				}
                return '<center>'.$stat.'</center>';		
			})->addColumn('date_paid', function($detail) {				
				$dt = '';
				if($detail->date_paid != null) {
					$dt = new Carbon($detail->date_paid);	
					$dt = $dt->format('d/m/Y');
				}
                return '<center>'.$dt.'</center>';
			})->rawColumns(['payment_status', 'date_paid'])->make(true);
    }
	public function manage_paypal(Request $request) {		
		try {
			$cntr = PaymentDetail::where('customer_id', session('user')->customer_id)->count();
			return view('admin.payments', ['title' => 'Paypal Payments', 'cntr' => $cntr, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function errorFound($errorMessage) {			
        return view('admin.general_error', ['title' => 'Error Found', 'status' => $errorMessage, 'runningbg' => session('runningbg')]);
	}
	
    public static function isLogin() {
        if(session('loggedin') != null) {
                if(session('loggedin') == "no"){
                        return false;
                }
                return true;
        } else {
                return false;
        }
    }
	public function validateEmail() {
		try {
			$to = session('user')->customer_email;
			$location = session('user')->customer_homeportal;
			$name = session('user')->customer_name . " " . session('user')->customer_surname;
			$password = session('user')->customer_password;
			$from = "admin@australianregionalnetwork.com";
			$headers = "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: $from";		
			$template = EmailTemplate::where("id", 1)->first();
			$cc = hashToMD5($password);		
			$cl = route('email.confirmation', ['email' => $to, 'cc' => $cc]);			
			$subject = $template->emailvalidation_subject;		
			$subject = str_replace_first("{customer_name}", $name, $subject);	
			$subject = "&#9733; " . $subject;	
			$subject = htmlEntityDecode($subject, ENT_COMPAT, 'UTF-8');
			$subject = '=?UTF-8?B?' . base64Encode($subject) . '?='; 			
			$body = htmlSpecialCharsDecode($template->emailvalidation_content);	
			$body = str_replace_first("{customer_name}", $name, $body);
			$body = str_replace_first("{customer_homeportal}", $location, $body);
			$body = str_replace_first("{emailconfirmationlink}", $cl, $body);
			$body = str_replace_first("{customer_email}", $to, $body);				
			$ml = @mail($to, $subject, $body, $headers, "-f " . $from);
			if(!$ml) {
				return view('admin.mail_failed', ['title' => 'Email validation failed', 'runningbg' => session('runningbg')]);
			} else {
				return view('admin.mailed', ['title' => 'Email validation successful', 'runningbg' => session('runningbg')]);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function confirmEmail($email, $cc) {
		try {
			$c = User::where('customer_email', $email)->update(['customer_emailvalidated' => 1]);
			$user = User::where('customer_email', $email)->first();
			$template = EmailTemplate::where("id", 1)->first();
			$link = url('/'). "/?loc=" . $user->customer_currentportal . "&url=" . $user->customer_currenturl;
			$body = htmlSpecialCharsDecode($template->customerwelcome_content); 
			$body = str_replace_first("Click here", "<a href='{$link}'>Click here</a>", $body);	
			$body = str_replace_first("to Login", "for your homepage", $body);
			session(['user' => $user]);
			session(['loggedin' => 'yes']);
			return view('admin.confirmation_successful', [
				'title' => 'Email confirmation successful', 			
				'body' => $body,
				'runningbg' => session('runningbg')
			]);		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function mobile() {
		if(self::isLogin()) {
            return view('admin.mobile', ['title' => 'Admin Mobile Page', 'runningbg' => session('runningbg')]);
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }        
    }   
	public function post_mobile(Request $request) {		
			if(self::isLogin()) {
				try {
					$rt = route('mobile', ['email' => '']);
					$mobile = $request->input('mobile', '');	
					$fc = new FrontController();
					if($fc->getMobileLength($mobile) == "04" || $fc->getMobileLength($mobile) == "4") {	
						$SMS_key = mt_rand(100001, 999999);
						$SMS_success = $fc->sendSMSCode($mobile, $SMS_key);
						if($SMS_success == "NO" || $SMS_success == "EMPTY") {
								return view('site.send_error', ['title' => 'Error sending sms ...', 'route' => $rt, 'runningbg' => session('runningbg')]);
						} else {
								return view('admin.sent', ['title' => 'Code Area', 'SMS_key' => $SMS_key, 'mobile' => $mobile, 'runningbg' => session('runningbg')]);
						}	
					} else {
						return view('site.send_error', ['title' => 'Invalid mobile phone number ...', 'route' => $rt, 'runningbg' => session('runningbg')]);
					}
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			} 		
    }
	public function mobile_confirmed(Request $request) {		
			if(self::isLogin()) {
				try {
					$right_code = $request->input('SMS_key', '');
					$code = $request->input('code', '');
					$mobile = $request->input('mobile', '');				
					$rt = route('mobile', ['email' => '']);
					if($code == $right_code){	
						$fc = new FrontController();
						$mobile2 = substr($mobile, -9);
						if($fc->getMobileLength($mobile) == "0" || $fc->getMobileLength($mobile) == 0 || strlen($mobile) == 9) {
							$mobile2 = '0'.substr($mobile, -9);
						}
						$data = [
							'customer_mobile' => $mobile2,
							'customer_mobilevalidated' => 1,
						];
						$uid = session('user')->customer_id;
						$c = User::where('customer_id', $uid)->update($data);
						$user = User::where('customer_id', $uid)->first();
						session(['user' => $user]);
						return redirect()->route('home');					
					} else {
						return view('admin.sent', ['title' => 'Wrong code.', 'mobile' => $mobile, 'SMS_key' => $right_code, 'runningbg' => session('runningbg')]);				
					}
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}		
    }
    public function settings() {		
		if(self::isLogin()) {
			try {
				$user = User::where('customer_id', session('user')->customer_id)->first();
				$countries = Country::all();			
				return view('admin.settings', ['title' => 'Account Settings', 'user' => $user, 'countries' => $countries, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
			return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
		}    		
    }    
    public function profile() {		
		if(self::isLogin()) {			
			try {
				$user = User::where('customer_id', session('user')->customer_id)->first();			
				return view('admin.profile', ['title' => 'Profile Settings', 'user' => $user, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
			return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
		}    		
    }
    public function update_profile(Request $request, $id) {
		$v = $request->validate([
			'customer_facebook' => ['string', 'nullable', 'max:100', new Facebook],				
			'customer_twitter' => ['string', 'nullable', 'max:100', 'regex:/http(s)?:\/\/(.*\.)?twitter\.com\/[A-z0-9_]+\/?/'],
			'customer_linkedin' => ['string', 'nullable', 'max:100', 'regex:/^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)/'],
			'customer_pwebsite' => ['string', 'nullable', 'max:100', 'regex:/(http|https|ftp):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/'],
			'customer_cwebsite' => ['string', 'nullable', 'max:100', 'regex:/(http|https|ftp):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/'],
			'customer_bwebsite' => ['string', 'nullable', 'max:100', 'regex:/(http|https|ftp):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/'],                     
		]);
        try {			
			$data = [
				'customer_facebook' => $request->input('customer_facebook', ''),
				'customer_twitter' => $request->input('customer_twitter', ''),
				'customer_linkedin' => $request->input('customer_linkedin', ''),
				'customer_pwebsite' => $request->input('customer_pwebsite', ''),
				'customer_cwebsite' => $request->input('customer_cwebsite', ''),
				'customer_bwebsite' => $request->input('customer_bwebsite', ''),
				'customer_bdescription' => $request->input('customer_bdescription', ''),
				'customer_description' => $request->input('customer_description', ''),                       
			];
			$c = User::where('customer_id', $id)->update($data);
			return redirect()->route('home');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function validateAddress($address) {
		$decoded = $this->decodeBase58($address);
		$d1 = hash("sha256", substr($decoded, 0, 21) , true);
		$d2 = hash("sha256", $d1, true);
		if (substr_compare($decoded, $d2, 21, 4)) {
			throw new SkippycoinException("Invalid Wallet Address");
		}
		return true;		
	}	
	public function decodeBase58($input) {
		$alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
		$out = array_fill(0, 25, 0);
		for ($i = 0; $i < strlen($input); $i++) {
			if (($p = strpos($alphabet, $input[$i])) === false) {
				throw new SkippycoinException("Invalid Wallet Address");				
			}
			$c = $p;
			for ($j = 25; $j--;) {
				$c+= (int)(58 * $out[$j]);
				$out[$j] = (int)($c % 256);
				$c/= 256;
				$c = (int)$c;
			}
			if($c != 0) {
				throw new SkippycoinException("Invalid Wallet Address");
			}
		}
		$result = "";
		foreach($out as $val) {
			$result.= chr($val);
		}
		return $result;
    }
	public function checkUserUniqueness($id, $field, $value) {
		return User::where('customer_id', '!=', $id)->where($field, '!=', '')->where($field, $value)->count();
	}
	public function checkMobileUniqueness($id, $field, $mobile) {
		if(Str::startsWith($mobile, '0')) {
			$mobile2 = Str::replaceFirst('0', '', $mobile);	
		} else {
			$mobile2 = '0' . $mobile;
		}
		$cntr = 0;
        if(User::where('customer_id', '!=', $id)->where($field, '!=', '')->where($field, $mobile)->count() > 0) {
			$cntr = 1;
		} else {
			if(User::where('customer_id', '!=', $id)->where($field, '!=', '')->where($field, $mobile2)->count() > 0) {
				$cntr = 1;
			}
		}
		return $cntr;
	}
	public function updateFailed($errorMessage) {		
        return view('admin.updates', ['title' => 'Edit settings failed', 'status' => $errorMessage, 'runningbg' => session('runningbg')]);
	}	
    public function update_settings(Request $request, $id) {
		try {
			$v = $request->validate([
				'customer_nickname' => 'string|nullable|max:60',
				'customer_title' => 'string|nullable|max:15',
				'customer_tax_id' => 'string|nullable|max:11',
				'customer_name' => 'string|nullable|max:50',
				'customer_middlename' => 'string|nullable|max:50',
				'customer_surname' => 'string|nullable|max:60',
				'customer_position' => 'string|nullable|max:50',
				'customer_businessname' => 'string|nullable|max:50',
				'customer_password' => 'string|nullable|max:30',
				'customer_email' => 'string|nullable|max:50',
				'customer_phone' => 'string|nullable|max:20',
				'customer_mobile' => 'string|nullable|max:20',
				'customer_address_1' => 'string|nullable|max:50',
				'customer_address_2' => 'string|nullable|max:50',
				'customer_city' => 'string|nullable|max:40',
				'customer_state' => 'string|nullable|max:40',
				'customer_postcode' => 'string|nullable|max:10',		
			]);
			$email = $request->input('customer_email', '');
			$mobileno = $request->input('customer_mobile', '');
			if($this->checkUserUniqueness($id, 'customer_email', $email) > 0) {
				return redirect()->route('update.failed', ['errorMessage' => 'Email already in use.']);				
			}
			if($this->checkMobileUniqueness($id, 'customer_mobile', $mobileno) > 0) {				
				return redirect()->route('update.failed', ['errorMessage' => 'Mobile number already in use.']);
			}
			$address = $request->input('customer_skcwallet', '');
			if($address != "") {				
				if($this->validateAddress($address)) {			
					
				} else {
					return redirect()->route('skippycoin.failed', ['errorMessage' => 'failed']);
				} 
			}			
			$mb = $eml = 1;
			$oldmail = session('user')->customer_email;		
			if($email != $oldmail) {
				$eml = 0;
			}
			$oldmobile = session('user')->customer_mobile;			
			if($mobileno != $oldmobile) {
				$mb = 0;
			}
			$data = [
				'customer_nickname' => $request->input('customer_nickname', ''),
				'customer_title' => $request->input('customer_title', ''),
				'customer_tax_id' => $request->input('customer_tax_id', ''),
				'customer_name' => $request->input('customer_name', ''),
				'customer_middlename' => $request->input('customer_middlename', ''),
				'customer_surname' => $request->input('customer_surname', ''),
				'customer_position' => $request->input('customer_position', ''),
				'customer_businessname' => $request->input('customer_businessname', ''),
				'customer_password' => $request->input('customer_password', ''),
				'customer_email' => $email,
				'customer_phone' => $request->input('customer_phone', ''),
				'customer_mobile' => $mobileno,
				'customer_address_1' => $request->input('customer_address_1', ''),
				'customer_address_2' => $request->input('customer_address_2', ''),
				'customer_city' => $request->input('customer_city', ''),
				'customer_state' => $request->input('customer_state', ''),
				'customer_postcode' => $request->input('customer_postcode', ''),
				'customer_country' => $request->input('customer_country', ''),
				'customer_skcwallet' => $address,
				'customer_mobilevalidated' => $mb,
				'customer_emailvalidated' => $eml,
			];
			$c = User::where('customer_id', $id)->update($data);
			$user = User::where('customer_id', $id)->first(); 
			session(['user' => $user]);
			return redirect()->route('home');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function membership() {
        if(self::isLogin()) {
			try {
				$level = session('user')->customer_level;
				$cid = session('user')->customer_id;
				$location = session('user')->customer_homeportal;
				$current = session('user')->customer_currentportal;
				$img1 = asset('images/redsidewinderright.gif');
				$img2 = asset('images/redsidewinderleft.gif');
				$emlicon = asset('publicimages/email.gif');
				return view('admin.membership', ['level' => $level, 'current' => $current, 'emlicon' => $emlicon, 'img1' => $img1, 'img2' => $img2, 'cid' => $cid, 'location' => $location, 'title' => 'Membership Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
    public function localresident() {
        if(self::isLogin()) {	
			try {
				$homeurl = session('user')->customer_homeurl;	
				$img1 = asset('images/bullet.png');
				return view('admin.localresident', ['homeurl' => $homeurl, 'img1' => $img1, 'title' => 'Local Resident Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
    public function communityleader() {
        if(self::isLogin()) {	
			try {
				$level = session('user')->customer_level;
				$bullet = asset('images/bullet.png');
				$cid = session('user')->customer_id;
				$homeurl = session('user')->customer_homeurl;	
				$img1 = asset('commonimages/redsidewinderright.gif');
				return view('admin.communityleader', ['level' => $level, 'img1' => $img1, 'homeurl' => $homeurl, 'cid' => $cid, 'bullet' => $bullet, 'title' => 'Community Leader Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function localbusiness() {
        if(self::isLogin()) {	
			try {
				$level = session('user')->customer_level;
				$bullet = asset('images/bullet.png');
				$cid = session('user')->customer_id;
				$homeurl = session('user')->customer_homeurl;	
				$img1 = asset('commonimages/redsidewinderright.gif');
				return view('admin.localbusiness', ['level' => $level, 'img1' => $img1, 'homeurl' => $homeurl, 'cid' => $cid, 'bullet' => $bullet, 'title' => 'Local Business Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function nationalbusiness() {
        if(self::isLogin()) {	
			try {
				$level = session('user')->customer_level;
				$bullet = asset('images/bullet.png');
				$cid = session('user')->customer_id;
				$homeurl = session('user')->customer_homeurl;	
				$img1 = asset('commonimages/redsidewinderright.gif');
				return view('admin.nationalbusiness', ['level' => $level, 'img1' => $img1, 'homeurl' => $homeurl, 'cid' => $cid, 'bullet' => $bullet, 'title' => 'National Business Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function sponsorship() {
        if(self::isLogin()) {		
			try {
				try {
				  $sponsor = Sponsorship::where('sponsoree', session('user')->customer_id)->firstOrFail();	
				  $sponsor_data = User::where('customer_id', $sponsor->sponsor)->first();
				  $agreement = $sponsor->agreement;
				  $key = $sponsor->key;
				  $status = $sponsor->status;
				} catch (ModelNotFoundException $ex) {
				  $sponsor = $sponsor_data = $agreement = $status = $key = "Not Found";
				}
				try {
				  $sponsor3 = Sponsorship::where('sponsor', session('user')->customer_id)->firstOrFail();
				  $sponsoree_data = User::where('customer_id', $sponsor3->sponsoree)->first();
				  $agreement3 = $sponsor3->agreement;
				  $sponsoree3 = $sponsor3->sponsoree;
				  $key3 = $sponsor3->key;
				  $status3 = $sponsor3->status;	
				} catch (ModelNotFoundException $ex) {
				  $sponsor3 = $sponsoree_data = $agreement3 = $sponsoree3 = $key3 = $status3 = "Not Found";			  	
				}
				$level = session('user')->customer_level;			
				$cid = session('user')->customer_id;
				$homeportal = session('user')->customer_homeportal;
				$homeurl = session('user')->customer_homeurl;	
				$img1 = asset('commonimages/redsidewinderright.gif');
				$emailimg = asset('publicimages/email.gif');
				$img2 = asset('commonimages/redsidewinderright.gif');
				return view('admin.sponsorship', 
					['level' => $level, 
					'agreement3' => $agreement3,
					'sponsoree3' => $sponsoree3,
					'key3' => $key3,
					'status3' => $status3,				
					'sponsor_data' => $sponsor_data, 
					'sponsoree_data' => $sponsoree_data, 
					'agreement' => $agreement,
					'key' => $key,
					'status' => $status,
					'emailimg' => $emailimg, 
					'sponsor' => $sponsor, 
					'sponsor3' => $sponsor3, 
					'homeportal' => $homeportal, 
					'img1' => $img1, 
					'img2' => $img2,
					'homeurl' => $homeurl, 
					'cid' => $cid, 				
					'title' => 'Sponsorship Page', 
					'runningbg' => session('runningbg')
					]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function getDateDecrypted() {
		return $this->datedecrypted;
	}	
	public function getKeyepochtime() {
		return $this->keyepochtime;
	}
	public function getCKey() {
		return $this->getkey;
	}
	public function getCCID() {
		return $this->getcid;
	}	
	public function setCKey($k) {
		if(isset($k)){
			$key = $k;		
			$key = substr($key, 0, 20);  		
			$key = preg_replace('/[^0-9A-Za-z]/i', '', $key);		
			$key =  strtoupper($key);
		} else {
			$key = '1';		
		}
		$this->getkey = $key;
	}
	public function setCCID($id) {
		if(isset($id)){ 
			$cid = $id;
			$cid = substr($cid, 0, 14);  		
			$cid = preg_replace('/[^0-9A-Z]/i', '', $cid);		
		} else {
			$cid = 'FAIL';		
		}
		$this->getcid = $cid;
	}
	public function getSponsor($key) {
		$base23num = '';
		$decrypted = '';
		$array = str_split($key);
		foreach($array as $char) {
			$exchange = '';
			if ($char === "3"){ $exchange = "0";}
			if ($char === "4"){ $exchange = "1";}
			if ($char === "6"){ $exchange = "2";}
			if ($char === "7"){ $exchange = "3";}
			if ($char === "8"){ $exchange = "4";}
			if ($char === "9"){ $exchange = "5";}
			if ($char === "A"){ $exchange = "6";}
			if ($char === "C"){ $exchange = "7";}
			if ($char === "E"){ $exchange = "8";}
			if ($char === "F"){ $exchange = "9";}
			if ($char === "G"){ $exchange = "A";}
			if ($char === "H"){ $exchange = "B";}
			if ($char === "J"){ $exchange = "C";}
			if ($char === "K"){ $exchange = "D";}
			if ($char === "L"){ $exchange = "E";}
			if ($char === "M"){ $exchange = "F";}
			if ($char === "N"){ $exchange = "G";}
			if ($char === "P"){ $exchange = "H";}
			if ($char === "R"){ $exchange = "I";}
			if ($char === "T"){ $exchange = "J";}
			if ($char === "W"){ $exchange = "K";}
			if ($char === "X"){ $exchange = "L";}
			if ($char === "Y"){ $exchange = "M";}
			$base23num = $base23num . $exchange;
		}
		$decrypted = base_convert($base23num, 23, 10);		
		$this->datedecrypted = substr($decrypted, 0, -12);
		$this->keyepochtime = (($this->datedecrypted+16314)*86400);
		$sponsor =  '4C' . substr($decrypted, -12);
		return $sponsor;
	}
	public function getEpockDay() {
		$epoch = Carbon::now(new DateTimeZone('U'));			
		$epoch = $epoch - 34200;		
		$epochday = round($epoch / 86400);
		$smallepochday = $epochday-16314;
		return $smallepochday;
	}
	public function sponsorshipkey(Request $request) {
		if(self::isLogin()) {
			try {
				$key = $request->input('key', '');
				$cid = session('user')->customer_id;
				$this->setCKey($key);
				$this->setCCID($cid);
				$id = $this->getCCID();
				$ckey = $this->getCKey();
				$sponsor = $this->getSponsor($ckey);
				$smallepochday = $this->getEpockDay();
				$date_decrypted = $this->getDateDecrypted();
				$dtsmallepochday = new Carbon($smallepochday);
				$dtdate_decrypted = new Carbon($date_decrypted);
				$epochday = $dtsmallepochday - $dtdate_decrypted;		
				$postdecrypt = $request->query('decrypt');
				try {
				  $sponsor_result = User::where('customer_id', $sponsor)				
					->where(function ($query) use ($sponsor) {                                
						$query->where('customer_level', 'Local Business')                                        
								->orWhere('customer_level', 'National Business')
								->orWhere('customer_level', 'Administrator');                                        
					})->firstOrFail();			 
				} catch (ModelNotFoundException $ex) {
				  $sponsor_result = "Not Found";			  	
				}			
				try {
					$result = Sponsorship::where('sponsor', $sponsor)->where('sponsoree', $cid)->firstOrFail();
				} catch (ModelNotFoundException $ex) {
					$result = "Not Found";			  	
				}
				$dt = Carbon::now();
				$sid = $dt->year . $dt->month . $dt->day . $dt->hour . $dt->minute . $dt->second;
				$agreement = '4S' . $sid;	
				$info = [
					'agreement' => $agreement, 
					'sponsor' => $sponsor,
					'sponsoree' => $cid, 
					'key' => $ckey,
					'status' => 'NEW', 
				];
				$stored = Sponsorship::create($info);	
				$data = [
						'runningbg' => session('runningbg'),
						'title' => 'Sponsorship Key Page', 
						'getkey' => $ckey, 
						'getcid' => $id,  
						'agreement' => $agreement, 
						'status' => 'NEW', 
						'sponsoree' => $cid, 
						'stored' => $stored,
						'postdecrypt' => $postdecrypt,  
						'sponsor_result' => $sponsor_result, 
						'date_decrypted' => $date_decrypted,
						'keyepochtime' => new Carbon($this->getKeyepochtime()),
						'epochday' => $epochday,
						'result' => $result,
						'sponsor' => $sponsor
				];			
				return view('admin.sponsorshipkey', $data);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
	}
	public function delete() {
		if(self::isLogin()) {	
			try {
				$id = session('user')->customer_id;
				return view('admin.delete_account', ['title' => 'Delete Account', 'id' => $id, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
	}
	public function cancel_delete() {		
		if(self::isLogin()) {	
			try {
				$id = session('user')->customer_id;
				$c = User::where('customer_id', $id)->update(['customer_status' => 'NEW', 'date_deleted' => null]);
				$ad = Advertisement::where('customer_id', $id)->update(['ad_status' => 'ONLINE']);
				$ar = Article::where('customer_id', $id)->update(['article_status' => 'ONLINE']);
				$evt = Event::where('customer_id', $id)->update(['event_status' => 'ONLINE']);
				$user = User::where('customer_id', $id)->first();
				session(['user' => $user]); 
				return redirect()->route('home');
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
			return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
		}		
	}
	public function destroy(Request $req, $id) {      	
		try {
			$now = Carbon::now();
			$c = User::where('customer_id', $id)->update(['customer_status' => 'DELETE', 'date_deleted' => $now]);
			$ad = Advertisement::where('customer_id', $id)->update(['ad_status' => 'OFFLINE']);
			$ar = Article::where('customer_id', $id)->update(['article_status' => 'OFFLINE']);
			$evt = Event::where('customer_id', $id)->update(['event_status' => 'OFFLINE']);
			$user = User::where('customer_id', $id)->first();
			$name = $user->customer_name . " " . $user->customer_surname;
			$from = "admin@australianregionalnetwork.com";
			$headers = "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: $from";				
			$subject = "Your Account is scheduled for Delete";
			$subject = "&#9733; " . $subject;	
			$subject = htmlEntityDecode($subject, ENT_COMPAT, 'UTF-8');
			$subject = '=?UTF-8?B?' . base64Encode($subject) . '?=';
			$body = "Dear $name,&lt;br&gt;";
			$body .= "&lt;p&gt;This is to inform you that your Australian Regional Network account is scheduled for Delete.&lt;/p&gt;&lt;br&gt;";
			$body .= "&lt;p&gt;All Articles, Ads, Events and Images attached to your account will be removed!&lt;/p&gt;";
			$body .= "&lt;p&gt;Community Leader and Business accounts will cease to accumulate Australian Skippycoin!&lt;/p&gt;&lt;br&gt;";
			$body .= "&lt;p&gt;Account Cleanup runs around Midnight Central Australia Time.&lt;/p&gt;";
			$body .= "&lt;p&gt;If you wish to keep your Account Log in well before Midnight i.e NOW and choose CANCEL DELETE.&lt;/p&gt;&lt;br&gt;";
			$body .= "Regards&lt;br&gt;The Australian Regional Network&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;";
			$content = htmlSpecialCharsDecode($body);
			$ml = @mail($user->customer_email, $subject, $content, $headers, "-f " . $from);
			if(!$ml) {
				return redirect()->route('home');
			} else {
				return $this->logout($req);
			}        
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function logout(Request $request) {
		try {
			$usr = User::where('customer_id', session('user')->customer_id)->first();
			$usr->fresh();
			$url = 'http://'. $usr->customer_homeurl;
			$request->session()->forget('loggedin');		
			$request->session()->forget('user');
			return redirect($url);		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
