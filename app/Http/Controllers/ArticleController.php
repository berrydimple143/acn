<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\ArticleLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\ArticleCategory;
use App\Photo;
use Illuminate\Support\Str;
use App\Armanagement;
use App\Logo;
use Youtube;
use Carbon\Carbon;
use App\Rules\Nolink;
use App\Http\Controllers\AdminController;
use App\Exceptions\GeneralException;
use Storage;

class ArticleController extends Controller
{
    public function index()
    {
		if(AdminController::isLogin()) {
			try {
				$artCount = Article::where('customer_id', session('user')->customer_id)->count();
				return view('admin.articles', ['title' => 'Articles Page', 'artCount' => $artCount, 'runningbg' => session('runningbg')]);
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
        $articles = Article::where('customer_id', session('user')->customer_id)->orderBy('article_id', 'desc');
        return Datatables::of($articles)
            ->addColumn('action', function ($article) {  
				$id = $article->article_id;						
				$arloc = $article->article_location;
				if(!(Str::contains($arloc, '-'))) {
					$cntrl = Armanagement::inRandomOrder()->where('preferred', 'YES')->first();
				} else {
					$cntrl = Armanagement::where('location', $arloc)->where('preferred', 'YES')->first();
				}
				$domain = $cntrl->domainname;				
				$link = "https://" . $domain . "/" . str_replace(' ','-',$article->category) . "-Articles-" . $id;
				$ban = "curl -X BAN https://" . $domain . "/*";
				exec($ban);				
                $buttons = '<center><a title="edit" href="' . route('article.edit', ['id' => $id]) .'" class="btn btn-warning"><i class="fa fa-edit"></i></a>&nbsp;';
                $buttons .= '<a title="delete" href="' . route('article.delete', ['id' => $id]) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a>&nbsp;';
				$buttons .= '<a title="Go to this article" href="' . $link .'" class="btn btn-success"><i class="fa fa-search"></i></a></center>';                
                return $buttons;
			})->addColumn('article_status', function($article) {
				$img = '<span class="badge bg-red">OFF</span>';
				if($article->article_status != "OFFLINE") {
					$exp = $article->expiry_date;
					$now = Carbon::now();
					$rd = new Carbon($article->release_date);
					$xd = new Carbon($exp);
					$imagesrc = asset("images/nothing.png");
					$tit = '';
					$xp = (string)$exp;
					if($rd <= $now and $xp == "0000-00-00 00:00:00") {
						$imagesrc = asset("images/online.png");
						$tit = 'This article is always online';
					} else if($rd > $now and ($xd >= $rd or $xp == "0000-00-00 00:00:00")) {
						$imagesrc = asset("images/release.png");
						$tit = 'This article is set to release at the appointed date';
					} else if($rd <= $now and $xd >= $now) {
						$imagesrc = asset("images/expires.png");
						$tit = 'This article is active but will expire soon';
					} else if($now > $xd or $xd < $rd) {
						$imagesrc = asset("images/expired.png");
						$tit = 'This article is either expired or offline';
					}					
					$img = '<img src="'.$imagesrc.'" title="'.$tit.'" class="img-responsive" alt="">';
				}
                return '<center>'.$img.'</center>';
            })->rawColumns(['action', 'article_status'])->make(true);
    }
    public function testYVideo(Request $request) {
		$videoId = Youtube::parseVidFromURL($request->input('video'));
		$ytvideo = Youtube::getVideoInfo($videoId)->player->embedHtml;
		return response()->json(['ytvideo' => $ytvideo, 'video_id' => $videoId]);
    }	
    public function create() {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id; 
				$categories = ArticleCategory::orderBy('category', 'asc')->get();
				$photos = Photo::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$numOfImages = Photo::where('customer_id', $cid)->count();
				$logos = Logo::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$locationHTML = $this->getPostLocation();
				$dt = Carbon::now();
				$now = $dt->day . '/' . $dt->month . '/' . $dt->year;				
				$title = 'Article Creator';
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
				$info = [
					'vidsrc' => '',
					'vidsrc2' => '',
					'vidsrc3' => '',
					'vidsrc4' => '',
					'vidsrc5' => '',
					'photosrc' => '',
					'photosrc2' => '',
					'photosrc3' => '',
					'photosrc4' => '',
					'photosrc5' => '',
					'logosrc' => '',
					'body2' => '',
					'body3' => '',
					'body4' => '',
					'body5' => '',
					'ccounter' => 1,
					'photos' => $photos, 
					'locationHTML' => $locationHTML, 
					'logos' => $logos, 
					'numOfImages' => $numOfImages,
					'restricted' => $restricted,
					'restricted_route' => $restricted_route,
					'restrict_text' => $restrict_text,
					'check1' => 'checked="checked"', 
					'check2' => '', 
					'check3' => '',
					'rdate' => 'Today',
					'xdate' => 'Never',
					'categories' => $categories, 
					'title' => $title, 
					'runningbg' => session('runningbg')
				];
				return view('admin.article_add', $info);
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
		if($ltype == "town") {
			$lh = $this->getPostLocation();
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
	public function getPostLocation() {	
		$clevel = session('user')->customer_level;				
		if($clevel == "Local Resident" || $clevel == "Federal Government" || $clevel == "State Government" || $clevel == "Emergency Services" || $clevel == "Community Leader" || $clevel == "Local Business" || $clevel == "Local Government") {
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
		$location = session('location');
		$locationHTML = "<option value='".$location."'".">".$location."</option>";
		$article_location = ArticleLocation::where('preferred', 'YES')
							->where('location', '!=', '')->orderBy('location', 'asc')->get();
		if(!empty($article_location)) {
			foreach($article_location as $alocation){
				if($alocation->location != $location) {					
					$locationHTML .= "<option value='".$alocation->location."'".">".$alocation->location."</option>";
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
	public function getYoutubeVideoID($str) {
		$contains = str_contains($str, ['https://www.youtube.com', 'http://www.youtube.com']);
		$videoId = $str;
		if($contains) {
			$videoId = Youtube::parseVidFromURL($str);
		}
		return $videoId;
	}
	public function store(Request $request) {					
			if(AdminController::isLogin()) {
				$clevel = session('user')->customer_level;	
				$counter = (int)$request->input('article_counter');
				if($clevel == "Local Resident") {
					if($counter <= 1) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',						
							'body' => ['required', 'string', new Nolink],		
						]);	
					} else if($counter == 2) {
						$v = $request->validate([							
							'subject' => 'required|string|max:100',
							'description' => 'required|string',						
							'body' => ['required', 'string', new Nolink],
							'body_2' => ['required', 'string', new Nolink],
						]);
					} else if($counter == 3) {
						$v = $request->validate([						
							'subject' => 'required|string|max:100',
							'description' => 'required|string',						
							'body' => ['required', 'string', new Nolink],
							'body_2' => ['required', 'string', new Nolink],
							'body_3' => ['required', 'string', new Nolink],
						]);
					} else if($counter == 4) {
						$v = $request->validate([						
							'subject' => 'required|string|max:100',
							'description' => 'required|string',						
							'body' => ['required', 'string', new Nolink],
							'body_2' => ['required', 'string', new Nolink],
							'body_3' => ['required', 'string', new Nolink],
							'body_4' => ['required', 'string', new Nolink],
						]);
					} else if($counter == 5) {
						$v = $request->validate([						
							'subject' => 'required|string|max:100',
							'description' => 'required|string',						
							'body' => ['required', 'string', new Nolink],
							'body_2' => ['required', 'string', new Nolink],
							'body_3' => ['required', 'string', new Nolink],
							'body_4' => ['required', 'string', new Nolink],
							'body_5' => ['required', 'string', new Nolink],
						]);
					}
				} else {
					if($counter <= 1) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',
							'body' => 'required|string',		
						]);	
					} else if($counter == 2) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',
							'body' => 'required|string',
							'body_2' => 'required|string',
						]);
					} else if($counter == 3) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',
							'body' => 'required|string',
							'body_2' => 'required|string',
							'body_3' => 'required|string',
						]);
					} else if($counter == 4) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',
							'body' => 'required|string',
							'body_2' => 'required|string',
							'body_3' => 'required|string',
							'body_4' => 'required|string',
						]);
					} else if($counter == 5) {
						$v = $request->validate([								
							'subject' => 'required|string|max:100',
							'description' => 'required|string',
							'body' => 'required|string',
							'body_2' => 'required|string',
							'body_3' => 'required|string',
							'body_4' => 'required|string',
							'body_5' => 'required|string',
						]);
					}
				}
				//try {								
					$dt = Carbon::now();											
					$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());
					$ddate = substr($ddate, 2);			
					$ddate = str_replace_array(' ', [''], $ddate);
					$aid = str_replace_array(':', ['', ''], $ddate);	
					$username = (string)session('user')->customer_name . ' ' . (string)session('user')->customer_middlename . ' ' . (string)session('user')->customer_surname;
					$article_video = $videoid = $article_video2 = $videoid2 = $article_video3 = $videoid3 = $article_video4 = $videoid4 = $article_video5 = $videoid5 = '';		
					$vid = $request->input('article_videoid', '');
					$vid2 = $request->input('article_videoid_2', '');	
					$vid3 = $request->input('article_videoid_3', '');
					$vid4 = $request->input('article_videoid_4', '');
					$vid5 = $request->input('article_videoid_5', '');
					if($vid != "") {
						$videoid = $this->getYoutubeVideoID($vid);
						$article_video = 'youtube';
					}
					if($vid2 != "") {
						$videoid2 = $this->getYoutubeVideoID($vid2);
						$article_video2 = 'youtube';
					}
					if($vid3 != "") {
						$videoid3 = $this->getYoutubeVideoID($vid3);
						$article_video3 = 'youtube';
					}
					if($vid4 != "") {
						$videoid4 = $this->getYoutubeVideoID($vid4);
						$article_video4 = 'youtube';
					}
					if($vid5 != "") {
						$videoid5 = $this->getYoutubeVideoID($vid5);
						$article_video5 = 'youtube';
					}
					$data = [
						"content_count" => $counter,
						"article_videoid" => $videoid,
						"article_video" => $article_video,						
						"article_videoid_2" => $videoid2,
						"article_video_2" => $article_video2,
						"article_videoid_3" => $videoid3,
						"article_video_3" => $article_video3,						
						"article_videoid_4" => $videoid4,
						"article_video_4" => $article_video4,
						"article_videoid_5" => $videoid5,
						"article_video_5" => $article_video5,						
						"modified_date" => $dt,
						"release_date" => $this->convertDates($request->input('release_date')),
						"creation_date" => $dt,
						"article_id" => $aid,
						"category" => $request->input('category'),
						"expiry_date" => $this->convertDates($request->input('expiry_date')),				
						"username" => $username,				
						"article_image" => $request->input('article_image'),
						"article_image_2" => $request->input('article_image_2', ''),
						"article_image_3" => $request->input('article_image_3', ''),
						"article_image_4" => $request->input('article_image_4', ''),
						"article_image_5" => $request->input('article_image_5', ''),
						"article_image_thumb" => $request->input('article_image'),				
						"article_logo" => $request->input('article_logo'),
						"article_logo_thumb" => $request->input('article_logo'),				
						"subject" => $request->input('subject'),				
						"description" => $request->input('description'),
						"body" => $request->input('body'),
						"body_2" => $request->input('body_2', ''),
						"body_3" => $request->input('body_3', ''),
						"body_4" => $request->input('body_4', ''),
						"body_5" => $request->input('body_5', ''),
						"article_ltype" => $request->input('article_ltype'),
						"article_location" => $request->input('article_location'),					
						"customer_id" => session('user')->customer_id,	
						"modified_by" => "owner",								
					];
					$c = Article::create($data);			
					$request->session()->forget('numOfArticle');
					$ctr = $this->updateArticleCounter();
					return redirect()->route('articles');
				/* } catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				} */
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
    }
	public function convertDates($dp) {
		$dp = (string)$dp;
		$fd = null;
		$dt = Carbon::now();
		$min = (string)$dt->minute;
		if(strlen($min) <= 1) {
			$min = '0'. $min;
		}
		$timenow = (string)$dt->hour . ":" . $min . ":" . "00";		
		if($dp == "Today") {
			$fd = $dt->year . '-' . $dt->month . '-' . $dt->day . ' ' . $timenow;			
		} else if($dp == "Never") {
			$fd = "0000-00-00 00:00:00";
		} else if($dp != "" or $dp != "Today" or $dp != "Never") {
			$darr = explode("/", $dp);
			$fd = $darr[2] . "-" . $darr[1] . "-" . $darr[0] . " " . $timenow;
		}		
		return $fd;
	}
	public function updateArticleCounter() {
		try {
			$numOfArticle = Article::where('customer_id', session('user')->customer_id)->count();
			session(['numOfArticle' => $numOfArticle]);
			return $numOfArticle;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());	
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function show($id) {
		try {
			$article = Article::where('article_id', $id)->first();
			$str = $article->category . " " . $id;
			$slug = str_slug($str, '-');
			return redirect()->route('article.slug', ['slug' => $slug]);	
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());	
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function slug($slug) {		
		try {
			$arr = explode("-", $slug);		
			$id = $arr[count($arr) - 1];
			$subject = $body = "";
			$article_image = asset('images/noimage.png');		
			try {
				$article = Article::where('article_id', $id)->firstOrFail();
				if($article->article_image != "") {
					$article_image = public_path('publicimages/large_images/' . $article->article_image); 
				}			
				$subject = $article->subject;
				$body = $article->body;
			} catch (ModelNotFoundException $ex) {
							
			}			
			$info = [
				'subject' => $subject,		
				'body' => $body,		
				'title' => 'Article Page', 
				'article_image' => $article_image,
				'runningbg' => session('runningbg')
			];
			return view('admin.article_show', $info);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());	
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function edit($id) {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$article = Article::where('article_id', $id)->where('customer_id', $cid)->first();			
				$categories = ArticleCategory::orderBy('category', 'asc')->get();								
				$photos = Photo::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$numOfImages = Photo::where('customer_id', $cid)->count();				
				$logos = Logo::where('customer_id', $cid)->orderBy('filename', 'desc')->get();
				$locationHTML = $this->getPostLocation();
				$ck1 = $ck2 = $ck3 = "";		
				if($article->article_ltype == "town") { $ck1 = 'checked="checked"'; }
				if($article->article_ltype == "state") { $ck2 = 'checked="checked"'; }
				if($article->article_ltype == "country") { $ck3 = 'checked="checked"'; }		
				$ard = (string)$article->release_date;
				if($ard != "0000-00-00 00:00:00") {
					$rd = new Carbon($article->release_date);
					$now = Carbon::now();
					if($rd == $now) {
						$released = 'Today';
					} else {
						$released = $rd->day . '/' . $rd->month . '/' . $rd->year;
					}					
				} else {
					$released = 'Never';
				}
				$axd = (string)$article->expiry_date;
				if($axd != "0000-00-00 00:00:00") { 
					$xd = new Carbon($article->expiry_date);
					$expired = $xd->day . '/' . $xd->month . '/' . $xd->year;
				} else {
					$expired = 'Never';
				}							
				$title = 'Article Editor';
				$customer = User::where('customer_id', $cid)->first();
				$email_validated = $customer->customer_emailvalidated;
				$mobile_validated = $customer->customer_mobilevalidated;
				$restricted_route = $restrict_text = "";
				$restricted = "no";
				if(!$email_validated and !$mobile_validated) {
					//$restricted = "yes"; 
					$restrict_text = "email and mobile"; 			
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$email_validated) {
					//$restricted = "yes";			
					$restrict_text = "email"; 
					$restricted_route = route('validate.email'); 
					$title = "Warning!";
				} else if(!$mobile_validated) {
					//$restricted = "yes";			
					$restrict_text = "mobile";
					$restricted_route = route('admin.mobile');
					$title = "Warning!";
				}		
				$vidsrc = $vidsrc2 = $vidsrc3 = $vidsrc4 = $vidsrc5 = $photosrc = $photosrc2 = $photosrc3 = $photosrc4 = $photosrc5 = $logosrc = '';
				$limg = $article->article_logo;
				if($limg != '') {					
					$logosrc = '<img src="/publicimages/logos/' . $limg . '" class="img-responsive" width="480" height="auto">';
				}
				$aimg = $article->article_image;
				if($aimg != '') {					
					$photosrc = '<img src="/publicimages/large_images/' . $aimg . '" class="img-responsive" width="480" height="auto">';
				}
				$aimg2 = $article->article_image_2;
				if($aimg2 != '') {					
					$photosrc2 = '<img src="/publicimages/large_images/' . $aimg2 . '" class="img-responsive" width="480" height="auto">';
				}
				$aimg3 = $article->article_image_3;
				if($aimg3 != '') {					
					$photosrc3 = '<img src="/publicimages/large_images/' . $aimg3 . '" class="img-responsive" width="480" height="auto">';
				}
				$aimg4 = $article->article_image_4;
				if($aimg4 != '') {					
					$photosrc4 = '<img src="/publicimages/large_images/' . $aimg4 . '" class="img-responsive" width="480" height="auto">';
				}
				$aimg5 = $article->article_image_5;
				if($aimg5 != '') {				
					$photosrc5 = '<img src="/publicimages/large_images/' . $aimg5 . '" class="img-responsive" width="480" height="auto">';
				}
				$vid = $article->article_videoid;
				if($vid != '') {
					$vidsrc = '<img src="https://img.youtube.com/vi/' . $vid . '/0.jpg" class="img-responsive">';								
				}
				$vid2 = $article->article_videoid_2;
				if($vid2 != '') {
					$vidsrc2 = '<img src="https://img.youtube.com/vi/' . $vid2 . '/0.jpg" class="img-responsive">';								
				}
				$vid3 = $article->article_videoid_3;
				if($vid3 != '') {
					$vidsrc3 = '<img src="https://img.youtube.com/vi/' . $vid3 . '/0.jpg" class="img-responsive">';								
				}
				$vid4 = $article->article_videoid_4;
				if($vid4 != '') {
					$vidsrc4 = '<img src="https://img.youtube.com/vi/' . $vid4 . '/0.jpg" class="img-responsive">';								
				}
				$vid5 = $article->article_videoid_5;
				if($vid5 != '') {
					$vidsrc5 = '<img src="https://img.youtube.com/vi/' . $vid5 . '/0.jpg" class="img-responsive">';								
				}
				$ccounter = 1;
				if($article->content_count != "" or $article->content_count != null or !empty($article->content_count)) {
					$ccounter = (int)$article->content_count;
				}
				$info = [
					'vidsrc' => $vidsrc,					
					'vidsrc2' => $vidsrc2,
					'vidsrc3' => $vidsrc3,
					'vidsrc4' => $vidsrc4,
					'vidsrc5' => $vidsrc5,
					'photosrc' => $photosrc,
					'photosrc2' => $photosrc2,
					'photosrc3' => $photosrc3,
					'photosrc4' => $photosrc4,
					'photosrc5' => $photosrc5,
					'logosrc' => $logosrc,					
					'ccounter' => $ccounter,
					'article' => $article, 
					'body2' => $article->body_2,
					'body3' => $article->body_3,
					'body4' => $article->body_4,
					'body5' => $article->body_5,
					'photos' => $photos, 
					'check1' => $ck1,
					'check2' => $ck2,
					'check3' => $ck3,
					'rdate' => $released,
					'xdate' => $expired,					
					'numOfImages' => $numOfImages,
					'restricted' => $restricted, 
					'restricted_route' => $restricted_route, 
					'restrict_text' => $restrict_text, 
					'locationHTML' => $locationHTML, 
					'logos' => $logos, 
					'categories' => $categories, 
					'title' => $title, 
					'runningbg' => session('runningbg')
				];
				return view('admin.article_edit', $info);
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
			$counter = (int)$request->input('article_counter');
			if($clevel == "Local Resident") {
				if($counter <= 1) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',						
						'body' => ['required', 'string', new Nolink],		
					]);	
				} else if($counter == 2) {
					$v = $request->validate([							
						'subject' => 'required|string|max:100',
						'description' => 'required|string',						
						'body' => ['required', 'string', new Nolink],
						'body_2' => ['required', 'string', new Nolink],
					]);
				} else if($counter == 3) {
					$v = $request->validate([						
						'subject' => 'required|string|max:100',
						'description' => 'required|string',						
						'body' => ['required', 'string', new Nolink],
						'body_2' => ['required', 'string', new Nolink],
						'body_3' => ['required', 'string', new Nolink],
					]);
				} else if($counter == 4) {
					$v = $request->validate([						
						'subject' => 'required|string|max:100',
						'description' => 'required|string',						
						'body' => ['required', 'string', new Nolink],
						'body_2' => ['required', 'string', new Nolink],
						'body_3' => ['required', 'string', new Nolink],
						'body_4' => ['required', 'string', new Nolink],
					]);
				} else if($counter == 5) {
					$v = $request->validate([						
						'subject' => 'required|string|max:100',
						'description' => 'required|string',						
						'body' => ['required', 'string', new Nolink],
						'body_2' => ['required', 'string', new Nolink],
						'body_3' => ['required', 'string', new Nolink],
						'body_4' => ['required', 'string', new Nolink],
						'body_5' => ['required', 'string', new Nolink],
					]);
				}
			} else {
				if($counter <= 1) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',
						'body' => 'required|string',		
					]);	
				} else if($counter == 2) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',
						'body' => 'required|string',
						'body_2' => 'required|string',
					]);
				} else if($counter == 3) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',
						'body' => 'required|string',
						'body_2' => 'required|string',
						'body_3' => 'required|string',
					]);
				} else if($counter == 4) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',
						'body' => 'required|string',
						'body_2' => 'required|string',
						'body_3' => 'required|string',
						'body_4' => 'required|string',
					]);
				} else if($counter == 5) {
					$v = $request->validate([								
						'subject' => 'required|string|max:100',
						'description' => 'required|string',
						'body' => 'required|string',
						'body_2' => 'required|string',
						'body_3' => 'required|string',
						'body_4' => 'required|string',
						'body_5' => 'required|string',
					]);
				}
			}			
			
			try {
				$dt = Carbon::now();				
				$article_video = $videoid = $article_video2 = $videoid2 = $article_video3 = $videoid3 = $article_video4 = $videoid4 = $article_video5 = $videoid5 = '';		
				$vid = $request->input('article_videoid', '');
				$vid2 = $request->input('article_videoid_2', '');	
				$vid3 = $request->input('article_videoid_3', '');
				$vid4 = $request->input('article_videoid_4', '');
				$vid5 = $request->input('article_videoid_5', '');
				if($vid != "") {
					$videoid = $this->getYoutubeVideoID($vid);
					$article_video = 'youtube';
				}
				if($vid2 != "") {
					$videoid2 = $this->getYoutubeVideoID($vid2);
					$article_video2 = 'youtube';
				}
				if($vid3 != "") {
					$videoid3 = $this->getYoutubeVideoID($vid3);
					$article_video3 = 'youtube';
				}
				if($vid4 != "") {
					$videoid4 = $this->getYoutubeVideoID($vid4);
					$article_video4 = 'youtube';
				}
				if($vid5 != "") {
					$videoid5 = $this->getYoutubeVideoID($vid5);
					$article_video5 = 'youtube';
				}
				$data = [					
					"content_count" => $counter,
					"article_videoid" => $videoid,
					"article_video" => $article_video,						
					"article_videoid_2" => $videoid2,
					"article_video_2" => $article_video2,
					"article_videoid_3" => $videoid3,
					"article_video_3" => $article_video3,						
					"article_videoid_4" => $videoid4,
					"article_video_4" => $article_video4,
					"article_videoid_5" => $videoid5,
					"article_video_5" => $article_video5,					
					"modified_date" => $dt,
					"release_date" => $this->convertDates($request->input('release_date')),				
					"category" => $request->input('category'),
					"expiry_date" => $this->convertDates($request->input('expiry_date')),							
					"article_image" => $request->input('article_image'),					
					"article_image_2" => $request->input('article_image_2', ''),
					"article_image_3" => $request->input('article_image_3', ''),
					"article_image_4" => $request->input('article_image_4', ''),
					"article_image_5" => $request->input('article_image_5', ''),					
					"article_image_thumb" => $request->input('article_image'),				
					"article_logo" => $request->input('article_logo'),
					"article_logo_thumb" => $request->input('article_logo'),				
					"subject" => $request->input('subject'),				
					"description" => $request->input('description'),
					"article_ltype" => $request->input('article_ltype'),
					"body" => $request->input('body'),					
					"body_2" => $request->input('body_2', ''),
					"body_3" => $request->input('body_3', ''),
					"body_4" => $request->input('body_4', ''),
					"body_5" => $request->input('body_5', ''),
					"article_location" => $request->input('article_location'),											
				];
				$c = Article::where('article_id', $id)->update($data);
				return redirect()->route('articles');
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
			$article = Article::where('article_id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.article_delete', ['title' => 'Delete Article', 'article' => $article, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function destroy($id) {      		
		try {
			$art = Article::where('article_id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updateArticleCounter();
			return redirect()->route('articles');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
