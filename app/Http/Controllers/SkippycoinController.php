<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\User;
use App\Skippycoin;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Storage;
use Carbon\Carbon;
use App\Exceptions\SkippycoinException;
use App\Exceptions\GeneralException;

class SkippycoinController extends Controller
{    
    public function index() {
        if(AdminController::isLogin()) {
			try {
				$wallet = session('user')->customer_skcwallet;			
				return view('admin.skippycoin', ['title' => 'Skippycoin Page', 'status' => '', 'wallet' => $wallet, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        }		
    }
	
	public function status() {
		try {
			$sk = Skippycoin::where('status', '!=', '')->first();
			$status = $sk->status;
			return view('admin.skippycoin_status', ['title' => 'Skippycoin Status Page', 'status' => $status, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	
	public function status_update($old) {
		try {
			$stat = 'off';
			if($old == 'off') {
					$stat = 'on';
			}
			$sk = Skippycoin::where('id', '>', 0)->update(['status' => $stat]);	
			return redirect()->route('skippycoin.status');
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}

	public function store_wallet(Request $request) {
		try {
			$v = $request->validate([
				'customer_skcwallet' => 'required|string',				
			]);
			$id = session('user')->customer_id;
			$address = $request->input('customer_skcwallet', '');
			if($this->validateAddress($address)) {			
				$c = User::where('customer_id', $id)->update(['customer_skcwallet' => $address]);
				$user = User::where('customer_id', $id)->first(); 
				session(['user' => $user]);
				return redirect()->route('skippycoin');
			} else {
				return redirect()->route('skippycoin.failed', ['errorMessage' => 'failed']);
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	
	public function skcFailed($errorMessage) {
		try {
			$wallet = session('user')->customer_skcwallet;			
			return view('admin.skippycoin', ['title' => 'Skippycoin Page', 'status' => $errorMessage, 'wallet' => $wallet, 'runningbg' => session('runningbg')]);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	
	public function validateAddress($address) {
		$decoded = $this->decodeBase58($address);
		$d1 = hash("sha256", substr($decoded, 0, 21) , true);
		$d2 = hash("sha256", $d1, true);
		if (substr_compare($decoded, $d2, 21, 4)) {
			throw new SkippycoinException("Invalid Wallet Address");
		}
		return true;			
	}
	
	public function decodeBase58($input) {
		try {
			$alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
			$out = array_fill(0, 25, 0);
			for ($i = 0; $i < strlen($input); $i++) {
				if (($p = strpos($alphabet, $input[$i])) === false) {
					throw new SkippycoinException("Invalid Wallet Address");				
				}
				$c = $p;
				for ($j = 25; $j--;) {
					$c+= (int)(58 * $out[$j]);
					$out[$j] = (int)($c % 256);
					$c/= 256;
					$c = (int)$c;
				}
				if($c != 0) {
					throw new SkippycoinException("Invalid Wallet Address");
				}
			}
			$result = "";
			foreach($out as $val) {
				$result.= chr($val);
			}
			return $result;
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
}
