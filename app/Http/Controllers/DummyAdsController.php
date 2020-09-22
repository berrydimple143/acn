<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Advertisement;
use App\AdsDirectory;
use App\Country;
use App\Banner;
use App\ArticleLocation;
use App\Armanagement;
use App\AdsCategory;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GeneaLabs\LaravelMaps\Facades\Map;
use App\Http\Controllers\AdminController;
use Youtube;
use Carbon\Carbon;

class AdsController extends Controller {
	private $latitude;
	private $longitude;
	private $zoom;
	
    public function index() {
		if(AdminController::isLogin()) {
                return view('admin.ads', ['title' => 'Advertisements Page', 'runningbg' => session('runningbg')]);
        } else {
                return redirect()->route('login');
        }
    }
    public function data() {
        $ads = Advertisement::where('customer_id', session('user')->customer_id);
        return Datatables::of($ads)
            ->addColumn('action', function ($ad) {                
                $buttons = '<center><a title="edit" href="' . route('ads.edit', ['id' => $ad->ad_id]) .'" class="btn btn-warning"><i class="fa fa-edit"></i></a>&nbsp;';
                $buttons .= '<a title="delete" href="' . route('ads.delete', ['id' => $ad->ad_id]) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a>&nbsp;';
                $buttons .= '<a title="Go to this advertisement" href="' . route('ads.show', ['id' => $ad->ad_id]) .'" class="btn btn-success"><i class="fa fa-search"></i></a></center>';
                return $buttons;
            })            
            ->make(true);
    }
    public function select() {
        if(AdminController::isLogin()) {
				$community_ads = Advertisement::where('customer_id', session('user')->customer_id)
						->where('ad_stream', 'community')->count();
				$commercial_ads = Advertisement::where('customer_id', session('user')->customer_id)
						->where('ad_stream', 'commercial')->count();
				session(['community_ads' => $community_ads]);
				session(['commercial_ads' => $commercial_ads]);
                return view('admin.ads_select', ['title' => 'Advertisements Page', 'runningbg' => session('runningbg')]);
        } else {
                return redirect()->route('login');
        }
    }
	public function selected($adtype) {		
        if(AdminController::isLogin()) {	
				$countries = Country::all();
				$directories = AdsDirectory::all();
				$map = $this->createMap("add", "");					
				$locationHTML = $this->getPostLocation($adtype);
				$banners = Banner::where('customer_id', session('user')->customer_id)->get();
				return view('admin.add_advertisement', ['admap' => '', 'check1' => '', 'check2' => '', 'check3' => '', 'check4' => '', 'check5' => '', 'check6' => '', 'locationHTML' => $locationHTML, 'ad_stream' => $adtype, 'banners' => $banners, 'directories' => $directories, 'latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude(), 'zoom' => $this->getZoom(), 'title' => title_case($adtype) .' Advertisement Creator', 'map' => $map, 'countries' => $countries, 'runningbg' => session('runningbg')]);
        } else {
                return redirect()->route('login');
        }
    }
	public function getPostLocation($adtype) {
		$clevel = session('user')->customer_level;	
		if($adtype == "commercial") {									
			if($clevel == "Local Resident" || $clevel == "Community Leader" || $clevel == "Local Government" || $clevel == "State Government" || $clevel == "Federal Government" || $clevel == "Emergency Services"){
				$townStyle = "disabled='disabled'";
				$townbadge = "bg-red";
				$townbadgetext = "Off";
				$stateStyle = "disabled='disabled'";
				$statebadge = "bg-red";
				$statebadgetext = "Off";
				$countryStyle = "disabled='disabled'";
				$countrybadge = "bg-red";
				$countrybadgetext = "Off";
			} elseif($clevel == "Local Business" || $clevel == "National Business" || $clevel == "Administrator") {
				if($clevel == "Local Business"){
					$townStyle = "";
					$townbadge = "bg-green";
					$townbadgetext = "On";
					$stateStyle = "disabled='disabled'";
					$statebadge = "bg-red";
					$statebadgetext = "Off";
					$countryStyle = "disabled='disabled'";	
					$countrybadge = "bg-red";
					$countrybadgetext = "Off";	
				} elseif($clevel == "National Business") {
					$townStyle = "";
					$townbadge = "bg-green";
					$townbadgetext = "On";
					$stateStyle = "";
					$statebadge = "bg-green";
					$statebadgetext = "On";
					$countryStyle = "";	
					$countrybadge = "bg-green";
					$countrybadgetext = "On";
				} elseif($clevel == "Administrator") {
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
			}						
		} else {			
			if($clevel == "Local Resident"){
				$townStyle = "disabled='disabled'"; 
				$townbadge = "bg-red";
				$townbadgetext = "Off";
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
	public function testVideo(Request $request) {
		$str = $request->input('video');	
		$contains = str_contains($str, ['https://www.youtube.com', 'http://www.youtube.com']);
		$videoId = $str;
		if($contains) {
			$videoId = Youtube::parseVidFromURL($str);
		}
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
	public function getCategories(Request $request) {
		$dir = $request->input('dir');		
		$categories = AdsCategory::where('dir', $dir)->get();
		return $categories;		
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
		$zoom = (int)$zoom;
        $config = [];
        $latitude = (float)$lat;
        $longitude = (float)$long;
        $coords = [$latitude, $longitude];
        $crd = join(" ", $coords);
        $config['center'] = $crd;
        $config['map_type'] = 'HYBRID';
		$config['map_height'] = "400px"; 
		$config['map_width'] = "90%";  
        $config['zoom'] = $zoom;
        $config['places'] = TRUE;		
		$config['map_div_id'] = 'map_canvas_one';
        $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $config['placesAutocompleteOnChange'] = "				
                var pl = $('#myPlaceTextBox').val() + '';								
                geocoder = new google.maps.Geocoder();				
                geocoder.geocode({ 'address': pl }, function(results, status) {
                  if (status == 'OK') {					
                    map.setCenter(results[0].geometry.location);
                    var mapCenter = map.getCenter();
                    marker_0.setOptions({
                            position: new google.maps.LatLng(mapCenter.lat(), mapCenter.lng())							
                    });	
					var infowindow = new google.maps.InfoWindow({
					  content: results[0].formatted_address					  
					});					
					infowindow.open(map, marker_0);	
                    $('#latitude').val(mapCenter.lat());
                    $('#longitude').val(mapCenter.lng());
                    $('#zoom').val(map.getZoom());
					setTimeout(function(){ infowindow.close(); }, 3000);
                  } 				  
                });
        ";
		$config['onzoomchanged'] = "
			var maxZoomService = new google.maps.MaxZoomService();					
			maxZoomService.getMaxZoomAtLatLng(map.getCenter(), function(response) {
				if (response.status !== 'OK') {
					alert(response.status);
				} else {
					let zm = map.getZoom();
					if(zm <= response.zoom) {
						map.setZoom(zm);
					} else {
						map.setZoom(response.zoom);
					}					
				}
			});
		";
        $config['onboundschanged'] = '';
        Map::initialize($config);
        $marker = [];
        $marker['draggable'] = true;		
        $marker['position'] = $crd;		   		  		
		$marker['icon'] = asset('images/redshadarrow.png');
        $marker['ondragend'] = "					
			map.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));
			var mapCentre = map.getCenter();
			geocoder = new google.maps.Geocoder();						
			pyrmont = new google.maps.LatLng(mapCentre.lat(), mapCentre.lng());					
			geocoder.geocode({ 'latLng': pyrmont }, function(results, status) {
				if (status == 'OK') {						
					map.setCenter(results[1].geometry.location);
                    var mapCentre = map.getCenter();										
					marker_0.setOptions({
							position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())					
					});			
					var infowindow = new google.maps.InfoWindow({
					  content: results[1].formatted_address					  
					});					
					infowindow.open(map, marker_0);							
					$('#latitude').val(event.latLng.lat());
					$('#longitude').val(event.latLng.lng());
					$('#zoom').val(map.getZoom());
					setTimeout(function(){ infowindow.close(); }, 3000);
				}				
			});			
        ";
        Map::add_marker($marker);
        $map = Map::create_map();
		$this->setLatitude($latitude);
		$this->setLongitude($longitude);
		$this->setZoom($zoom);
		return $map;
    }	
    public function store(Request $request) {
		if(AdminController::isLogin()) {	
			$v = $request->validate([
				'ad_directory' => 'required|string',
				'ad_category' => 'required|string',
				'ad_banner' => 'required|string',
				'ad_businessname' => 'required|string|max:50',
				'ad_url' => 'string|nullable|max:100',
				'ad_email' => 'string|email|nullable|max:50',                     
				'ad_phone' => 'string|nullable|max:20',      
				'ad_mobile' => 'string|nullable|max:20', 
				'ad_address_1' => 'string|nullable|max:50',      
				'ad_address_2' => 'string|nullable|max:50', 
				'ad_city' => 'string|nullable|max:40', 
				'ad_postcode' => 'string|nullable|max:10', 
				'ad_state' => 'required|string',
				'ad_type' => 'in:located,services,provides',
			]);
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
			$adid = $dt->year . $dt->month . $dt->day . $dt->hour . $dt->minute . $dt->second;
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
        } else {
                return redirect()->route('login');
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
    public function show($id) {
        
    }
    public function edit($id) {		
		if(AdminController::isLogin()) {	
			$ad = Advertisement::where('ad_id', $id)->where('customer_id', session('user')->customer_id)->first();
			$countries = Country::all();
			$directories = AdsDirectory::all();
			$map = $this->createMap("edit", $ad);	
			$locationHTML = $this->getPostLocation($ad->ad_stream);
			$banners = Banner::where('customer_id', session('user')->customer_id)->get();
			$ck1 = $ck2 = $ck3 = $ck4 = $ck5 = $ck6 = "";
			if($ad->ad_type == "located") { $ck1 = 'checked="checked"'; }
			if($ad->ad_type == "services") { $ck2 = 'checked="checked"'; }
			if($ad->ad_type == "provides") { $ck3 = 'checked="checked"'; }			
			if($ad->ad_locationtype == "town") { $ck4 = 'checked="checked"'; }
			if($ad->ad_locationtype == "state") { $ck5 = 'checked="checked"'; }			
			if($ad->ad_locationtype == "country") { $ck6 = 'checked="checked"'; }
			return view('admin.edit_advertisement', ['admap' => $ad->ad_map, 'check1' => $ck1, 'check2' => $ck2, 'check3' => $ck3, 'check4' => $ck4, 'check5' => $ck5, 'check6' => $ck6, 'ad' => $ad, 'locationHTML' => $locationHTML, 'ad_stream' => $ad->ad_stream, 'banners' => $banners, 'directories' => $directories, 'latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude(), 'zoom' => $this->getZoom(), 'title' => title_case($ad->ad_stream) .' Advertisement Editor', 'map' => $map, 'countries' => $countries, 'runningbg' => session('runningbg')]);
        } else {
            return redirect()->route('login');
        }	
    }
    public function update(Request $request, $id) {
        if(AdminController::isLogin()) {	
			$v = $request->validate([
				'ad_directory' => 'required|string',
				'ad_category' => 'required|string',
				'ad_banner' => 'required|string',
				'ad_businessname' => 'required|string|max:50',
				'ad_url' => 'string|nullable|max:100',
				'ad_email' => 'string|email|nullable|max:50',                     
				'ad_phone' => 'string|nullable|max:20',      
				'ad_mobile' => 'string|nullable|max:20', 
				'ad_address_1' => 'string|nullable|max:50',      
				'ad_address_2' => 'string|nullable|max:50', 
				'ad_city' => 'string|nullable|max:40', 
				'ad_postcode' => 'string|nullable|max:10', 
				'ad_state' => 'required|string',
				'ad_type' => 'in:located,services,provides',
			]);
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
			$videoid = '';
			if($vid != "") {
				$videoid = $this->getYoutubeVideoID($vid);				
			}
			$data = [				
				'ad_directory' => $request->input('ad_directory', ''),
				'ad_category' => $request->input('ad_category', ''),
				'ad_banner' => $request->input('ad_banner', ''),
				'ad_videoid' => $videoid,				
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
		} else {
            return redirect()->route('login');
        }	
    }
    public function delete($id) {
        $ad = Advertisement::where('ad_id', $id)->where('customer_id', session('user')->customer_id)->first();
        return view('admin.ad_delete', ['title' => 'Delete Advertisement', 'ad' => $ad, 'runningbg' => session('runningbg')]);
    }
    public function destroy($id) {      		
        $ad = Advertisement::where('ad_id', $id)->where('customer_id', session('user')->customer_id)->delete();
		$ctr = $this->updateAdsCounter();
        return redirect()->route('advertisements');
    }
}
