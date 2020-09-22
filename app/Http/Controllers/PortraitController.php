<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Portrait;
use Illuminate\Support\Facades\DB;
use Image;
use Storage;
use Carbon\Carbon;
use App\Exceptions\GeneralException;

class PortraitController extends Controller
{
    public function index()
    {
        if(AdminController::isLogin()) {
			try {
				$cid = session('user')->customer_id;
				$portraits = Portrait::where('customer_id', $cid)->orderBy('filename', 'desc')->paginate(5);
				$numOfPortraits = Portrait::where('customer_id', $cid)->count();
				return view('admin.portraits', ['title' => 'Portraits Page', 'portraits' => $portraits, 'numOfPortraits' => $numOfPortraits, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
    public function search(Request $request) {		
			if(AdminController::isLogin()) {
				try {
					$cid = session('user')->customer_id;
					$sr = $request->input('portrait');
					$numOfPortraits = Portrait::where('customer_id', $cid)->count();
					$portraits = DB::table('customer_portrait')
							->where('customer_id', '=', $cid)
							->where(function ($query) use ($sr) {
									$go = '%'.$sr.'%';
									$query->where('id', 'like', $go)
											->orWhere('caption', 'like', $go)
											->orWhere('location', 'like', $go)
											->orWhere('status', 'like', $go)
											->orWhere('filename', 'like', $go);
							})->paginate(5);
					return view('admin.portraits', ['title' => 'Portrait Search Page', 'portraits' => $portraits, 'numOfPortraits' => $numOfPortraits, 'runningbg' => session('runningbg')]);
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
			try {
				$primarycntr = Portrait::where('customer_id', session('user')->customer_id)->where('primary_portrait', 'Yes')->count();			
				$hasPrimary = 'no';
				if($primarycntr > 0) { $hasPrimary = 'yes'; }
				return view('admin.portrait_add', ['title' => 'Portrait Uploader Page', 'hasPrimary' => $hasPrimary, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }
    }
	public function getUniqueFilename($ext) {
		$dt = Carbon::now();
		$cid = session('user')->customer_id;
		$ddate = str_replace_array('-', ['', ''], $dt->toDateTimeString());						
		$ddate = str_replace_array(' ', [''], $ddate);
		$flname = str_replace_array(':', ['', ''], $ddate);		
		$flname = substr($flname, 2);
		$unique_name = $cid ."-". $flname;
		$ex = '.gif';
		if($ext != "gif") {
			$ex = '.jpg';
		}
		return $unique_name.$ex;
	}
    public function store(Request $request) {		
			if(AdminController::isLogin()) {
				try {
					if ($request->hasFile('filename')) {			
						if ($request->file('filename')->isValid()) {
							$rt = route('portrait.add');
							if($request->file('filename')->getSize() <= 47185920) {
								$file = $request->file('filename');		
								$ext = $request->file('filename')->extension();	
								$caption = $request->input('caption', '');	
								$primary_portrait = $request->input('primary_portrait', '');								
								$fn = $this->getUniqueFilename($ext);													
								$path = 'portraits/'.$fn;												
								$dat = getimagesize($file);
								$width = $dat[0];
								$height = $dat[1];													
								$fileTypes = ['jpg' => 'jpg', 'jpeg' => 'jpeg', 'bmp' => 'bmp', 'png' => 'png', 'gif' => 'gif'];								
								if(array_has($fileTypes, $ext)) {					
									$image = Image::make($file);												
									if($width > 200) {									
										$image->widen(200);														
										Storage::disk('uploads')->put($path, (string) $image->encode());
									} else {			
										$image->resize($width,$height);	
										Storage::disk('uploads')->put($path, (string) $image->encode());
									}																	
								} else {
									return view('admin.invalid_format', ['title' => 'Invalid file type', 'route' => $rt, 'runningbg' => session('runningbg')]);
								}
								$img = public_path('publicimages/portraits/'.$fn);
								$imgsrc = "/publicimages/portraits/" . $fn;
								$info = getimagesize($img);
								$nwidth = $info[0];
								$nheight = $info[1];
								return view('admin.portrait_save', ['title' => 'Portrait Creator Page', 'ext' => $ext, 'primary' => $primary_portrait, 'caption' => $caption, 'nwidth' => $nwidth, 'nheight' => $nheight, 'imgsrc' => $imgsrc, 'flname' => $fn, 'runningbg' => session('runningbg')]);							
							} else {
								return view('admin.invalid_format', ['title' => 'Filesize limit exceeded', 'route' => $rt, 'runningbg' => session('runningbg')]);
							}
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
	public function getAngle(Request $request) {
		$angle = (int)$request->input('angle');			
		$filename = $request->input('filename');
		$ext = $request->input('ext');
		$path = public_path('publicimages/portraits/');
		$src = $path.$filename;
		$fn = $this->getUniqueFilename($ext);
		$newpath = $path.$fn;
		$image = Image::make($src);
		$image->rotate($angle);
		$image->save($newpath);
		unlink($src);		
		$info = getimagesize($newpath);
		$width = $info[0];
		$height = $info[1];		
		$btn = '<a href="'.route('cancel.portrait', ['flname' => $fn]).'" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>';
		return response()->json(['path' => $newpath, 'filename' => $fn, 'width' => $width, 'height' => $height, 'btn' => $btn]);			
    }
	public function save(Request $request) {
		
			if(AdminController::isLogin()) {	
				try {
					$filename = $request->input('filename', '');
					$img = public_path('publicimages/portraits/'.$filename);
					$info = getimagesize($img);
					$width = $info[0];
					$height = $info[1];
					$pstat = $request->input('primary_portrait', '');					
					$data = [
						'customer_id' => session('user')->customer_id,			
						'caption' => $request->input('caption', ''),
						'primary_portrait' => $pstat,				
						'filename' => $filename,					
						'width' => $width,
						'height' => $height,		
						'status' => 'Active',
						'location' => session('location'),
					];							
					$pr = Portrait::create($data);					
					if($pstat == "Yes") {
						$lup = Portrait::where('id', '!=', $pr->id)->update(['primary_portrait' => 'No']);						
					}
					$request->session()->forget('numOfPortraits');			
					$ctr = $this->updatePortraitCounter();			
					return redirect()->route('portraits');
				} catch(\Exception $e) {
					$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
					throw new GeneralException("Oops! There was an error somewhere in the process.");
				}
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}		
    }	
	public function updatePortraitCounter() {
		try {
			$numOfPortraits = Portrait::where('customer_id', session('user')->customer_id)->count();
			session(['numOfPortraits' => $numOfPortraits]);
			return $numOfPortraits;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function cancel($flname) {
		try {
			if(AdminController::isLogin()) {
				return $this->removePortrait($flname);
			} else {
				return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function removePortrait($flname) {
		try {
			$img = public_path('/publicimages/portraits/'.$flname);		
			$rt = route('portrait.add');		
			if (!unlink($img))  {			 
				return view('admin.invalid_format', ['title' => 'Error cancelling this file', 'route' => $rt, 'runningbg' => session('runningbg')]);
			} else {
				return redirect()->route('portraits');			
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function setPrimary(Request $request, $id) {
		if(AdminController::isLogin()) {		
			try {
				$lup = Portrait::where('id', '!=', $id)->update(['primary_portrait' => 'No']);
				$ok = Portrait::where('id', $id)->update(['primary_portrait' => 'Yes']);
				return redirect()->route('portraits');
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
			$portrait = Portrait::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			return view('admin.portrait_delete', ['title' => 'Delete Portrait', 'portrait' => $portrait, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
    public function destroy($id) {
		try {
			$portrait = Portrait::where('id', $id)->where('customer_id', session('user')->customer_id)->first();
			$flname = $portrait->filename;
			$l = Portrait::where('id', $id)->where('customer_id', session('user')->customer_id)->delete();
			$ctr = $this->updatePortraitCounter();
			return $this->removePortrait($flname);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
