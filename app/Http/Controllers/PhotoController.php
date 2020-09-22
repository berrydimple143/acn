<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Photo;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Exceptions\GeneralException;
use Storage;

class PhotoController extends Controller
{    
    public function index()
    {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$photos = Photo::where('customer_id', $cid)->orderBy('filename', 'desc')->paginate(5);
				$numOfImages = Photo::where('customer_id', $cid)->count();
				return view('admin.photos', ['title' => 'Images Page', 'photos' => $photos, 'numOfImages' => $numOfImages, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }

    public function search(Request $request) {
		try {
			if(AdminController::isLogin()) {
			$cid = session('user')->customer_id;
			$sr = $request->input('image');
			$numOfImages = Photo::where('customer_id', $cid)->count();
			$photos = DB::table('customer_images')
						->where('customer_id', '=', $cid)
						->where(function ($query) use ($sr) {
					$go = '%'.$sr.'%';
							$query->where('category', 'like', $go)
						->orWhere('id', 'like', $go)
						->orWhere('title', 'like', $go)
						->orWhere('description', 'like', $go)
									->orWhere('filename', 'like', $go);
						})->paginate(5);					
					return view('admin.photos', ['title' => 'Images Search Page', 'photos' => $photos, 'numOfImages' => $numOfImages, 'runningbg' => session('runningbg')]);
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }

    public function cancel($flname) {
        if(AdminController::isLogin()) {	
			try {
				$img = public_path('/publicimages/large_images/'.$flname);
				$thumb = public_path('/publicimages/thumbs/'.$flname);
				$rt = route('photo.add');		
				if (!unlink($img)) {			 
					 return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
				} else {
					if (!unlink($thumb)) {
						return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
					} else {
						return redirect()->route('photos');
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
    public function create() {
        if(AdminController::isLogin()) {
		return view('admin.photo_add', ['title' => 'Image Creator Page', 'runningbg' => session('runningbg')]);
	} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
    public function store(Request $request)
    {		
			if(AdminController::isLogin()) {
				try {
				if ($request->hasFile('filename')) {			
					if ($request->file('filename')->isValid()) {
						$file = $request->file('filename');
						$imgtitle = $request->input('title', '');
						$description = $request->input('description', '');				
						$dt = Carbon::now();
						$cid = session('user')->customer_id;
						$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());						
						$ddate = str_replace_array(' ', [''], $ddate);
						$flname = str_replace_array(':', ['', ''], $ddate);		
						$flname = substr($flname, 2);
						$unique_name = $cid ."-". $flname;
						$fn = $unique_name . '.jpg';
						$fn2 = $unique_name . '.gif';
						$path = 'large_images/'.$fn;
						$path2 = 'large_images/'.$fn2;
						$thumbpath = 'thumbs/'.$fn;
						$thumbpath2 = 'thumbs/'.$fn2;
						$dat = getimagesize($file);
						$width = $dat[0];
						$height = $dat[1];
						$ext = $request->file('filename')->extension();
						$stat = "NOGALLERY";
						$front = "no";
						$filename = $fn;
						$rt = route('photo.add');							
						$bgpath = public_path("commonimages/backgrounds/locations/") . session('location') . "/" . $fn;
						$fileTypes = ['jpg' => 'jpg', 'jpeg' => 'jpeg', 'bmp' => 'bmp', 'png' => 'png', 'gif' => 'gif'];
						$fsize = $request->file('filename')->getSize();	
						$file_path = "publicimages/large_images/";
						$file_path_thumb = "publicimages/thumbs/";			
						$categories = ['NOGALLERY' => 'None',  
							'Attractions' => 'Attractions', 'Community' => 'Community', 'Events' => 'Events', 'Groups' => 'Groups',
							'History' => 'History', 'News' => 'News', 'People' => 'People', 'Places' => 'Places', 'Views' => 'Views'
						];
						if(array_has($fileTypes, $ext)) {
							if($fsize <= 16000000) {		
								if($ext == "gif" && ($width > 640 || $height > 480)) {							
									return view('admin.invalid_format', ['title' => 'Invalid Photo', 'route' => $rt, 'runningbg' => session('runningbg')]);	
								} else {
									$image = Image::make($file);
									if($ext != "gif") {	
										if($width > 640 && $height > 420) {
											if($width >= 1280 || $height >= 720) {							
												$front = "yes";
											}							
											$stat = "GALLERY";
											$image->widen(640);							
										}							
										Storage::disk('uploads')->put($path, (string) $image->encode());
										$image->resize(128, 96);								
										Storage::disk('uploads')->put($thumbpath, (string) $image->encode());				
									} else {							
										Storage::disk('uploads')->put($path2, (string) $image->encode());
										$image->resize(128, 96);								
										Storage::disk('uploads')->put($thumbpath2, (string) $image->encode());
										$filename = $fn2;
									}	
								}	
							} else {
								return view('admin.invalid_format', ['title' => 'Filesize limit exceeded', 'route' => $rt, 'runningbg' => session('runningbg')]);
							}				
						} else {
							return view('admin.invalid_format', ['title' => 'Invalid file type', 'route' => $rt, 'runningbg' => session('runningbg')]);
						}
						$img = public_path('publicimages/large_images/'.$filename);
						$imgsrc = "/publicimages/large_images/" . $filename;
						$info = getimagesize($img);
						$nwidth = $info[0];
						$nheight = $info[1];
						return view('admin.photo_save', ['title' => 'Image Creator Page', 'description' => $description, 'imgtitle' => $imgtitle, 'categories' => $categories, 'front' => $front, 'nwidth' => $nwidth, 'nheight' => $nheight, 'imgsrc' => $imgsrc, 'stat' => $stat, 'flname' => $filename, 'runningbg' => session('runningbg')]);						
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

    public function save(Request $request)
    {
		try {			
			if(AdminController::isLogin()) {
			$status = $request->input('status', '');
			$data = [
				'customer_id' => session('user')->customer_id,
				'title' => $request->input('title', ''),
				'description' => $request->input('description', ''),
				'filename' => $request->input('filename', ''),
				'photo_quality' => $status,
				'category' => $request->input('category', ''),
				'thumb_width' => 128,
				'thumb_height' => 96,
				'location' => session('location'),
				'photo_status' => 'NEW',
				'photo_frontpage' => 'no',
				'frontpage' => '',
				'viewed' => '',
				'approval_queue' => '',
				'selected' => '',
			];				
			$p = Photo::create($data);
			$request->session()->forget('numOfImages');
			$numOfImages = Photo::where('customer_id', session('user')->customer_id)->count();
			session(['numOfImages' => $numOfImages]);
			return redirect()->route('photos');
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }    
	public function removePhoto($flname) {
		try {
			$img = public_path('/publicimages/large_images/'.$flname);
			$thumb = public_path('/publicimages/thumbs/'.$flname);
			$rt = route('photo.add');		
			if (!unlink($img))  {			 
				 return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
			} else {
				if (!unlink($thumb)) {
					return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
				} else {
					return redirect()->route('photos');
				}
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function updatePhotoCounter() {
		try {
			$numOfImages = Photo::where('customer_id', session('user')->customer_id)->count();
			session(['numOfImages' => $numOfImages]);
			return $numOfImages;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function removeFromGallery($id) {
		try {
			$p = Photo::where('id', $id)->update(['category' => 'NOGALLERY', 'published' => 'no', 'photo_quality' => 'NOGALLERY']);        
			return redirect()->route('photos');        
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function publishToGallery($id) {	
		try {
			$p = Photo::where('id', $id)->update(['published' => 'yes']);        
			return redirect()->route('photos');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function movePhoto($id) {
		try {
			$photo = Photo::where('id', $id)->first();
			$categories = ['Attractions' => 'Attractions', 'Community' => 'Community', 'Events' => 'Events', 'Groups' => 'Groups',
							'History' => 'History', 'News' => 'News', 'People' => 'People', 'Places' => 'Places', 'Views' => 'Views'];
			return view('admin.move_photo', ['title' => 'Move into this gallery', 'photo' => $photo, 'categories' => $categories, 'runningbg' => session('runningbg')]);		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function movePhotoNow(Request $request, $id) {
		try {
			$category = $request->input('category', '');
			$p = Photo::where('id', $id)->update(['category' => $category, 'published' => 'yes', 'photo_quality' => 'GALLERY']);        
			return redirect()->route('photos');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function moveNow(Request $request) {
		$id = $request->input('id');
		$rt = route('photo.move',['id' => $id]);
        return response()->json(['newrt' => $rt]);
    }
	public function removeNow(Request $request) {
		try {
			$id = $request->input('id');
			$p = Photo::where('id', $id)->update(['category' => 'NOGALLERY', 'published' => 'no']);		
			return response()->json(['status' => 'removed']);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function delete($id) {
        try {
			$photo = Photo::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.photo_delete', ['title' => 'Delete Photo', 'photo' => $photo, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function destroy($id) {
		try {
			$photo = Photo::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			$flname = $photo->filename;
			$l = Photo::where('id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updatePhotoCounter();
			return $this->removePhoto($flname);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function remove($id) {
		try {
			$data = [
				'photo_quality' => 'NOGALLERY',
			];
			$c = Photo::where('id', $id)->update($data);
			return redirect()->route('photos');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
