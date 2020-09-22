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

class DeleteCustomer extends Command
{    
    protected $signature = 'delete:customer';
    protected $description = 'Deletes a customer with a flag DELETE and all of its related details from different tables';
    
    public function __construct() {
        parent::__construct();
    }
   
    public function handle() {     
		if(User::where('customer_status', 'DELETE')->count() > 0) {
			$users = User::where('customer_status', 'DELETE')->get();
			foreach($users as $user) {
				$cid = $user->customer_id;				
				
				// Delete ads
				if(Advertisement::where('customer_id', $cid)->count() > 0) {
					$ad = Advertisement::where('customer_id', $cid)->delete();	
				}
				
				// Delete articles
				if(Article::where('customer_id', $cid)->count() > 0) {
					$ar = Article::where('customer_id', $cid)->delete();
				}
				
				// Delete events
				if(Event::where('customer_id', $cid)->count() > 0) {	
					$evt = Event::where('customer_id', $cid)->delete();		
				}				
				
				// Delete banners
				if(Banner::where('customer_id', $cid)->count() > 0) {
					$banner = Banner::where('customer_id', $cid)->first();
					$ban = 'banners/'. $banner->filename;
					$banthumb = 'banners/thumbs/'. $banner->filename;
					Storage::disk('uploads')->delete($ban);
					Storage::disk('uploads')->delete($banthumb);
					$bn = Banner::where('customer_id', $cid)->delete();
				}
				
				// Delete images
				if(Photo::where('customer_id', $cid)->count() > 0) {
					$photo = Photo::where('customer_id', $cid)->first();
					$flname = $photo->filename;
					$img = public_path('/publicimages/large_images/'.$flname);
					$thumb = public_path('/publicimages/thumbs/'.$flname);
					if (!unlink($img))  {			 
						 // Error deleting the image
					} else {
						// Successfully deleting the image
						
						if (!unlink($thumb)) {
							// Error deleting the thumbnail
						} else {
							// Successfully deleting the thumbnail
						}
					}
					$ph = Photo::where('customer_id', $cid)->delete();
				}
				
				// Delete portraits
				if(Portrait::where('customer_id', $cid)->count() > 0) {
					$portrait = Portrait::where('customer_id', $cid)->first();
					$pflname = $portrait->filename;
					$pimg = public_path('/publicimages/portraits/'.$pflname);				
					if (!unlink($pimg))  {	 
						// Error deleting the portrait
					} else {
						// Successfully deleting the portrait		
					}
					$por = Portrait::where('customer_id', $cid)->delete();
				}
				
				// Delete logo
				if(Logo::where('customer_id', $cid)->count() > 0) {
					$logo = Logo::where('customer_id', $cid)->first();
					$logflname = $logo->filename;
					$limg = public_path('/publicimages/logos/'.$logflname);
					$lthumb = public_path('/publicimages/logos/thumb_'.$logflname);				
					if (!unlink($limg))  { 
						 // Error deleting the logo
					} else {
						// Successfully deleting the logo
						
						if (!unlink($lthumb)) {
							// Error deleting the logo thumbnail
						} else {
							// Successfully deleting the logo thumbnail		
						}
					}
					$log = Logo::where('customer_id', $cid)->delete();
				}
			}
		}
    }
}
