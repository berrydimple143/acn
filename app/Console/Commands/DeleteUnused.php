<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Photo;
use App\Banner;
use App\Portrait;
use App\Logo;
use App\Advertisement;
use App\Article;
use App\Event;
use App\User;
use Illuminate\Support\Str;

class DeleteUnused extends Command
{   
    protected $signature = 'delete:unused';
    protected $description = 'Deletes unused data from the storage and from the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle() {
		
		$flag = $this->deleteWithFlag();
		$empty = $this->deleteEmpty();
		// Delete unused images
        $photos = public_path('/publicimages/large_images/*.*');
		$i = $this->clean_up($photos, 'photo');
		$thumbs = public_path('/publicimages/thumbs/*.*');
		$t = $this->clean_up($thumbs, 'photo');
		
		// Delete unused banners
        $banners = public_path('/publicimages/banners/*.*');
		$b = $this->clean_up($banners, 'banner');
		$bthumbs = public_path('/publicimages/banners/thumbs/*.*');
		$bt = $this->clean_up($bthumbs, 'banner');
		
		// Delete unused portraits
        $portraits = public_path('/publicimages/portraits/*.*');
		$p = $this->clean_up($portraits, 'portrait');

		// Delete unused logos
        $logos = public_path('/publicimages/logos/*.*');
		$l = $this->clean_up($logos, 'logo');		
		
		// Delete unused ads		
		$ads = Advertisement::all();
		if($ads) {
			foreach($ads as $d) {
				$cid = $d->customer_id;
				if($this->noUser($cid)) {
					$ad = Advertisement::where('customer_id', $cid)->delete();	
				}
			}
		}		
		// Delete unused articles		
		$articles = Article::all();
		if($articles) {
			foreach($articles as $article) {
				$cid = $article->customer_id;
				if($this->noUser($cid)) {
					$ar = Article::where('customer_id', $cid)->delete();	
				}
			}
		}		
		// Delete unused events		
		$events = Event::all();
		if($events) {
			foreach($events as $event) {
				$cid = $event->customer_id;
				if($this->noUser($cid)) {
					$evt = Event::where('customer_id', $cid)->delete();	
				}
			}
		}		
		// Delete unused images data		
		$photos = Photo::all();
		if($photos) {
			foreach($photos as $photo) {
				$cid = $photo->customer_id;
				if($this->noUser($cid)) {
					$ph = Photo::where('customer_id', $cid)->delete();	
				}
			}
		}
		// Delete unused banner data		
		$banners = Banner::all();
		if($banners) {
			foreach($banners as $banner) {
				$cid = $banner->customer_id;
				if($this->noUser($cid)) {
					$bn = Banner::where('customer_id', $cid)->delete();	
				}
			}
		}
		// Delete unused portrait data		
		$portraits = Portrait::all();
		if($portraits) {
			foreach($portraits as $portrait) {
				$cid = $portrait->customer_id;
				if($this->noUser($cid)) {
					$pt = Portrait::where('customer_id', $cid)->delete();	
				}
			}
		}
		
		// Delete unused logo data		
		$logos = Logo::all();
		if($logos) {
			foreach($logos as $logo) {
				$cid = $logo->customer_id;
				if($this->noUser($cid)) {
					$lg = Logo::where('customer_id', $cid)->delete();	
				}
			}
		}
    }
	public function deleteEmpty() {
		if(User::where('customer_id', null)->count() > 0) {
			$usr = User::where('customer_id', null)->delete();	
		}
		if(User::where('customer_id', '')->count() > 0) {
			$usr = User::where('customer_id', '')->delete();	
		}		
		if(Advertisement::where('customer_id', null)->count() > 0) {
			$ad = Advertisement::where('customer_id', null)->delete();	
		}
		if(Advertisement::where('customer_id', '')->count() > 0) {
			$ad = Advertisement::where('customer_id', '')->delete();	
		}		
		if(Article::where('customer_id', null)->count() > 0) {
			$ar = Article::where('customer_id', null)->delete();	
		}
		if(Article::where('customer_id', '')->count() > 0) {
			$ar = Article::where('customer_id', '')->delete();	
		}		
		if(Event::where('customer_id', null)->count() > 0) {
			$ev = Event::where('customer_id', null)->delete();	
		}
		if(Event::where('customer_id', '')->count() > 0) {
			$ev = Event::where('customer_id', '')->delete();	
		}		
		if(Banner::where('customer_id', null)->count() > 0) {
			$ban = $this->deleteBanner(null);
		}
		if(Banner::where('customer_id', '')->count() > 0) {
			$ban = $this->deleteBanner('');
		}		
		if(Photo::where('customer_id', null)->count() > 0) {
			$ph = $this->deletePhoto(null);
		}
		if(Photo::where('customer_id', '')->count() > 0) {
			$ph = $this->deletePhoto('');
		}		
		if(Portrait::where('customer_id', null)->count() > 0) {
			$pr = $this->deletePortrait(null);
		}
		if(Portrait::where('customer_id', '')->count() > 0) {
			$pr = $this->deletePortrait('');
		}		
		if(Logo::where('customer_id', null)->count() > 0) {
			$lg = $this->deleteLogo(null);
		}
		if(Logo::where('customer_id', '')->count() > 0) {
			$lg = $this->deleteLogo('');
		}
	}
	public function unlinkImages($ph, $th){
		if (!unlink($ph)) {
		} else {
			if($th != '') {
				if (!unlink($th)) {			
				} else {
				}
			}
		}
		return 'unlinked';
	}
	public function deleteBanner($cid) {
		$banners = Banner::where('customer_id', $cid)->get();
		if($banners->count() > 0) {
			foreach($banners as $banner) {
				$ban = public_path('/publicimages/banners/'. $banner->filename);
				$banthumb = public_path('/publicimages/banners/thumbs/'. $banner->filename);
				$lnk = $this->unlinkImages($ban, $banthumb);			
			}
		}
		if(Banner::where('customer_id', $cid)->count() > 0) {
			$bn = Banner::where('customer_id', $cid)->delete();
		}
		return 'success';
	}
	public function deletePhoto($cid) {
		$photos = Photo::where('customer_id', $cid)->get();
		if($photos->count() > 0) {
			foreach($photos as $photo) {
				$flname = $photo->filename;
				$img = public_path('/publicimages/large_images/'.$flname);
				$thumb = public_path('/publicimages/thumbs/'.$flname);
				$lnk = $this->unlinkImages($img, $thumb);
			}
		}
		if(Photo::where('customer_id', $cid)->count() > 0) {
			$ph = Photo::where('customer_id', $cid)->delete();
		}
		return 'success';
	}
	public function deletePortrait($cid) {
		$portraits = Portrait::where('customer_id', $cid)->get();
		if($portraits->count() > 0) {
			foreach($portraits as $portrait) {			
				$pimg = public_path('/publicimages/portraits/'.$portrait->filename);				
				$lnk = $this->unlinkImages($pimg, '');
			}
		}
		if(Portrait::where('customer_id', $cid)->count() > 0) {
			$por = Portrait::where('customer_id', $cid)->delete();
		}
		return 'success';
	}
	public function deleteLogo($cid) {
		$logos = Logo::where('customer_id', $cid)->get();
		if($logos->count() > 0) {
			foreach($logos as $logo) {
				$logflname = $logo->filename;
				$limg = public_path('/publicimages/logos/'.$logflname);
				$lthumb = public_path('/publicimages/logos/thumb_'.$logflname);				
				$lnk = $this->unlinkImages($limg, $lthumb);
			}
		}
		if(Logo::where('customer_id', $cid)->count() > 0) {
			$log = Logo::where('customer_id', $cid)->delete();
		}
		return 'success';
	}
	public function deleteWithFlag() {
		$msg = 'none to delete';
		if(User::where('customer_status', 'DELETE')->count() > 0) {
			$users = User::where('customer_status', 'DELETE')->get();
			foreach($users as $user) {
				$cid = $user->customer_id;					
				// Delete ads
				if(Advertisement::where('customer_id', $cid)->count() > 0) {
					$ad = Advertisement::where('customer_id', $cid)->delete();	
					$msg = 'ads with $cid customer_id deleted';
				}
				
				// Delete articles
				if(Article::where('customer_id', $cid)->count() > 0) {
					$ar = Article::where('customer_id', $cid)->delete();
					$msg = 'article with $cid customer_id deleted';
				}
				
				// Delete events
				if(Event::where('customer_id', $cid)->count() > 0) {	
					$evt = Event::where('customer_id', $cid)->delete();		
					$msg = 'event with $cid customer_id deleted';
				}				
				
				// Delete banners
				if(Banner::where('customer_id', $cid)->count() > 0) {
					$banner = Banner::where('customer_id', $cid)->first();
					$ban = public_path('/publicimages/banners/'. $banner->filename);
					$banthumb = public_path('/publicimages/banners/thumbs/'. $banner->filename);					
					$msg = $this->unlinkImages($ban, $banthumb);
					$bn = Banner::where('customer_id', $cid)->delete();
				}
				
				// Delete images
				if(Photo::where('customer_id', $cid)->count() > 0) {
					$photo = Photo::where('customer_id', $cid)->first();
					$flname = $photo->filename;
					$img = public_path('/publicimages/large_images/'.$flname);
					$thumb = public_path('/publicimages/thumbs/'.$flname);
					$msg = $this->unlinkImages($img, $thumb);
					$ph = Photo::where('customer_id', $cid)->delete();
				}
				
				// Delete portraits
				if(Portrait::where('customer_id', $cid)->count() > 0) {
					$portrait = Portrait::where('customer_id', $cid)->first();					
					$pimg = public_path('/publicimages/portraits/'.$portrait->filename);				
					$msg = $this->unlinkImages($pimg, '');
					$por = Portrait::where('customer_id', $cid)->delete();
				}
				
				// Delete logo
				if(Logo::where('customer_id', $cid)->count() > 0) {
					$logo = Logo::where('customer_id', $cid)->first();
					$logflname = $logo->filename;
					$limg = public_path('/publicimages/logos/'.$logflname);
					$lthumb = public_path('/publicimages/logos/thumb_'.$logflname);				
					$msg = $this->unlinkImages($limg, $lthumb);
					$log = Logo::where('customer_id', $cid)->delete();
				}
			}
		}
		return $msg;
	}
	
	public function noUser($cid) {
		$r = false;
		if(User::where('customer_id', $cid)->count() < 1) {
			$r = true;
		}
		return $r;
	}
	
	public function clean_up($dir, $class) {
		$msg = 'success';
		foreach(glob($dir) as $filename) {
			$arr = explode('/', $filename);
			$fname = $arr[count($arr) - 1];	
			if($class == 'photo') {
				if(Photo::where('filename', $fname)->count() < 1) {					
					unlink($filename);	
					$msg = 'image deleted';
				}
			}
			if($class == 'banner') {
				if(Banner::where('filename', $fname)->count() < 1) {					
					unlink($filename);
					$msg = 'banner deleted';
				}
			}
			if($class == 'portrait') {
				if(Portrait::where('filename', $fname)->count() < 1) {					
					unlink($filename);
					$msg = 'portrait deleted';
				}
			}		
			if($class == 'logo') {
				if(Str::contains($fname, 'thumb_')) {
					$newFname= Str::replaceFirst('thumb_', '', $fname);
					if(Logo::where('filename', $newFname)->count() < 1) {
						unlink($filename);
						$msg = 'logo deleted';
					}
				} else {
					if(Logo::where('filename', $fname)->count() < 1) {
						unlink($filename);
						$msg = 'logo deleted';
					}
				}
			}	
		}
		return $msg;
	}
}
