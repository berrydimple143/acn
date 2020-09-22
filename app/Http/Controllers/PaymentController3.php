<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal;
use Redirect;
use Carbon\Carbon;
use App\Privilege;
use App\User;
use App\PaymentDetail;
use Illuminate\Support\Str;
use App\Exceptions\GeneralException;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class PaymentController extends Controller
{    
	public function processPayment(Request $request) {
		try {
			$cmd = $request->input('cmd', '');
			$business = $request->input('business', '');
			$item_name = $request->input('item_name', '');
			$membership = $request->input('item_number', '');
			$membership = str_replace_first(' ', '-', $membership);			
			$on0 = $request->input('on0', '');
			$os0 = $request->input('os0', '');
			$image_url = $request->input('image_url', '');		
			$currency_code = $request->input('currency_code', '');
			$a3 = $request->input('a3', '');
			$p3 = $request->input('p3', '');
			$t3 = $request->input('t3', '');
			$return = $request->input('return', '');
			$cancel_return = $request->input('cancel_return', '');
			$src = $request->input('src', '');		
			$sra = $request->input('sra', '');
			$receiver_email = $request->input('receiver_email', '');
			$no_shipping = $request->input('no_shipping', '');
			$no_note = $request->input('no_note', '');
			$on1 = $request->input('on1', '');
			$mrb = $request->input('mrb', '');
			$pal = $request->input('pal', '');
			$subscription = $request->input('subscription', '');
			$price = $request->input('price', '');			
			return $this->payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price);			
		} catch(\Exception $e) {
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price) {
        $oldlevel = session('user')->customer_level;
		$newlevel = Str::replaceFirst('-', ' ', $membership);
		if($oldlevel == $newlevel) {
			return redirect()->route('membership');
		} else {
			$id = session('user')->customer_id;      			   
			$desc = ucfirst($subscription) . " ARN Subscription";
			$price = (float)($price);			
			
			$myurl = "/paypal/". $id . "/" . $subscription . "/" . $price . "/" . $membership;
			$furl = "/payments/fails/" . $id; 		
			$data = [];
			$data['items'] = [
				[
					'name'  => $desc,
					'price' => $price,
					'qty'   => 1,
				],
			];
			$data['subscription_desc'] = "ARN payment for " . $subscription . " subscription";
			$data['invoice_id'] = 1;
			$data['invoice_description'] = $desc;
			$data['return_url'] = url($myurl.'/success?mode=recurring');
			$data['cancel_url'] = url($furl);
			$total = 0;
			foreach ($data['items'] as $item) {
				$total += $item['price'] * $item['qty'];
			}
			$data['total'] = $total;			
			
			$provider = PayPal::setProvider('express_checkout');
			$response = $provider->setCurrency('AUD')->setExpressCheckout($data, true);			
			return redirect($response['paypal_link']);			
		}
    }	
	public function returnView($id, $subscription, $price, $membership, $oldlevel, $pid) {
		$membership = Str::replaceFirst('-', ' ', $membership);		        
		$status = 'same';
		$updateData = $this->updateUserData($id, $membership);
		if($this->upgrade($membership, $oldlevel)) {
			$status = 'upgrade';
		} else if($this->downgrade($membership, $oldlevel)) {
			$status = 'downgrade';
		}
		return view('admin.payment_successful', [
			'title' => 'Payment Successful Page', 
			'runningbg' => session('runningbg'),
			'id' => $id, 
			'status' => $status,						 
			'subscription' => $subscription, 
			'price' => $price, 
			'membership' => $membership
		]);
	}
	public function payment_successful(Request $request, $id, $subscription, $price, $membership) {
		try {
			$pid = session('payment_id');
			session(['runningbg' => session('runningbg')]);
			session(['unsafe_loc' => session('location')]);
			session(['unsafe_url' => session('url')]);
			session(['location' => session('location')]);
			session(['url' => session('url')]);
			$m = session('user')->customer_level;		
			$token = $request->query('token', '');
			$provider = PayPal::setProvider('express_checkout');
			$response = $provider->getExpressCheckoutDetails($token);			
			$startdate = Carbon::now()->toAtomString();
			$profile_desc = "ARN payment for " . $subscription . " subscription";
			$freq = 'Year';
			$period = 'Yearly';
			if($subscription == 'monthly') { $freq = 'Month'; $period = 'Monthly'; }
			$data = [
				'PROFILESTARTDATE' => $startdate,
				'DESC' => $profile_desc,
				'BILLINGPERIOD' => $freq,
				'BILLINGFREQUENCY' => 1,  
				'AMT' => $price,
				'CURRENCYCODE' => 'AUD', 
				'TRIALBILLINGPERIOD' => 'Day',
				'TRIALBILLINGFREQUENCY' => 10, 
				'TRIALTOTALBILLINGCYCLES' => 1,
				'TRIALAMT' => $price,
			];
			$response2 = $provider->createRecurringPaymentsProfile($data, $token);		
			if($freq == 'Month') {
				$response3 = $provider->createMonthlySubscription($token, $price, $profile_desc);
			} else {
				$response3 = $provider->createYearlySubscription($token, $price, $profile_desc);
			}		
			$response["customer_id"] = $id;
			$response["customer_level"] = Str::replaceFirst('-', ' ', $membership);
			$response["period"] = $period;
			$response["date_paid"] = Carbon::now();
			$s = PaymentDetail::create($response);
			return $this->returnView($id, $subscription, $price, $membership, $m, $pid);
		} catch(\Exception $e) {
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }
	public function updateUserData($id, $membership) {
		try {
			$privilege = Privilege::where('level', $membership)->first();		
			$data = [
				'ad_limit' => $privilege->ad_limit,
				'photo_limit' => $privilege->photo_limit,
				'event_limit' => $privilege->event_limit,
				'article_limit' => $privilege->article_limit,
				'customer_level' => $membership,
			];
			$c = User::where('customer_id', $id)->update($data);
			$usr = User::where('customer_id', $id)->first();
			session(['user' => $usr]);
			session(['loggedin' => 'yes']);
			return 'updated';
		} catch(\Exception $e) {
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function payment_failed($id) {
		return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));
        /* return view('admin.payment_successful', [
			'title' => 'Payment Successful Page', 
			'runningbg' => session('runningbg'),
			'id' => $id, 
			'status' => $status,						 
			'subscription' => $subscription, 
			'price' => $price, 
			'membership' => $membership
		]); */
    }
	private function upgrade($lv, $m) {
		$g = false;
		if($lv == "Community Leader" && $m == "Local Resident") {
			$g = true;		
		} else if($lv == "Local Business" && $m == "Local Resident") {
			$g = true;
		} else if($lv == "National Business" && $m == "Local Resident") {
			$g = true;
		} else if($lv == "Local Business" && $m == "Community Leader") {
			$g = true;
		} else if($lv == "National Business" && $m == "Community Leader") {
			$g = true;
		} else if($lv == "National Business" && $m == "Local Business") {
			$g = true;	
		}
		return $g;         
    }
	private function downgrade($lv, $m) {
		$g = false;		
		if($lv == "Local Resident" && $m == "Community Leader") {
			$g = true;
		} else if($lv == "Local Resident" && $m == "Local Business") {
			$g = true;	
		} else if($lv == "Local Resident" && $m == "National Business") {
			$g = true;	
		} else if($lv == "Community Leader" && $m == "Local Business") {
			$g = true;	
		} else if($lv == "Community Leader" && $m == "National Business") {
			$g = true;	
		} else if($lv == "Local Business" && $m == "National Business") {
			$g = true;		
		}
		return $g;         
    }
}
