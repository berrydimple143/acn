<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Event;
use App\Country;
use App\Banner;
use App\User;
use Illuminate\Support\Str;
use App\ArticleLocation;
use App\Armanagement;
use App\AdsCategory;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use App\AdsDirectory;
use App\Rules\Nolink;
use App\Http\Controllers\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Youtube;
use App\Exceptions\GeneralException;
use Storage;

class EventController extends Controller {
	private $latitude;
	private $longitude;
	private $zoom;
	
    public function index()
    {
		if(AdminController::isLogin()) {
			try {
				$evCount = Event::where('customer_id', session('user')->customer_id)->count();
				return view('admin.events', ['title' => 'Events Page', 'evCount' => $evCount, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }        
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
    public function data() {
        $events = Event::where('customer_id', session('user')->customer_id)->orderBy('event_id', 'desc');
        return Datatables::of($events)
            ->addColumn('action', function ($event) {	
				$id = $event->event_id;				
				$evloc = $event->event_portal;
				if(!(Str::contains($evloc, '-'))) {
					$cntrl = Armanagement::inRandomOrder()->where('preferred', 'YES')->first();
				} else {
					$cntrl = Armanagement::where('location', $evloc)->where('preferred', 'YES')->first();
				}					
				$domain = $cntrl->domainname;			
				$link = "https://" . $domain . "/" . title_case($event->event_stream) . "-Events-Directory-" . $id . "#" . $id;
				$ban = "curl -X BAN https://" . $domain . "/*";
				exec($ban);				
                $buttons = '<center><a title="edit" href="' . route('event.edit', ['id' => $id]) .'" class="btn btn-warning"><i class="fa fa-edit"></i></a>&nbsp;';
                $buttons .= '<a title="delete" href="' . route('event.delete', ['id' => $id]) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a>&nbsp;';
                $buttons .= '<a title="Go to this event" href="' . $link .'" class="btn btn-success"><i class="fa fa-search"></i></a></center>';
                return $buttons;
            })->make(true);
    }    
	public function select() {
        if(AdminController::isLogin()) {
			try {
				$cvt = Event::where('customer_id', session('user')->customer_id)
						->where('event_stream', 'community')->count();
				$bvt = Event::where('customer_id', session('user')->customer_id)
						->where('event_stream', 'business')->count();
				$nvt = Event::where('customer_id', session('user')->customer_id)
						->where('event_stream', 'national')->count();				
                return view('admin.event_select', ['cvt' => $cvt, 'bvt' => $bvt, 'nvt' => $nvt, 'title' => 'Events Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }	
	public function selected($evtype) {		
        if(AdminController::isLogin()) {	
			try {
				$cid = session('user')->customer_id;
				$countries = Country::all();
				$directories = AdsDirectory::all();
				$map = $this->createMap("add", "");
				$dt = Carbon::now();
				$stp = Carbon::now();
				$stps = $stp->addDay();				
				$start = $dt->day . '/' . $dt->month . '/' . $dt->year;
				$stop = $stps->day . '/' . $stps->month . '/' . $stps->year;
				$style = $this->initStyles($evtype);
				$location_map = session('location') . ", Australia";
				$locationHTML = $this->getPostLocation($evtype, '');
				$article_location = $this->getArticleLocation();				
				$banners = Banner::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$numOfBanners = Banner::where('customer_id', $cid)->count();	
				$title = title_case($evtype) .' Event Creator';
				$customer = User::where('customer_id', $cid)->first();
				$email_validated = $customer->customer_emailvalidated;
				$mobile_validated = $customer->customer_mobilevalidated;
				$restricted_route = $restrict_text = "";
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
				$data = [				
					'vidsrc' => '',
					'bannersrc' => '',
					'evtype' => $evtype, 
					'banners' => $banners, 
					'admap' => '', 					
					'start' => $start,  
					'stop' => $stop,
					'numOfBanners' => $numOfBanners,
					'location_map' => $location_map, 
					'locationHTML' => $locationHTML,
					'check1' => 'checked="checked"', 
					'check2' => '', 
					'check3' => '', 						
					'check4' => 'checked="checked"', 
					'check5' => '', 
					'check6' => '', 
					'restricted' => $restricted,
					'restricted_route' => $restricted_route,
					'restrict_text' => $restrict_text,
					'location' => session('location'), 	
					'article_location' => $article_location,
					'directories' => $directories, 
					'latitude' => $this->getLatitude(), 
					'longitude' => $this->getLongitude(), 
					'zoom' => $this->getZoom(), 
					'title' => $title,		
					'page' => 'Creator',
					'countries' => $countries, 
					'runningbg' => session('runningbg')
				];
				return view('admin.add_event', $data);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function testYVideo(Request $request) {
		$videoId = Youtube::parseVidFromURL($request->input('video'));
		$ytvideo = Youtube::getVideoInfo($videoId)->player->embedHtml;
		return response()->json(['ytvideo' => $ytvideo, 'video_id' => $videoId]);
    }
	public function getYoutubeVideoID($str) {
		$contains = str_contains($str, ['https://www.youtube.com', 'http://www.youtube.com']);
		$videoId = $str;
		if($contains) {
			$videoId = Youtube::parseVidFromURL($str);
		}
		return $videoId;
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
	public function createMap($mode, $event) {	
		try {
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
				$lat = $event->event_latitude;
				$long = $event->event_longitude;
				$zoom = $event->event_zoom;
			}		      
			$latitude = (float)$lat;
			$longitude = (float)$long;		
			$zoom = (int)$zoom;  
			$this->setLatitude($latitude);
			$this->setLongitude($longitude);
			$this->setZoom($zoom);	
			return true;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }	
    public function store(Request $request) {		
			if(AdminController::isLogin()) {	
				$clevel = session('user')->customer_level;	
				if($clevel == "Local Resident") {
					$v = $request->validate([
						'event_start' => 'required|string',
						'event_stop' => 'required|string',
						'event_banner' => 'required|string',
						'event_name' => 'required|string|max:50',
						'event_url' => 'string|url|nullable|max:100',
						'event_email' => 'string|email|nullable|max:50',                     
						'event_phone' => 'string|nullable|max:20',      
						'event_mobile' => 'string|nullable|max:20', 
						'event_address_1' => 'string|nullable|max:50',      
						'event_address_2' => 'string|nullable|max:50', 
						'event_city' => 'string|nullable|max:40', 
						'event_postcode' => 'string|nullable|max:10', 				
						'event_type' => 'in:located,observed,occasion',
						'event_content' => ['string', 'nullable', new Nolink],	
					]);		
				} else {
					$v = $request->validate([
						'event_start' => 'required|string',
						'event_stop' => 'required|string',
						'event_banner' => 'required|string',
						'event_name' => 'required|string|max:50',
						'event_url' => 'string|url|nullable|max:100',
						'event_email' => 'string|email|nullable|max:50',                     
						'event_phone' => 'string|nullable|max:20',      
						'event_mobile' => 'string|nullable|max:20', 
						'event_address_1' => 'string|nullable|max:50',      
						'event_address_2' => 'string|nullable|max:50', 
						'event_city' => 'string|nullable|max:40', 
						'event_postcode' => 'string|nullable|max:10', 				
						'event_type' => 'in:located,observed,occasion',
						'event_content' => 'string|nullable',	
					]);		
				}
				//try {
					$latitude = $request->input('event_latitude', '');
					$longitude = $request->input('event_longitude', '');
					$zoom = (int)$request->input('event_zoom', '');
					$nomap = $request->input('nomap', '');
					$addmap = "yes";
					if($nomap == "on") {
						$latitude = $longitude = "0.00";
						$zoom = 0;	
						$addmap = "no";
					}
					$dt = Carbon::now();		
					$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());
					$ddate = substr($ddate, 2);
					$ddate = str_replace_array(' ', [''], $ddate);
					$evid = str_replace_array(':', ['', ''], $ddate);			
					$vid = $request->input('event_videoid', '');			
					$event_video = $videoid = '';
					if($vid != "") {
						$videoid = $this->getYoutubeVideoID($vid);
						$event_video = 'youtube';
					}
					$data = [
						'event_id' => $evid,
						'customer_id' => session('user')->customer_id,				
						'event_banner' => $request->input('event_banner', ''),
						'event_videoid' => $videoid,
						'event_video' => $event_video,
						'event_name' => $request->input('event_name', ''),
						'event_start' => $this->convertDates($request->input('event_start')),
						'event_stop' => $this->convertDates($request->input('event_stop')),				
						'event_email' => $request->input('event_email', ''),
						'event_phone' => $request->input('event_phone', ''),
						'event_mobile' => $request->input('event_mobile', ''),
						'event_address_1' => $request->input('event_address_1', ''),
						'event_address_2' => $request->input('event_address_2', ''),
						'event_city' => $request->input('event_city', ''),
						'event_postcode' => $request->input('event_postcode', ''),
						'event_state' => $request->input('event_state', ''),
						'event_country' => $request->input('event_country', ''),
						'event_type' => $request->input('event_type', ''),		
						'event_locationtype' => $request->input('event_locationtype', ''),	
						'event_latitude' => $latitude,
						'event_longitude' => $longitude,
						'event_zoom' => $zoom,
						'event_location' => $request->input('location_map', ''),
						'event_map' => $addmap,
						'event_portal' => $request->input('event_portal', ''),	
						'event_teaser' => $request->input('event_teaser', ''),
						'event_content' => $request->input('event_content', ''),
						'event_stream' => $request->input('evtype', ''),		
						'event_status' => "NEW",
					];
					$c = Event::create($data);			
					$f = $this->forgetTemp($request);
					$request->session()->forget('numOfEvent');
					$ctr = $this->updateEventCounter();
					return redirect()->route('events');
				/* } catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				} */
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}		
    }
	public function convertDates($dp) {
		$fd = null;
		$dt = Carbon::now();
		$timenow = (string)$dt->hour . ":" . (string)$dt->minute . ":" . "00";
		if($dp != ""){
			$darr = explode("/", $dp);
			$fd = $darr[2] . "-" . $darr[1] . "-" . $darr[0] . " " . $timenow;
		}		
		return $fd;
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
	public function updateEventCounter() {
		try {
			$numOfEvent = Event::where('customer_id', session('user')->customer_id)->count();
			session(['numOfEvent' => $numOfEvent]);
			return $numOfEvent;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function show($id) {
        
    }
	public function getArticleLocation() {
		return ArticleLocation::where('preferred', 'YES')->where('location', '!=', '')->orderBy('location', 'asc')->get();		 
	}
    public function edit($id) {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$event = Event::where('event_id', $id)->where('customer_id', $cid)->first();			
				$countries = Country::all();
				$directories = AdsDirectory::all();
				$map = $this->createMap("edit", $event);				
				$banners = Banner::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$numOfBanners = Banner::where('customer_id', $cid)->count();				
				$article_location = $this->getArticleLocation();
				$ck1 = $ck2 = $ck3 = $ck4 = $ck5 = $ck6 = "";
				$stdt = new Carbon($event->event_start);
				$stpdt = new Carbon($event->event_stop);
				$start = $stdt->day . '/' . $stdt->month . '/' . $stdt->year;
				$stop = $stpdt->day . '/' . $stpdt->month . '/' . $stpdt->year;
				$style = $this->initStyles($event->event_stream);
				if($event->event_locationtype == "town") { $ck1 = 'checked="checked"'; }
				if($event->event_locationtype == "state") { $ck2 = 'checked="checked"'; }
				if($event->event_locationtype == "country") { $ck3 = 'checked="checked"'; }			
				if($event->event_type == "located") { $ck4 = 'checked="checked"'; }
				if($event->event_type == "observed") { $ck5 = 'checked="checked"'; }			
				if($event->event_type == "occasion") { $ck6 = 'checked="checked"'; }				
				$title = title_case($event->event_stream) .' Event Editor';
				$customer = User::where('customer_id', $cid)->first();
				$email_validated = $customer->customer_emailvalidated;
				$mobile_validated = $customer->customer_mobilevalidated;
				$restricted_route = $restrict_text = "";
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
				$vidsrc = $bannersrc = '';
				$vid = $event->event_videoid;
				if($vid != '') {
					$vidsrc = '<img src="https://img.youtube.com/vi/' . $vid . '/0.jpg" width="180" height="130">';								
				}
				$adb = $event->event_banner;
				if($adb != '') {				
					$bannersrc = '<img src="/publicimages/banners/' . $adb . '" width="180" height="130">';
				}
				$params = [
					'vidsrc' => $vidsrc,
					'bannersrc' => $bannersrc,
					'admap' => $event->event_map,
					'check1' => $ck1, 
					'check2' => $ck2, 
					'numOfBanners' => $numOfBanners, 
					'evtype' => $event->event_stream, 
					'check3' => $ck3, 
					'startdate' => $stdt, 
					'start' => $start,  
					'stop' => $stop,
					'stopdate' => $stpdt, 
					'restricted' => $restricted,
					'restricted_route' => $restricted_route,
					'restrict_text' => $restrict_text,
					'location_map' => $event->event_location, 
					'locationHTML' => $this->getPostLocation($event->event_stream, $event->event_portal),
					'location' => $event->event_portal, 	
					'check4' => $ck4, 
					'check5' => $ck5, 
					'check6' => $ck6, 
					'event' => $event, 
					'article_location' => $article_location,				
					'event_stream' => $event->event_stream, 
					'banners' => $banners, 
					'directories' => $directories, 
					'latitude' => $this->getLatitude(), 
					'longitude' => $this->getLongitude(), 
					'zoom' => $this->getZoom(), 
					'title' => $title,	
					'page' => 'Editor',
					'countries' => $countries, 
					'runningbg' => session('runningbg')
				];
				return view('admin.edit_event', $params);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }	
    }
	public function getLocation(Request $request) {
		$ltype = $request->input('ltype');		
		$evtype = $request->input('evtype');			
		if($ltype == "town") {
			$lh = $this->getPostLocation($evtype, '');
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
	public function initStyles($evtype) {
		session(['townStyle' => ""]);
		session(['townbadge' => "bg-green"]);
        session(['townbadgetext' => "On"]);
		session(['stateStyle' => "disabled='disabled'"]);
		session(['statebadge' => "bg-red"]);
        session(['statebadgetext' => "Off"]);
		session(['countryStyle' => "disabled='disabled'"]);
		session(['countrybadge' => "bg-red"]);
        session(['countrybadgetext' => "Off"]);
		$clevel = session('user')->customer_level;
		if($clevel == "National Business") {
			session(['stateStyle' => ""]);
			session(['statebadge' => "bg-green"]);
			session(['statebadgetext' => "On"]);		
			session(['countryStyle' => ""]);
			session(['countrybadge' => "bg-green"]);
			session(['countrybadgetext' => "On"]);					
		}
		return true;
	}
	public function getPostLocation($evtype, $evloc) {
		$clevel = session('user')->customer_level;	
		$style = $this->initStyles($evtype);	
		$location = session('location');
		if($evloc != "") { $location = $evloc; }
		$article_location = $this->getArticleLocation();
		$townStyle = session('townStyle');
		$locationHTML = "<option value='".$location."' ".$townStyle.">".$location."</option>";
		if(!empty($article_location)) {
			foreach($article_location as $alocation){
				if($alocation->location != $location) {
					if($townStyle == "") { $class = "text-green"; } else { $class = "text-red"; }
					$locationHTML .= "<option class='$class' value='".$alocation->location."  '".$townStyle.">".$alocation->location."</option>";
				}			
			}
		}		
		return $locationHTML;
	}
    public function update(Request $request, $id) {		
			if(AdminController::isLogin()) {	
				$clevel = session('user')->customer_level;	
				if($clevel == "Local Resident") {
					$v = $request->validate([
						'event_start' => 'required|string',
						'event_stop' => 'required|string',
						'event_banner' => 'required|string',
						'event_name' => 'required|string|max:50',
						'event_url' => 'string|url|nullable|max:100',
						'event_email' => 'string|email|nullable|max:50',                     
						'event_phone' => 'string|nullable|max:20',      
						'event_mobile' => 'string|nullable|max:20', 
						'event_address_1' => 'string|nullable|max:50',      
						'event_address_2' => 'string|nullable|max:50', 
						'event_city' => 'string|nullable|max:40', 
						'event_postcode' => 'string|nullable|max:10', 				
						'event_type' => 'in:located,observed,occasion',
						'event_content' => ['string', 'nullable', new Nolink],	
					]);
				} else {
					$v = $request->validate([
						'event_start' => 'required|string',
						'event_stop' => 'required|string',
						'event_banner' => 'required|string',
						'event_name' => 'required|string|max:50',
						'event_url' => 'string|url|nullable|max:100',
						'event_email' => 'string|email|nullable|max:50',                     
						'event_phone' => 'string|nullable|max:20',      
						'event_mobile' => 'string|nullable|max:20', 
						'event_address_1' => 'string|nullable|max:50',      
						'event_address_2' => 'string|nullable|max:50', 
						'event_city' => 'string|nullable|max:40', 
						'event_postcode' => 'string|nullable|max:10', 				
						'event_type' => 'in:located,observed,occasion',
						'event_content' => 'string|nullable',
					]);
				}
				//try {
					$latitude = $request->input('event_latitude', '');
					$longitude = $request->input('event_longitude', '');
					$zoom = (int)$request->input('event_zoom', '');
					$nomap = $request->input('nomap', '');
					$addmap = "yes";
					if($nomap == "on") {
						$latitude = $longitude = 0.00;
						$zoom = 0;	
						$addmap = "no";
					}			
					$vid = $request->input('event_videoid', '');			
					$event_video = $videoid = '';
					if($vid != "") {
						$videoid = $this->getYoutubeVideoID($vid);
						$event_video = 'youtube';
					}
					$data = [				
						'event_banner' => $request->input('event_banner', ''),
						'event_videoid' => $videoid,
						'event_video' => $event_video,
						'event_name' => $request->input('event_name', ''),
						'event_start' => $this->convertDates($request->input('event_start')),
						'event_stop' => $this->convertDates($request->input('event_stop')),	
						'event_email' => $request->input('event_email', ''),
						'event_phone' => $request->input('event_phone', ''),
						'event_mobile' => $request->input('event_mobile', ''),
						'event_address_1' => $request->input('event_address_1', ''),
						'event_address_2' => $request->input('event_address_2', ''),
						'event_city' => $request->input('event_city', ''),
						'event_postcode' => $request->input('event_postcode', ''),
						'event_state' => $request->input('event_state', ''),
						'event_country' => $request->input('event_country', ''),
						'event_type' => $request->input('event_type', ''),		
						'event_locationtype' => $request->input('event_locationtype', ''),	
						'event_latitude' => $latitude,
						'event_longitude' => $longitude,
						'event_zoom' => $zoom,
						'event_location' => $request->input('location_map', ''),
						'event_map' => $addmap,
						'event_portal' => $request->input('event_portal', ''),	
						'event_teaser' => $request->input('event_teaser', ''),
						'event_content' => $request->input('event_content', ''),
						'event_stream' => $request->input('evtype', ''),						
					];
					$f = $this->forgetTemp($request);
					$c = Event::where('event_id', $id)->update($data);
					return redirect()->route('events');
				/* } catch(\Exception $e) {			
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());					
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				} */
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}		
    }
    public function delete($id) {
		try {
			$event = Event::where('event_id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.event_delete', ['title' => 'Delete Event', 'event' => $event, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function destroy($id) {
		try {
			$event = Event::where('event_id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updateEventCounter();
			return redirect()->route('events');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
