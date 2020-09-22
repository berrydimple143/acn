<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Banner;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\GeneralException;
use Storage;

class BannerController extends Controller
{    
    public function index()
    {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$banners = Banner::where('customer_id', $cid)->orderBy('filename', 'desc')->paginate(5);
				$numOfBanners = Banner::where('customer_id', $cid)->count();
				return view('admin.banners', ['title' => 'Banners Page', 'banners' => $banners, 'numOfBanners' => $numOfBanners, 'runningbg' => session('runningbg')]);
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
					$sr = $request->input('banner');
					$cid = session('user')->customer_id;
					$numOfBanners = Banner::where('customer_id', $cid)->count();
					$banners = DB::table('customer_banners')
							->where('customer_id', '=', $cid)
							->where(function ($query) use ($sr) {
									$go = '%'.$sr.'%';
									$query->where('id', 'like', $go)                                        
											->orWhere('title', 'like', $go)
											->orWhere('description', 'like', $go)
											->orWhere('filename', 'like', $go);
							})->paginate(5);
					return view('admin.banners', ['title' => 'Banner Search Page', 'banners' => $banners, 'numOfBanners' => $numOfBanners, 'runningbg' => session('runningbg')]);
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	
	public function selection() {
        if(AdminController::isLogin()) {	
			try {
                return view('admin.banner_selection', ['title' => 'Banner Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	
	public function selected($btype) {		
        if(AdminController::isLogin()) {	
			try {
				if($btype == 'creator') {
					return view('admin.banner_maker', ['title' => 'Banner Maker', 'runningbg' => session('runningbg')]);
				} else {
					return view('admin.banner_uploader', ['title' => 'Banner Uploader', 'runningbg' => session('runningbg')]);
				}
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	
	public function maker_upload($type) {
		if(AdminController::isLogin()) {	
			try {
				$url = url('banner-image-upload');
				$createUrl = url('create-banner');
				$bannersRoute = route('banners'); 
				$csrf = csrf_token();
				if($type == "image") {
					return view('admin.banner_maker_upload', ['title' => 'Banner Maker Upload', 'bannersRoute' => $bannersRoute, 'createUrl' => $createUrl, 'csrf' => $csrf, 'url' => $url, 'runningbg' => session('runningbg')]);
				} else {
					return view('admin.banner_maker_save', ['title' => 'Banner Maker Upload', 'bannersRoute' => $bannersRoute, 'createUrl' => $createUrl, 'csrf' => $csrf, 'url' => $url, 'mtype' => 'box', 'filename' => '', 'nwidth' => '', 'nheight' => '', 'imgsrc' => '', 'runningbg' => session('runningbg')]);
				}		
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
			$banner = Banner::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.banner_delete', ['title' => 'Delete Banner', 'banner' => $banner, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}	
	public function destroy($id) {  
		try {
			$banner = Banner::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			$ban = 'banners/'. $banner->filename;
			$thumb = 'banners/thumbs/'. $banner->filename;
			Storage::disk('uploads')->delete($ban);
			Storage::disk('uploads')->delete($thumb);
			$bn = Banner::where('id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updateBannerCounter();
			return redirect()->route('banners');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }	
	public function updateBannerCounter() {
		try {
			$numOfBanners = Banner::where('customer_id', session('user')->customer_id)->count();
			session(['numOfBanners' => $numOfBanners]);
			return $numOfBanners;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }	
	public function createBanner(Request $request) {
		try {
			$img = $request->input('imgBase64', '');
			$title = $request->input('title', '');
			$tmpImages = $request->input('tmpImages','');		
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$info = base64_decode($img);		
			$dt = Carbon::now();
			$cid = session('user')->customer_id;					
			$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());		
			$ddate = str_replace_array(' ', [''], $ddate);
			$flname = str_replace_array(':', ['', ''], $ddate);		
			$flname = substr($flname, 2);
			$unique_name = $cid ."_". $flname;
			$fn = $unique_name . '.png';
			$path = 'banners/'. $fn;		
			Storage::disk('uploads')->put($path, $info);	
			if($tmpImages != "") {
				$arrImages = explode(',', $tmpImages);
				foreach($arrImages as $bn) {
					$ban = str_replace("/temporary/","",$bn);
					Storage::disk('temporary')->delete($ban);
				}
			}
			$data = [
				'customer_id' => $cid,				
				'description' => $title,
				'filename' => $fn,													
			];				
			$p = Banner::create($data);
			$request->session()->forget('numOfBanners');
			$ctr = $this->updateBannerCounter();				
			return response()->json(['path' => $path]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	
	public function imageUpload(Request $request) {
		try {
			if ($request->isMethod('get')) { 
				//return view('ajax_image_upload');
			} else {
				$validator = Validator::make($request->all(), ['file' => 'image',], [
						'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
				]);
				if($validator->fails()) {
					return $validator->errors();
				} else {                
					$extension = $request->file('file')->getClientOriginalExtension();            
					$filename = uniqid() . '_' . time() . '.' . $extension;
					$path = 'banners/'.$filename;
					$file = $request->file('file');
					$dat = getimagesize($file);
					$width = $dat[0];
					$height = $dat[1];
					$image = Image::make($file);
					if($width > 550 || $height > 270) {
						if($width >= $height) {
							$image->widen(300);
						} else {
							$image->heighten(160);
						}				
					}				
					Storage::disk('temporary')->put($path, (string) $image->encode());	
					$imgsrc = "/temporary/banners/" . $filename;
					return $imgsrc;
				}
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    
    public function maker_post(Request $request) {
        if(AdminController::isLogin()) {
			try {
				if ($request->hasFile('filename')) {			
					if ($request->file('filename')->isValid()) {
						$file = $request->file('filename');								
						$dt = Carbon::now();
						$cid = session('user')->customer_id;					
						$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());					
						$ddate = str_replace_array(' ', [''], $ddate);
						$flname = str_replace_array(':', ['', ''], $ddate);	
						$flname = substr($flname, 2);
						$unique_name = $cid ."_". $flname;
						$fn = $unique_name . '.png';
						$fn2 = $unique_name . '.gif';					
						$path = 'banners/'.$fn;
						$path2 = 'banners/'.$fn2;
						$thumbpath = 'banners/thumbs/'.$fn;
						$thumbpath2 = 'banners/thumbs/'.$fn2;			
						$lf = 'banners/'.$unique_name.'_1200x630.png';
						$lf2 = 'banners/'.$unique_name.'_1200x630.gif';
						$ext = $request->file('filename')->extension();					
						$filename = $fn;					
						$rt = route('banner.selection');				
						$fileTypes = ['jpg' => 'jpg', 'jpeg' => 'jpeg', 'bmp' => 'bmp', 'png' => 'png', 'gif' => 'gif'];					
						$fsize = $request->file('filename')->getSize();						
						if(array_has($fileTypes, $ext)) {
							if($fsize <= 16000000) {								
								$image = Image::make($file);
								if($ext != "gif") {										
									$image->resize(600, 314);	
									Storage::disk('uploads')->put($path, (string) $image->encode());												
								} else {			
									$image->resize(600, 314);	
									Storage::disk('uploads')->put($path2, (string) $image->encode());								
									$filename = $fn2;
								}								
							} else {
								return view('admin.invalid_format', ['title' => 'Filesize limit exceeded', 'route' => $rt, 'runningbg' => session('runningbg')]);
							}				
						} else {
							return view('admin.invalid_format', ['title' => 'Invalid file type', 'route' => $rt, 'runningbg' => session('runningbg')]);
						}
						$img = public_path('publicimages/banners/'.$filename);
						$imgsrc = "/publicimages/banners/" . $filename;
						$info = getimagesize($img);
						$nwidth = $info[0];
						$nheight = $info[1];		
						$url = url('banner-image-upload');
						$createUrl = url('create-banner');
						$bannersRoute = route('banners'); 
						$csrf = csrf_token();
						return view('admin.banner_maker_save', ['title' => 'Banner Maker Upload', 'bannersRoute' => $bannersRoute, 'createUrl' => $createUrl, 'csrf' => $csrf, 'url' => $url, 'mtype' => 'image', 'filename' => $imgsrc, 'nwidth' => $nwidth, 'nheight' => $nheight, 'imgsrc' => $imgsrc, 'runningbg' => session('runningbg')]);						
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
	
	public function update_banner() {
		try {
			$filename = $request->input('filename');		
			return $filename;		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	
    public function store(Request $request) {
        if(AdminController::isLogin()) {
			try {
				if ($request->hasFile('filename')) {			
					if ($request->file('filename')->isValid()) {
						$file = $request->file('filename');					
						$description = $request->input('description', '');				
						$dt = Carbon::now();
						$cid = session('user')->customer_id;
						$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());						
						$ddate = str_replace_array(' ', [''], $ddate);
						$flname = str_replace_array(':', ['', ''], $ddate);		
						$flname = substr($flname, 2);
						$unique_name = $cid ."_". $flname;
						$fn = $unique_name . '.png';
						$fn2 = $unique_name . '.gif';					
						$path = 'banners/'.$fn;
						$path2 = 'banners/'.$fn2;
						$thumbpath = 'banners/thumbs/'.$fn;
						$thumbpath2 = 'banners/thumbs/'.$fn2;			
						$lf = 'banners/'.$unique_name.'_1200x630.png';
						$lf2 = 'banners/'.$unique_name.'_1200x630.gif';
						$ext = $request->file('filename')->extension();					
						$filename = $fn;					
						$rt = route('banner.selection');				
						$fileTypes = ['jpg' => 'jpg', 'jpeg' => 'jpeg', 'bmp' => 'bmp', 'png' => 'png', 'gif' => 'gif'];					
						$fsize = $request->file('filename')->getSize();						
						if(array_has($fileTypes, $ext)) {
							if($fsize <= 16000000) {								
								$image = Image::make($file);
								if($ext != "gif") {										
									$image->resize(640, 336);	
									Storage::disk('uploads')->put($path, (string) $image->encode());
									$image->resize(1200, 630);	
									Storage::disk('uploads')->put($lf, (string) $image->encode());
									$image->widen(130);								
									Storage::disk('uploads')->put($thumbpath, (string) $image->encode());				
								} else {			
									$image->resize(640, 336);	
									Storage::disk('uploads')->put($path2, (string) $image->encode());
									$image->resize(1200, 630);	
									Storage::disk('uploads')->put($lf2, (string) $image->encode());
									$image->widen(130);								
									Storage::disk('uploads')->put($thumbpath2, (string) $image->encode());
									$filename = $fn2;
								}								
							} else {
								return view('admin.invalid_format', ['title' => 'Filesize limit exceeded', 'route' => $rt, 'runningbg' => session('runningbg')]);
							}				
						} else {
							return view('admin.invalid_format', ['title' => 'Invalid file type', 'route' => $rt, 'runningbg' => session('runningbg')]);
						}
						$img = public_path('publicimages/banners/'.$filename);
						$imgsrc = "/publicimages/banners/" . $filename;
						$info = getimagesize($img);
						$nwidth = $info[0];
						$nheight = $info[1];
						return view('admin.banner_save', ['title' => 'Banner Creator', 'description' => $description, 'nwidth' => $nwidth, 'nheight' => $nheight, 'imgsrc' => $imgsrc, 'flname' => $filename, 'runningbg' => session('runningbg')]);						
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
	
	public function save(Request $request) {
		try {
			if(AdminController::isLogin()) {	
				$filename = $request->input('filename', '');
				$img = public_path('publicimages/banners/thumbs/'.$filename);
				$info = getimagesize($img);
				$width = $info[0];
				$height = $info[1];
				$data = [
					'customer_id' => session('user')->customer_id,				
					'description' => $request->input('description', ''),
					'filename' => $filename,				
					'thumb_width' => $width,
					'thumb_height' => $height,							
				];				
				$p = Banner::create($data);
				$request->session()->forget('numOfBanners');
				$ctr = $this->updateBannerCounter();			
				return redirect()->route('banners');
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
				$img = public_path('/publicimages/banners/'.$flname);
				$thumb = public_path('/publicimages/banners/thumbs/'.$flname);
				$rt = route('banner.selection');		
				if (!unlink($img))  {			 
					 return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
				} else {
					if (!unlink($thumb)) {
						return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
					} else {
						return redirect()->route('banners');
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
}
