<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Armanagement;
use App\User;
use App\Domain;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\GeneralException;
use Storage;

class MoveController extends Controller
{
    public function index() {
        if(AdminController::isLogin()) {	
			try {
				$states = [
					"ACT" => "ACT",
					"NSW" =>"New South Wales",
					"NT" => "Northern Territory",					
					"QLD" => "Queensland",
					"QLD-NSW" => "QLD-NSW Border",
					"SA" => "South Australia",
					"TAS" => "Tasmania",																			
					"VIC" => "Victoria",					
					"VIC-NSW" => "VIC-NSW Border",
					"WA" => "Western Australia"
				];
                return view('admin.move', ['states' => $states, 'hp' => session('user')->customer_homeportal, 'cp' => session('location'), 'title' => 'Move Portal Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function getRegions(Request $request) {
		try {
			$state = $request->input('state');		
			$regions = Armanagement::where('shortstate', $state)->where('preferred', 'YES')->orderBy('localname', 'asc')->get();
			return $regions;		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function gotoRegion(Request $request) {
		try {
			$region = $request->input('region');		
			$request->session()->forget('runningbg');
			$request->session()->forget('serveruri');
			try {
			  $domain = Armanagement::where('domainname', $region)->where('preferred', 'YES')->firstOrFail();
			  $status = "success";
			  $cid = session('user')->customer_id;
			  $lc = new LoginController();
			  $location = $domain->location;	
			  $flavor = $domain->flavor;
			  $longstate = $domain->longstate;
			  $localname = $domain->localname;
			  $usr = User::where('customer_id', $cid)->update(['customer_currentportal' => $location, 'customer_currenturl' => $domain->domainname]);
			  $user = User::where('customer_id', $cid)->first();
			  session(['user' => $user]);		  
			} catch (ModelNotFoundException $ex) {
			  $domain = "Not Found";
			  $status = "failed";
			  $bg = "commonimages/backgrounds/default/default.jpg";
			  $surl = "broome.city";
			  $location = "Broome-WA";
			  $flavor= $longstate = $localname = "dummy";		 
			}
			$surl = $lc->generateSession($location, $region);
			$bg = $this->getBackground($location, $surl, $longstate, $localname);		
			return response()->json(['status' => $status, 'loc' => $location, 'url' => $surl, 'viewbg' => $bg]);	
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function getBackground($location, $flavor, $longstate, $localname) {
		try {
			$bgcreditstring = "";
			$bgcrediturl = "";        
			$defaultbg = "commonimages/backgrounds/default/default.jpg";
			$bestdir = 'commonimages/backgrounds/locations/' . $location;            
			$bestbg = "commonimages/backgrounds/locations/" . $location . ".jpg";
			$flavorbg = "commonimages/backgrounds/flavors/" . $flavor . ".jpg";            
			$bgfiles = glob($bestdir . '/*.jpg');
			if ($bgfiles) {               
				if (count($bgfiles) > 1) {
					$sorted = array_sort($bgfiles);
					foreach($bgfiles as $bgf) {
						$strtmp = (string)$bgf;
						$contains = str_contains($strtmp, '001');
						if($contains) {
							$runningbg = $bgf;
						} else {
							$runningbg = $bgfiles[0];
						}
					}									
				}			                  
			} else if (file_exists($flavorbg)) {
				$runningbg = $flavorbg;      
				$bgcredit = str_replace(".jpg", ".txt", $runningbg);
				if (file_exists($bgcredit)) {				
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
			session(['bgcrediturl' => $bgcrediturl]);
			session(['bgcreditstring' => $bgcreditstring]);
			session(['runningbg' => $runningbg]);
			session(['longstate' => $longstate]);
			session(['location' => $location]);   
			session(['localname' => $localname]);
			return $runningbg;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function movehere(Request $request) {
		try {
			$cid = session('user')->customer_id;
			$portal = $request->input('portal');	
			$dom = Armanagement::where('location', $portal)->where('preferred', 'YES')->first();
			$usr = User::where('customer_id', $cid)->update(['customer_homeportal' => $portal, 'customer_homeurl' => $dom->domainname]);
			$user = User::where('customer_id', $cid)->first();
			session(['user' => $user]);
			return $user;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function backhome(Request $request) {
		try {
			$portal = $request->input('portal');	
			$cid = session('user')->customer_id;
			$dom = Armanagement::where('location', $portal)->where('preferred', 'YES')->first();			
			$safeloc = preg_replace("/[^a-zA-Z0-9-]/", "", $portal);
			$safeurl = preg_replace("/[^a-zA-Z0-9-.]/", "", $dom->domainname);
			session(['location' => $safeloc]);    
			session(['url' => $safeurl]);
			$location = $dom->location;
			$flavor = $dom->flavor;
			$longstate = $dom->longstate;
			$localname = $dom->localname;
			$bgcreditstring = "";
			$bgcrediturl = "";
			$defaultbg = "commonimages/backgrounds/default/default.jpg";
			$bestdir = 'commonimages/backgrounds/locations/' . $location;            
			$bestbg = "commonimages/backgrounds/locations/" . $location . ".jpg";
			$flavorbg = "commonimages/backgrounds/flavors/" . $flavor . ".jpg";            
			$bgfiles = glob($bestdir . '/*.jpg');
			if(file_exists($bestbg)) {
				 $runningbg = $bestbg;
			} else if ($bgfiles) {
				if (count($bgfiles) > 1) {
					shuffle($bgfiles);					
				}
				$runningbg = $bgfiles[0];   					
			} else if (file_exists($flavorbg)) {
				$runningbg = $flavorbg;
				$bgcredit = str_replace(".jpg", ".txt", $runningbg);
				if (file_exists($bgcredit)) {					
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
			
			session(['bgcrediturl' => $bgcrediturl]);
			session(['bgcreditstring' => $bgcreditstring]);				
			session(['runningbg' => $runningbg]);
			session(['longstate' => $longstate]);
			session(['location' => $location]);   
			session(['localname' => $localname]);		  
			session(['server' => $safeurl]);			
			$usr = User::where('customer_id', $cid)->update(['customer_currentportal' => $portal, 'customer_currenturl' => $dom->domainname]);
			$user = User::where('customer_id', $cid)->first();
			session(['user' => $user]);
			//return response()->json(['url' => $surl, 'viewbg' => $bg]);	
			return $user;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
}
