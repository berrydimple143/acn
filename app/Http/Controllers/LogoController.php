<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Logo;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Exceptions\GeneralException;
use Storage;

class LogoController extends Controller
{
    public function index()
    {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$logos = Logo::where('customer_id', $cid)->orderBy('filename', 'desc')->paginate(5);
				$numOfLogos = Logo::where('customer_id', $cid)->count();
				return view('admin.logos', ['title' => 'Logo Page', 'logos' => $logos, 'numOfLogos' => $numOfLogos, 'runningbg' => session('runningbg')]);
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
					$numOfLogos = Logo::where('customer_id', $cid)->count();
					$sr = $request->input('logo');
					$logos = DB::table('customer_logo')
							->where('customer_id', '=', $cid)
							->where(function ($query) use ($sr) {
									$go = '%'.$sr.'%';
									$query->where('id', 'like', $go)
											->orWhere('caption', 'like', $go)
											->orWhere('location', 'like', $go)                                        
											->orWhere('filename', 'like', $go);
							})->paginate(5);
					return view('admin.logos', ['title' => 'Logo Search Page', 'logos' => $logos, 'numOfLogos' => $numOfLogos, 'runningbg' => session('runningbg')]);
			} else {
					return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    } 
    public function create()
    {
        if(AdminController::isLogin()) {
			try {
				return view('admin.logo_add', ['title' => 'Logo Uploader Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
    public function store(Request $request) {
        if(AdminController::isLogin()) {
			try {
				if ($request->hasFile('filename')) {			
					if ($request->file('filename')->isValid()) {
						$file = $request->file('filename');					
						$caption = $request->input('caption', '');	
						$primary_logo = $request->input('primary_logo', '');	
						$dt = Carbon::now();
						$cid = session('user')->customer_id;
						$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());						
						$ddate = str_replace_array(' ', [''], $ddate);
						$flname = str_replace_array(':', ['', ''], $ddate);		
						$flname = substr($flname, 2);
						$unique_name = $cid ."-". $flname;
						$fn = $unique_name . '.png';
						$fn2 = $unique_name . '.gif';				
						$path = 'logos/'.$fn;
						$path2 = 'logos/'.$fn2;
						$thumbpath = 'logos/thumb_'.$fn;
						$thumbpath2 = 'logos/thumb_'.$fn2;				
						$dat = getimagesize($file);
						$width = $dat[0];
						$height = $dat[1];
						$ext = $request->file('filename')->extension();					
						$filename = $fn;					
						$rt = route('logo.add');				
						$fileTypes = ['jpg' => 'jpg', 'jpeg' => 'jpeg', 'bmp' => 'bmp', 'png' => 'png', 'gif' => 'gif'];								
						if(array_has($fileTypes, $ext)) {													
							$image = Image::make($file);
							if($ext != "gif") {									
								if($width > 308) {					
									$image->widen(308);														
									Storage::disk('uploads')->put($path, (string) $image->encode());
								} else {			
									$image->resize($width,$height);	
									Storage::disk('uploads')->put($path, (string) $image->encode());
								}
								$image->resize(128, 96);								
								Storage::disk('uploads')->put($thumbpath, (string) $image->encode());
							} else {							
								if($width > 308) {					
									$image->widen(308);														
									Storage::disk('uploads')->put($path2, (string) $image->encode());
								} else {			
									$image->resize($width,$height);	
									Storage::disk('uploads')->put($path2, (string) $image->encode());
								}
								$image->resize(128, 96);								
								Storage::disk('uploads')->put($thumbpath2, (string) $image->encode());
								$filename = $fn2;
							}									
						} else {
							return view('admin.invalid_format', ['title' => 'Invalid file type', 'route' => $rt, 'runningbg' => session('runningbg')]);
						}
						$img = public_path('publicimages/logos/'.$filename);
						$imgsrc = "/publicimages/logos/" . $filename;
						$info = getimagesize($img);
						$nwidth = $info[0];
						$nheight = $info[1];
						return view('admin.logo_save', ['title' => 'Logo Creator Page', 'primary' => $primary_logo, 'caption' => $caption, 'nwidth' => $nwidth, 'nheight' => $nheight, 'imgsrc' => $imgsrc, 'flname' => $filename, 'runningbg' => session('runningbg')]);						
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
				$img = public_path('publicimages/logos/'.$filename);
				$info = getimagesize($img);
				$width = $info[0];
				$height = $info[1];
				$data = [
					'customer_id' => session('user')->customer_id,			
					'caption' => $request->input('caption', ''),
					'primary_logo' => $request->input('primary_logo', ''),				
					'filename' => $filename,	
					'selected' => 'No',
					'width' => $width,
					'height' => $height,		
					'status' => 'Active',
					'location' => session('location'),
				];							
				$lg = Logo::create($data);	
				$c = $this->updatePrimary($lg->id);
				$request->session()->forget('numOfLogos');			
				$ctr = $this->updateLogoCounter();			
				return redirect()->route('logos');
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
			return $this->removeLogo($flname);			
        } else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function removeLogo($flname) {
		try {
			$img = public_path('/publicimages/logos/'.$flname);
			$thumb = public_path('/publicimages/logos/thumb_'.$flname);
			$rt = route('logo.add');		
			if (!unlink($img))  {			 
				 return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
			} else {
				if (!unlink($thumb)) {
					return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
				} else {
					return redirect()->route('logos');
				}
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function setPrimary(Request $request, $id) {
		if(AdminController::isLogin()) {	
			try {
				$c = $this->updatePrimary($id);
				$ok = Logo::where('id', $id)->update(['primary_logo' => 'Yes']);
				return redirect()->route('logos');
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
	}
	public function updatePrimary($id) {
		try {
			$logos = Logo::where('id', '!=', $id)->get();
			foreach($logos as $lg) {
				$lup = Logo::where('id', $lg->id)->update(['primary_logo' => 'No']);
			}		
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }    
	public function updateLogoCounter() {
		try {
			$numOfLogos = Logo::where('customer_id', session('user')->customer_id)->count();
			session(['numOfLogos' => $numOfLogos]);
			return $numOfLogos;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function delete($id) {
		try {
			$logo = Logo::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.logo_delete', ['title' => 'Delete Logo', 'logo' => $logo, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function destroy($id) {
		try {
			$logo = Logo::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			$flname = $logo->filename;
			$l = Logo::where('id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updateLogoCounter();
			return $this->removeLogo($flname);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
