<?php

/* Note: All methods in this controller cannot be accessed or used without logging in first */

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Advertisement;
use App\AdsDirectory;
use App\Country;
use App\Banner;
use App\User;
use Illuminate\Support\Str;
use App\ArticleLocation;
use App\Armanagement;
use App\AdsCategory;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GeneaLabs\LaravelMaps\Facades\Map;
use App\Http\Controllers\AdminController;
use Youtube;
use Carbon\Carbon;
use App\Rules\Nolink;
use App\Exceptions\GeneralException;
use Storage;

class AdsController extends Controller {
	private $latitude;
	private $longitude;
	private $zoom;
	
    /* This method is responsible for viewing the list of created advertisements in tabular form */
    public function index() {
		if(AdminController::isLogin()) {
			try {
				$adCount = Advertisement::where('customer_id', session('user')->customer_id)->count();
				return view('admin.ads', ['title' => 'Advertisements Page', 'adCount' => $adCount, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}                
        } else {
			return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));                
        }
    }
    
    /* This method is responsible for  */
    public function data() {
        $ads = Advertisement::where('customer_id', session('user')->customer_id)->orderBy('ad_id', 'desc');
        return Datatables::of($ads)			
            ->addColumn('action', function ($ad) {
				$id = $ad->ad_id;				
				$slug = title_case(str_slug($ad->ad_directory, '-')) . "-Directory-" . title_case(str_slug($ad->ad_category, '-')) . "-" . $id . "#" . $id;									
				$adloc = $ad->ad_portal;
				if(!(Str::contains($adloc, '-'))) {
					$cntrl = Armanagement::inRandomOrder()->where('preferred', 'YES')->first();
				} else {
					$cntrl = Armanagement::where('location', $adloc)->where('preferred', 'YES')->first();
				}				
				$domain = $cntrl->domainname;
				$link = 'https://' . $domain. '/' .$slug;		
				$ban = "curl -X BAN https://" . $link;
				exec($ban);
				$ban2 = "curl -X BAN https://" . $domain . "/*";
				exec($ban2);		
                $buttons = '<center><a title="edit" href="' . route('ads.edit', ['id' => $id]) .'" class="btn btn-warning"><i class="fa fa-edit"></i></a>&nbsp;';
                $buttons .= '<a title="delete" href="' . route('ads.delete', ['id' => $id]) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a>&nbsp;';
                $buttons .= '<a title="Go to this advertisement" href="' . $link .'" class="btn btn-success"><i class="fa fa-search"></i></a></center>';            
				return $buttons;
			})->addColumn('ad_status', function($ad) {
				$stat = '<span class="badge bg-red">OFF</span>';
				if($ad->ad_status != "OFFLINE") {
					$stat = '<span class="badge bg-green">ON</span>';
				}
                return '<center>'.$stat.'</center>';
			})->rawColumns(['action', 'ad_status'])->make(true);
    }	
	public function slug($slug) {		
		try {
			$arr = explode("-", $slug);		
			$str = $arr[count($arr) - 1];
			$fr = explode("#", $str);	
			$id = $fr[0];
			$subject = $body = "";
			$banner_image = asset('images/noimage.png');
			try {
				$ad = Advertisement::where('ad_id', $id)->firstOrFail();
				if($ad->ad_banner != "") {
					$banner_image = public_path('publicimages/banners/' . $ad->ad_banner); 
				}			
				$subject = "Advertisement for ". $ad->ad_businessname;
				$body = $ad->ad_content;
			} catch (ModelNotFoundException $ex) {
							
			}			
			$map = $this->createMap("show", $ad);	
			$info = [
				'subject' => $subject,		
				'body' => $body,		
				'title' => 'Advertisement Show Page', 
				'banner_image' => $banner_image,
				'admap' => $ad->ad_map, 
				'latitude' => $this->getLatitude(), 
				'longitude' => $this->getLongitude(), 
				'zoom' => $this->getZoom(), 
				'runningbg' => session('runningbg')
			];
			return view('admin.ads_show', $info);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		} 		
    }
	public function limitExceeded() {
		$exceeded = 'no';
		$level = session('user')->customer_level;
		$numOfAds = Advertisement::where('customer_id', session('user')->customer_id)->count();
		if($level == "Local Resident" && $numOfAds > 0) {
			$exceeded = 'yes';
		}
		return $exceeded;
	}
	public function checkUserLevel($command) {
		$level = session('user')->customer_level;
		$msg = '';
		if($command == "add_ads") {		
			if($level == "Local Resident") {
				if(Advertisement::where('customer_id', session('user')->customer_id)->count() > 0) {
					$msg = "exceeded";
				} else {
					$email_validated = session('user')->customer_emailvalidated;
					$mobile_validated = session('user')->customer_mobilevalidated;
					if(!$mobile_validated or !$email_validated) {
						$msg = "not validated";
					} else {
						$msg = "validated";
					}
				}
			}
		} 
		return $msg;
	}
    public function select() {
        if(AdminController::isLogin()) {
			try {					
				if($this->checkUserLevel('add_ads') == 'not validated') {
					return view('admin.not_validated', ['title' => 'Email or mobile number not validated', 'runningbg' => session('runningbg')]);
				} else if($this->checkUserLevel('add_ads') == 'exceeded') {
					return view('admin.limit_exceeded', ['title' => 'Limit Exceeded Page', 'runningbg' => session('runningbg')]);
				} else {
					if($this->limitExceeded() == 'yes'){
						return view('admin.limit_exceeded', ['title' => 'Limit Exceeded Page', 'runningbg' => session('runningbg')]);
					} else {
						$community_ads = Advertisement::where('customer_id', session('user')->customer_id)
								->where('ad_stream', 'community')->count();
						$commercial_ads = Advertisement::where('customer_id', session('user')->customer_id)
								->where('ad_stream', 'commercial')->count();				
						session(['community_ads' => $community_ads]);
						session(['commercial_ads' => $commercial_ads]);
						return view('admin.ads_select', ['title' => 'Advertisements Page', 'runningbg' => session('runningbg')]);
					}
				}
				
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function selected($adtype) {		
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$countries = Country::all();
				$directories = AdsDirectory::all();
				$map = $this->createMap("add", "");					
				$locationHTML = $this->getPostLocation($adtype);
				$banners = Banner::where('customer_id', $cid)->orderBy('filename', 'desc')->get();	
				$numOfBanners = Banner::where('customer_id', $cid)->count();	
				$title = title_case($adtype) .' Advertisement Creator';
				$customer = User::where('customer_id', $cid)->first();
				$email_validated = $customer->customer_emailvalidated;
				$mobile_validated = $customer->customer_mobilevalidated;	
				$mobile_status = $restricted_route = $restrict_text = $email_status = "";
				$restricted = "no";
				if(!$email_validated and !$mobile_validated) {
					$restricted = "yes"; 
					$restrict_text = "email and mobile"; 			
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$email_validated) {
					$restricted = "yes";			
					$restrict_text = "email"; 
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$mobile_validated) {
					$restricted = "yes";			
					$restrict_text = "mobile";
					$restricted_route = route('admin.mobile');
					$title = "Warning!";
				}
				$params = [
					'vidsrc' => '',
					'bannersrc' => '',
					'admap' => '', 
					'check1' => '', 
					'check2' => '', 
					'check3' => '', 
					'check4' => '', 
					'check5' => '', 
					'check6' => '',				
					'mobile_status' => '', 
					'email_status' => '',						
					'restricted' => $restricted,
					'restrict_text' => $restrict_text,
					'restricted_route' => $restricted_route,					
					'numOfBanners' => $numOfBanners,					
					'locationHTML' => $locationHTML, 
					'ad_stream' => $adtype, 
					'banners' => $banners, 
					'directories' => $directories, 
					'latitude' => $this->getLatitude(), 
					'longitude' => $this->getLongitude(), 
					'zoom' => $this->getZoom(), 
					'title' => $title, 
					'adpage' => 'Advertisement Creator',
					'countries' => $countries, 
					'runningbg' => session('runningbg')
				];
				return view('admin.add_advertisement', $params);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function getPostLocation($adtype) {
		$clevel = session('user')->customer_level;	
		if($adtype == "commercial") {			
			if($clevel == "Local Resident"){
				$townStyle = "";
				$townbadge = "bg-green";
				$townbadgetext = "On";
				$stateStyle = "disabled='disabled'"; 
				$statebadge = "bg-red";
				$statebadgetext = "Off";
				$countryStyle = "disabled='disabled'"; 
				$countrybadge = "bg-red";
				$countrybadgetext = "Off";
			} elseif($clevel == "Community Leader" || $clevel == "Local Government" || $clevel == "State Government" || $clevel == "Federal Government" || $clevel == "Emergency Services"){
				$townStyle = "disabled='disabled'";
				$townbadge = "bg-red";
				$townbadgetext = "Off";
				$stateStyle = "disabled='disabled'";
				$statebadge = "bg-red";
				$statebadgetext = "Off";
				$countryStyle = "disabled='disabled'";
				$countrybadge = "bg-red";
				$countrybadgetext = "Off";
			} elseif($clevel == "Local Business") {
				$townStyle = "";
				$townbadge = "bg-green";
				$townbadgetext = "On";
				$stateStyle = "disabled='disabled'";
				$statebadge = "bg-red";
				$statebadgetext = "Off";
				$countryStyle = "disabled='disabled'";	
				$countrybadge = "bg-red";
				$countrybadgetext = "Off";
			} elseif($clevel == "National Business" || $clevel == "Administrator") {				
				$townStyle = "";
				$townbadge = "bg-green";
				$townbadgetext = "On";
				$stateStyle = "";
				$statebadge = "bg-green";
				$statebadgetext = "On";
				$countryStyle = "";	
				$countrybadge = "bg-green";
				$countrybadgetext = "On";				
			}						
		} else {
			if($clevel == "Local Resident"){
				$townStyle = "";
				$townbadge = "bg-green";
				$townbadgetext = "On";
				$stateStyle = "disabled='disabled'"; 
				$statebadge = "bg-red";
				$statebadgetext = "Off";
				$countryStyle = "disabled='disabled'"; 
				$countrybadge = "bg-red";
				$countrybadgetext = "Off";
			} elseif($clevel == "National Business" || $clevel == "Federal Government" || $clevel == "Emergency Services" || $clevel == "Administrator"){
				$townStyle = "";
				$townbadge = "bg-green";
				$townbadgetext = "On";
				$stateStyle = "";
				$statebadge = "bg-green";
				$statebadgetext = "On";
				$countryStyle = "";	
				$countrybadge = "bg-green";
				$countrybadgetext = "On";			
			} else {
				if($clevel == "Community Leader" || $clevel == "Local Business" || $clevel == "Local Government"){
					$townStyle = ""; 
					$townbadge = "bg-green";
					$townbadgetext = "On";
					$stateStyle = "disabled='disabled'";
					$statebadge = "bg-red";
					$statebadgetext = "Off"; 
					$countryStyle = "disabled='disabled'";
					$countrybadge = "bg-red";
					$countrybadgetext = "Off"; 
				} elseif ($clevel == "State Government") {
					$townStyle = ""; 
					$townbadge = "bg-green";
					$townbadgetext = "On";
					$stateStyle = ""; 
					$statebadge = "bg-green";
					$statebadgetext = "On";
					$countryStyle = "disabled='disabled'"; 
					$countrybadge = "bg-red";
					$countrybadgetext = "Off"; 
				}
			}			
		}
		$location = session('location');
		$locationHTML = "<option value='" . $location . "' ".$townStyle.">". $location ."</option>";
		$article_location = ArticleLocation::where('preferred', 'YES')
							->where('location', '!=', '')->orderBy('location', 'asc')->get();
		if(!empty($article_location)) {
			foreach($article_location as $alocation){
				if($alocation->location != $location) {
					if($townStyle == "") { $class = "text-green"; } else { $class = "text-red"; }
					$locationHTML .= "<option class='$class' value='".$alocation->location."  '".$townStyle.">".$alocation->location."</option>";
				}			
			}
		}
		session(['townStyle' => $townStyle]);
		session(['stateStyle' => $stateStyle]);
		session(['countryStyle' => $countryStyle]);		
		session(['townbadge' => $townbadge]);
		session(['statebadge' => $statebadge]);
		session(['countrybadge' => $countrybadge]);		
		session(['townbadgetext' => $townbadgetext]);
		session(['statebadgetext' => $statebadgetext]);
		session(['countrybadgetext' => $countrybadgetext]);
		return $locationHTML;
	}	
	public function checkVideo(Request $request) {
		$code = $request->input('code');	
		$URL = $request->input('URL');	
		$embed = $request->input('embed');			
		$videoId = $code;
		$contains = str_contains($URL, ['https://www.youtube.com', 'http://www.youtube.com']);
		if($contains) {
			$videoId = Youtube::parseVidFromURL($URL);
		}		
		if($embed != '') {			
			$pos = strpos($embed,"embed") + 6;
			$videoId = substr($embed, $pos, 11);
		}
		$content = '<iframe width="550" height="360" src="https://www.youtube.com/embed/'. $videoId . '?autoplay=1&controls=0&color=white&autohide=1&loop=1&modestbranding=1&showinfo=0&rel=0&cc_load_policy=0&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>';					
		return response()->json(['videoid' => $videoId, 'content' => $content]);			
    }
	public function getYoutubeVideoID($str) {
		$contains = str_contains($str, ['https://www.youtube.com', 'http://www.youtube.com']);
		$videoId = $str;
		if($contains) {
			$videoId = Youtube::parseVidFromURL($str);
		}
		return $videoId;
	}
	public function getCategories(Request $request) {
		$dir = $request->input('dir');		
		$categories = AdsCategory::where('dir', $dir)->orderBy('id', 'desc')->get();
		return $categories;		
	}	
	public function checkCategory(Request $request) {
		$dir = $request->input('dir');
		$category = $request->input('category');
		$cntr = AdsCategory::where('category', $category)->where('dir', $dir)->count();
		$stat = 'not found';
		if($cntr > 0) {
			$stat = 'found';
		} else {
			$cat = AdsCategory::create(['dir' => $dir, 'category' => $category, 'access_level' => '']);
		}
		return response()->json(['stat' => $stat]);
    }
	public function getLocation(Request $request) {
		$ltype = $request->input('ltype');		
		$adtype = $request->input('adtype');			
		if($ltype == "town") {
			$lh = $this->getPostLocation($adtype);
		} else if($ltype == "state") {
			$lh = '<option value="ACT">ACT</option>';
			$lh .= '<option value="NSW">New South Wales</option>';
			$lh .= '<option value="NT">Northern Territory</option>';
			$lh .= '<option value="QLD">Queensland</option>';
			$lh .= '<option value="QLD-NSW">Queensland-NSW</option>';
			$lh .= '<option value="SA">South Australia</option>';
			$lh .= '<option value="TAS">Tasmania</option>';
			$lh .= '<option value="VIC">Victoria</option>';		
			$lh .= '<option value="VIC-NSW">VIC-NSW Border</option>';				
			$lh .= '<option value="WA">Western Australia</option>';
		} else {
			$lh = '<option value="Australia">Australia</option>';
			$lh .= '<option value="Outside Australia">Outside Australia</option>';
		}		
		return $lh;		
	}
	public function setLatitude($lat) {
		$this->latitude = $lat;
	}
	public function setLongitude($lng) {
		$this->longitude = $lng;
	}
	public function setZoom($zm) {
		$this->zoom = $zm;
	}
	public function getLatitude() {
		return $this->latitude;
	}
	public function getLongitude() {
		return $this->longitude;
	}
	public function getZoom() {
		return $this->zoom;
	}	
	public function createMap($mode, $ad) {
		if($mode == "add") {
			try {
			  $arwebsite = Armanagement::where('domainname', session('url'))->firstOrFail();
			  $lat = $arwebsite->latitude;
			  $long = $arwebsite->longitude;
			  $zoom = $arwebsite->zoom;
			} catch (ModelNotFoundException $ex) {
			  $geoip = new GeoIPLocation(); 
			  $geoip->setIP(session('user')->customer_ip);
			  $lat = $geoip->getLatitude();
			  $long = $geoip->getLongitude();
			  $zoom = 13;
			}		
		} else {
			$lat = $ad->ad_latitude;
			$long = $ad->ad_longitude;
			$zoom = $ad->ad_zoom;
		}		      
        $latitude = (float)$lat;
        $longitude = (float)$long;		
		$zoom = (int)$zoom;  
		$this->setLatitude($latitude);
		$this->setLongitude($longitude);
		$this->setZoom($zoom);	
		return true;
    }	
    public function store(Request $request) {		
			if(AdminController::isLogin()) {			
				$clevel = session('user')->customer_level;	
				if($clevel == "Local Resident") {
					$v = $request->validate([
						'ad_directory' => 'required|string',
						'ad_category' => 'required|string',
						'ad_banner' => 'required|string',
						'ad_businessname' => 'required|string|max:50',
						'ad_url' => 'string|url|nullable|max:100',
						'ad_email' => 'string|email|nullable|max:50',                     
						'ad_phone' => 'string|nullable|max:20',      
						'ad_mobile' => 'string|nullable|max:20', 
						'ad_address_1' => 'string|nullable|max:50',      
						'ad_address_2' => 'string|nullable|max:50', 
						'ad_city' => 'string|nullable|max:40', 
						'ad_postcode' => 'string|nullable|max:10',				
						'ad_type' => 'in:located,services,provides',						
						'ad_content' => ['string', 'nullable', new Nolink],	
					]);
				} else {
					$v = $request->validate([
						'ad_directory' => 'required|string',
						'ad_category' => 'required|string',
						'ad_banner' => 'required|string',
						'ad_businessname' => 'required|string|max:50',
						'ad_url' => 'string|url|nullable|max:100',
						'ad_email' => 'string|email|nullable|max:50',                     
						'ad_phone' => 'string|nullable|max:20',      
						'ad_mobile' => 'string|nullable|max:20', 
						'ad_address_1' => 'string|nullable|max:50',      
						'ad_address_2' => 'string|nullable|max:50', 
						'ad_city' => 'string|nullable|max:40', 
						'ad_postcode' => 'string|nullable|max:10',				
						'ad_type' => 'in:located,services,provides',
						'ad_content' => 'string|nullable',	
					]);
				}
				try {
					$ad_location = session('location') . ", Australia";
					$latitude = $request->input('ad_latitude', '');
					$longitude = $request->input('ad_longitude', '');
					$zoom = $request->input('ad_zoom', '');
					$nomap = $request->input('nomap', '');
					$addmap = "yes";
					if($nomap == "on") {
						$latitude = $longitude = 0.00;
						$zoom = 0;	
						$addmap = "no";
					}
					$dt = Carbon::now();			
					$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());
					$ddate = substr($ddate, 2);
					$ddate = str_replace_array(' ', [''], $ddate);
					$adid = str_replace_array(':', ['', ''], $ddate);			
					$vid = $request->input('ad_videoid', '');			
					$ad_video = $videoid = '';
					if($vid != "") {
						$videoid = $this->getYoutubeVideoID($vid);
						$ad_video = 'youtube';
					}
					$data = [
						'ad_id' => $adid,
						'customer_id' => session('user')->customer_id,
						'ad_directory' => $request->input('ad_directory', ''),
						'ad_category' => $request->input('ad_category', ''),
						'ad_banner' => $request->input('ad_banner', ''),
						'ad_videoid' => $videoid,
						'ad_video' => $ad_video,
						'ad_businessname' => $request->input('ad_businessname', ''),
						'ad_url' => $request->input('ad_url', ''),
						'ad_status' => 'NEW',
						'ad_email' => $request->input('ad_email', ''),
						'ad_phone' => $request->input('ad_phone', ''),
						'ad_mobile' => $request->input('ad_mobile', ''),
						'ad_address_1' => $request->input('ad_address_1', ''),
						'ad_address_2' => $request->input('ad_address_2', ''),
						'ad_city' => $request->input('ad_city', ''),
						'ad_postcode' => $request->input('ad_postcode', ''),
						'ad_state' => $request->input('ad_state', ''),
						'ad_country' => $request->input('ad_country', ''),
						'ad_type' => $request->input('ad_type', ''),		
						'ad_locationtype' => $request->input('ad_locationtype', ''),	
						'ad_latitude' => $latitude,
						'ad_longitude' => $longitude,
						'ad_zoom' => $zoom,
						'ad_location' => $ad_location,
						'ad_map' => $addmap,
						'ad_portal' => $request->input('ad_portal', ''),	
						'ad_teaser' => $request->input('ad_teaser', ''),
						'ad_content' => $request->input('ad_content', ''),
						'ad_stream' => $request->input('ad_stream', ''),				
					];
					$c = Advertisement::create($data);			
					$f = $this->forgetTemp($request);
					$request->session()->forget('numOfAds');
					$ctr = $this->updateAdsCounter();
					return redirect()->route('advertisements');
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}				
    }
	public function forgetTemp($req) {
		$req->session()->forget('townStyle');
		$req->session()->forget('stateStyle');
		$req->session()->forget('countryStyle');			
		$req->session()->forget('townbadge');
		$req->session()->forget('statebadge');
		$req->session()->forget('countrybadge');			
		$req->session()->forget('townbadgetext');
		$req->session()->forget('statebadgetext');
		$req->session()->forget('countrybadgetext');
		return 'forgotten';
	}
	public function updateAdsCounter() {
        $numOfAds = Advertisement::where('customer_id', session('user')->customer_id)->count();
		session(['numOfAds' => $numOfAds]);
		return $numOfAds;
    }    
    public function edit($id) {
		if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$ad = Advertisement::where('ad_id', $id)->where('customer_id', $cid)->first();
				$countries = Country::all();
				$directories = AdsDirectory::all();
				$map = $this->createMap("edit", $ad);	
				$locationHTML = $this->getPostLocation($ad->ad_stream);				
				$banners = Banner::where('customer_id', $cid)->orderBy('filename', 'desc')->get();	
				$numOfBanners = Banner::where('customer_id', $cid)->count();				
				$ck1 = $ck2 = $ck3 = $ck4 = $ck5 = $ck6 = "";
				if($ad->ad_type == "located") { $ck1 = 'checked="checked"'; }
				if($ad->ad_type == "services") { $ck2 = 'checked="checked"'; }
				if($ad->ad_type == "provides") { $ck3 = 'checked="checked"'; }			
				if($ad->ad_locationtype == "town") { $ck4 = 'checked="checked"'; }
				if($ad->ad_locationtype == "state") { $ck5 = 'checked="checked"'; }			
				if($ad->ad_locationtype == "country") { $ck6 = 'checked="checked"'; }				
				$customer = User::where('customer_id', $cid)->first();
				$email_validated = $customer->customer_emailvalidated;
				$mobile_validated = $customer->customer_mobilevalidated;	
				$mobile_status = $restricted_route = $restrict_text = $email_status = "";
				$restricted = "no";
				$title = title_case($ad->ad_stream) .' Advertisement Editor';
				if(!$email_validated and !$mobile_validated) {
					$restricted = "yes"; 
					$restrict_text = "email and mobile"; 			
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$email_validated) {
					$restricted = "yes";			
					$restrict_text = "email"; 
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$mobile_validated) {
					$restricted = "yes";			
					$restrict_text = "mobile";
					$restricted_route = route('admin.mobile');
					$title = "Warning!";
				}
				if(!$mobile_validated) { $mobile_status = 'disabled'; }
				if(!$email_validated) { $email_status = 'disabled'; }
				$vidsrc = $bannersrc = '';
				$vid = $ad->ad_videoid;
				if($vid != '') {
					$vidsrc = '<img src="https://img.youtube.com/vi/' . $vid . '/0.jpg" width="180" height="130">';								
				}
				$adb = $ad->ad_banner;
				if($adb != '') {				
					$bannersrc = '<img src="/publicimages/banners/' . $adb . '" width="180" height="130">';
				}
				$params = [
					'vidsrc' => $vidsrc,
					'bannersrc' => $bannersrc,
					'admap' => $ad->ad_map, 
					'check1' => $ck1, 
					'check2' => $ck2, 
					'check3' => $ck3, 
					'check4' => $ck4, 
					'check5' => $ck5, 
					'check6' => $ck6, 
					'ad' => $ad, 	
					'restricted' => $restricted, 
					'restrict_text' => $restrict_text, 
					'restricted_route' => $restricted_route, 
					'mobile_status' => $mobile_status, 
					'email_status' => $email_status,					
					'numOfBanners' => $numOfBanners,					
					'locationHTML' => $locationHTML, 
					'ad_stream' => $ad->ad_stream, 
					'banners' => $banners, 
					'directories' => $directories, 
					'latitude' => $this->getLatitude(), 
					'longitude' => $this->getLongitude(), 
					'zoom' => $this->getZoom(), 
					'adpage' => 'Advertisement Editor',
					'title' => $title,				
					'countries' => $countries, 
					'runningbg' => session('runningbg')
				];
				return view('admin.edit_advertisement', $params);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }	
    }
    public function update(Request $request, $id) {		
			if(AdminController::isLogin()) {	
				$clevel = session('user')->customer_level;	
				if($clevel == "Local Resident") {
					$v = $request->validate([
						'ad_directory' => 'required|string',
						'ad_category' => 'required|string',
						'ad_banner' => 'required|string',
						'ad_businessname' => 'required|string|max:50',
						'ad_url' => 'string|url|nullable|max:100',
						'ad_email' => 'string|email|nullable|max:50',                     
						'ad_phone' => 'string|nullable|max:20',      
						'ad_mobile' => 'string|nullable|max:20', 
						'ad_address_1' => 'string|nullable|max:50',      
						'ad_address_2' => 'string|nullable|max:50', 
						'ad_city' => 'string|nullable|max:40', 
						'ad_postcode' => 'string|nullable|max:10', 				
						'ad_type' => 'in:located,services,provides',
						'ad_content' => ['string', 'nullable', new Nolink],	
					]);
				} else {
					$v = $request->validate([
						'ad_directory' => 'required|string',
						'ad_category' => 'required|string',
						'ad_banner' => 'required|string',
						'ad_businessname' => 'required|string|max:50',
						'ad_url' => 'string|url|nullable|max:100',
						'ad_email' => 'string|email|nullable|max:50',                     
						'ad_phone' => 'string|nullable|max:20',      
						'ad_mobile' => 'string|nullable|max:20', 
						'ad_address_1' => 'string|nullable|max:50',      
						'ad_address_2' => 'string|nullable|max:50', 
						'ad_city' => 'string|nullable|max:40', 
						'ad_postcode' => 'string|nullable|max:10', 				
						'ad_type' => 'in:located,services,provides',
						'ad_content' => 'string|nullable',	
					]);
				}			
				try {
					$latitude = $request->input('ad_latitude', '');
					$longitude = $request->input('ad_longitude', '');
					$zoom = $request->input('ad_zoom', '');
					$nomap = $request->input('nomap', '');
					$addmap = "yes";
					if($nomap == "on") {
						$latitude = $longitude = 0.00;
						$zoom = 0;	
						$addmap = "no";
					}			
					$vid = $request->input('ad_videoid', '');			
					$videoid = $ad_video = '';
					if($vid != "") {
						$videoid = $this->getYoutubeVideoID($vid);		
						$ad_video = 'youtube';
					}
					$data = [				
						'ad_directory' => $request->input('ad_directory', ''),
						'ad_category' => $request->input('ad_category', ''),
						'ad_banner' => $request->input('ad_banner', ''),
						'ad_videoid' => $videoid,				
						'ad_video' => $ad_video,
						'ad_businessname' => $request->input('ad_businessname', ''),
						'ad_url' => $request->input('ad_url', ''),				
						'ad_email' => $request->input('ad_email', ''),
						'ad_phone' => $request->input('ad_phone', ''),
						'ad_mobile' => $request->input('ad_mobile', ''),
						'ad_address_1' => $request->input('ad_address_1', ''),
						'ad_address_2' => $request->input('ad_address_2', ''),
						'ad_city' => $request->input('ad_city', ''),
						'ad_postcode' => $request->input('ad_postcode', ''),
						'ad_state' => $request->input('ad_state', ''),
						'ad_country' => $request->input('ad_country', ''),
						'ad_type' => $request->input('ad_type', ''),		
						'ad_locationtype' => $request->input('ad_locationtype', ''),				
						'ad_latitude' => $latitude,
						'ad_longitude' => $longitude,
						'ad_zoom' => $zoom,				
						'ad_map' => $addmap,
						'ad_portal' => $request->input('ad_portal', ''),	
						'ad_teaser' => $request->input('ad_teaser', ''),
						'ad_content' => $request->input('ad_content', ''),
						'ad_stream' => $request->input('ad_stream', ''),				
					];
					$f = $this->forgetTemp($request);
					$c = Advertisement::where('ad_id', $id)->update($data);
					return redirect()->route('advertisements');
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}		
    }
    public function delete($id) {
		try {
			$ad = Advertisement::where('ad_id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.ad_delete', ['title' => 'Delete Advertisement', 'ad' => $ad, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function destroy($id) {      		
		try {
			$ad = Advertisement::where('ad_id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updateAdsCounter();
			return redirect()->route('advertisements');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
