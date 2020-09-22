<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Advertisement;
use App\Article;
use App\Event;
use App\Banner;
use App\Photo;
use App\Portrait;
use App\Logo;
use Illuminate\Support\Facades\Storage;

class DeleteOrphaned extends Command
{
    protected $signature = 'delete:orphaned';
    protected $description = 'Deletes all orphaned data from different tables in the database';

    public function __construct() {
        parent::__construct();
    }
    public function handle() {
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
	public function deleteBanner($cid) {
		$banners = Banner::where('customer_id', $cid)->get();
		foreach($banners as $banner) {
			$ban = 'banners/'. $banner->filename;
			$banthumb = 'banners/thumbs/'. $banner->filename;
			Storage::disk('uploads')->delete($ban);
			Storage::disk('uploads')->delete($banthumb);
		}
		$bn = Banner::where('customer_id', $cid)->delete();
		return 'success';
	}
	public function deletePhoto($cid) {
		$photos = Photo::where('customer_id', $cid)->get();
		foreach($photos as $photo) {
			$flname = $photo->filename;
			$img = public_path('/publicimages/large_images/'.$flname);
			$thumb = public_path('/publicimages/thumbs/'.$flname);
			if (!unlink($img)) {					 
			} else {
				if (!unlink($thumb)) {				
				} else {
				}
			}
		}
		$ph = Photo::where('customer_id', $cid)->delete();
		return 'success';
	}
	public function deletePortrait($cid) {
		$portraits = Portrait::where('customer_id', $cid)->get();
		foreach($portraits as $portrait) {
			$pflname = $portrait->filename;
			$pimg = public_path('/publicimages/portraits/'.$pflname);				
			if (!unlink($pimg))  {	 				
			} else {						
			}
		}
		$por = Portrait::where('customer_id', $cid)->delete();
		return 'success';
	}
	public function deleteLogo($cid) {
		$logos = Logo::where('customer_id', $cid)->get();
		foreach($logos as $logo) {
			$logflname = $logo->filename;
			$limg = public_path('/publicimages/logos/'.$logflname);
			$lthumb = public_path('/publicimages/logos/thumb_'.$logflname);				
			if (!unlink($limg)) {			 
			} else {		
				if (!unlink($lthumb)) {			
				} else {				
				}
			}
		}
		$log = Logo::where('customer_id', $cid)->delete();
		return 'success';
	}
}
