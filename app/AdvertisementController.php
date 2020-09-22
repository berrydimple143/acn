<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Advertisement;
use App\Country;
use App\Armanagement;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\AdminController;

class AdvertisementController extends Controller {
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
				$map = $this->createMap();
				//$map2 = $this->createPanorama();
				return view('admin.add_advertisement', ['latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude(), 'zoom' => $this->getZoom(), 'title' => title_case($adtype) .' Advertisement Creator', 'map' => $map, 'countries' => $countries, 'runningbg' => session('runningbg')]);
        } else {
                return redirect()->route('login');
        }
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
	public function createPanorama() {
		$config = [];        
        $coords = [$this->getLatitude(), $this->getLongitude()];
        $crd = join(" ", $coords);
        $config['center'] = $crd;		
		$config['map_type'] = 'STREET';
		$config['streetViewPovHeading'] = 90;
		$config['zoom'] = $this->getZoom();
		app('map')->initialize($config);
		$map2 = app('map')->create_map();
		return $map2;
	}
	public function createMap() {			
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
		  $zoom = 16;
        }		
        $config = [];
        $latitude = $lat;
        $longitude = $long;
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
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': pl }, function(results, status) {
                  if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var mapCenter = map.getCenter();
                    marker_0.setOptions({
                            position: new google.maps.LatLng(mapCenter.lat(), mapCenter.lng())
                    });
                    $('#latitude').val(mapCenter.lat());
                    $('#longitude').val(mapCenter.lng());
                    $('#zoom').val(map.getZoom());
                  } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                  }
                });
        ";
        $config['onboundschanged'] = '';
        app('map')->initialize($config);
        $marker = [];
        $marker['draggable'] = true;
        $marker['position'] = $crd;
		$marker['icon'] = asset('images/redshadarrow.png');
        $marker['ondragend'] = "
            map.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
            $('#latitude').val(event.latLng.lat());
            $('#longitude').val(event.latLng.lng());
            $('#zoom').val(map.getZoom());
        ";
        app('map')->add_marker($marker);
        $map = app('map')->create_map();
		$this->setLatitude($latitude);
		$this->setLongitude($longitude);
		$this->setZoom($zoom);
		return $map;
    }
	public function create() {
        
    }
    public function store(Request $request) {
        
    }
    public function show($id) {
        
    }
    public function edit($id) {
        
    }
    public function update(Request $request, $id) {
        
    }
    public function delete($id) {
        
    }
    public function destroy($id) {
        
    }
}
