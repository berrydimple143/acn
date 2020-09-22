<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Armanagement;
use App\Domain;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\Exceptions\GeneralException;
use Storage;

class LoginController extends Controller
{		
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }	
	public function login_with() {
		$loc = session('location');
		try {
		  $arwebsite = Armanagement::where('location', $loc)->firstOrFail();
		  $url = $arwebsite->domainname;
		} catch (ModelNotFoundException $ex) {		  
		  $url = "phillipisland.guide";
		}
		$rt = route('home'). "?loc=" . $loc . "&url=". $url;
		return redirect()->away($rt);		
	}
    public function index(Request $request) {
		try {			  
			$newloc = session('loc', '');
			$newurl = session('url', '');
			$newbg = session('viewbg', '');
			$newuri = session('uri', '');
			$newrootpath = session('rootpath', '');			
			$request->session()->forget(['pagecounter']);
			if($newloc != '' and $newurl != '') {
				session(['loc' => $newloc]);    
				session(['location' => $newloc]);    
				session(['url' => $newurl]); 
				session(['viewbg' => $newbg]);	
				session(['runningbg' => $newbg]);
				session(['uri' => $newuri]); 
				session(['rootpath' => $newrootpath]);				
				$server = $this->generateSession($newloc, $newurl);
				if(session('loggedin') == null) {
					session(['loggedin' => 'no']);    
				} else {
					if(session('loggedin') == "yes") {
						return redirect()->route('home');
					}
				}           
				try {
				  $arwebsite = Armanagement::where('domainname', $server)->firstOrFail();
				} catch (ModelNotFoundException $ex) {
				  $arwebsite = "Not Found";
				}
				$bg = $this->generateBackground($arwebsite, $server, $newbg, $newuri, $newrootpath);  		
				$menu = $this->generateMenu();    		
				return view('auth.login', [
					'title' => 'Homepage', 
					'runningbg' => $bg, 
					'newloc' => session('location', $newloc),
					'newurl' => session('url', $newurl),			
					'newuri' => $newuri,
					'newrootpath' => $newrootpath
				]);
			} else {
				return redirect()->away('https://ausreg.net');
			}  
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }

    public function login(Request $request) {
        try {
			$user = User::where('customer_email', $request->email)
                        ->where('customer_password', $request->password)->firstOrFail();     
                        //->where('customer_status', '!=', 'DELETE')->firstOrFail();          
			
        } catch (ModelNotFoundException $ex) {
          $user = 'Not Found';          
        }       
        if($user != "Not Found") {
			try {
				$data = [
					'customer_currentportal' => $request->newloc,
					'customer_currenturl' => $request->newurl
				];
				$c = User::where('customer_id', $user->customer_id)->update($data);			
				$usr = User::where("customer_id", $user->customer_id)->first();
				$ddel = new Carbon($usr->date_deleted);
				$now = Carbon::now();
				$expd = $ddel->addHours(24);
				if($usr->customer_status == "DELETE" and ($now->gt($expd))) {
					session(['loggedin' => 'no']);    					
					return redirect('login')->with('loc', $request->newloc)->with('url', $request->newurl)->with('viewbg', $request->runningbg)->with('uri', $request->newuri)->with('rootpath', $request->newrootpath);
				}
				session(['user' => $usr]);      
				session(['loggedin' => 'yes']);    
				return redirect()->route('home');	
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            session(['loggedin' => 'no']);                
			return redirect('login')->with('loc', $request->newloc)->with('url', $request->newurl)->with('viewbg', $request->runningbg)->with('uri', $request->newuri)->with('rootpath', $request->newrootpath);
        }
    }

    public function generateSession($unsafe_loc, $unsafe_url) {
        $safeurl = "broome.city";
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ipaddr = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //if(isset($unsafe_loc)) { 
            $gotloc = $unsafe_loc; 
            $safeloc = preg_replace("/[^a-zA-Z0-9-]/", "", $gotloc);
            //if(isset($unsafe_url)) { 
                $goturl = $unsafe_url; 
                $safeurl = preg_replace("/[^a-zA-Z0-9-.]/", "", $goturl);
                $loginparams = '?loc=' . $safeloc . '&url=' . $safeurl;  
            //}            
            session(['location' => $safeloc]);    
            session(['url' => $safeurl]); 
            session(['ipaddr' => $ipaddr]); 
            //session(['loginparams' => $loginparams]);           
        //}
        return $safeurl;
    }

    public function generateMenu() {  
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
				/*$logfile = "/var/www/html/australianregionalnetwork.com/control/errors/errors.htm";
				$handle = fopen($logfile, 'a+');
				fwrite ($handle, $error);
				fclose($handle);*/
			} 
			session(['imagefilename' => $imagefilename]);   
			session(['menuanimationstring' => $menuanimationstring]);  
			return $menuanimationstring; 
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	
	public function generateBackground($arsite, $server, $vbg, $uri, $rpath) {
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
				if ($bgfiles) {
					if(isset($oldviewbg)) {
						$viewbg = $oldviewbg;
						$viewbg = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]/)", '', $viewbg);
						if (in_array($viewbg, $bgfiles)) {
							$runningbg = $viewbg;
						}
					} else {
						if (count($bgfiles) > 1) {
							if (($currentpage == "/") or ($currentpage == "/index.php") or ($currentpage == "/View-Background.php")) {
							
							} else {    
								shuffle($bgfiles);
							}
						}
						$runningbg = $bgfiles[0];   
					}
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
}
