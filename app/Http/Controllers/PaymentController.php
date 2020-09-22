<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal;
use Redirect;
use Carbon\Carbon;
use App\IPNStatus;
use App\Privilege;
use App\User;
use App\PaymentDetail;
use Illuminate\Support\Str;
use App\Exceptions\GeneralException;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use Storage;

class PaymentController extends Controller
{    
	protected $provider;	
	
	public function __construct() {
        $this->provider = new ExpressCheckout();
    }	
	public function processPayment(Request $request) {
		try {
			$cmd = $request->input('cmd', '');
			$business = $request->input('business', '');
			$item_name = $request->input('item_name', '');
			$membership = $request->input('item_number', '');			
			$on0 = $request->input('on0', '');
			$os0 = $request->input('os0', '');
			$image_url = $request->input('image_url', '');		
			$currency_code = $request->input('currency_code', '');			
			$a1 = $request->input('a1', '');
			$p1 = $request->input('p1', '');
			$t1 = $request->input('t1', '');			
			$a2 = $request->input('a2', '');
			$p2 = $request->input('p2', '');
			$t2 = $request->input('t2', '');			
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
			return $this->payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a1, $p1, $t1, $a2, $p2, $t2, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price);			
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a1, $p1, $t1, $a2, $p2, $t2, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price) {
        try {
			$oldlevel = session('user')->customer_level;		
			if($oldlevel == $membership) {
				return redirect()->route('membership');
			} else {
				$id = session('user')->customer_id;   
				$longdesc = "ARN payment for " . $subscription . " subscription";
				$desc = $id . "|@|" . $membership . "|@|" . $subscription;
				$price = (float)($price);			
				$data = [];
				$data['items'] = [
					[
						'name'  => $desc,
						'price' => $price,
						'qty'   => 1,
					],
				];
				$data['subscription_desc'] = $longdesc;
				$data['invoice_id'] = 1;
				$data['invoice_description'] = $longdesc;
				$data['return_url'] = url('/payment/successful?mode=recurring');
				$data['cancel_url'] = url('/payment/failed');
				$total = 0;
				foreach ($data['items'] as $item) {
					$total += $item['price'] * $item['qty'];
				}
				$data['total'] = $total;			
				$response = $this->provider->setCurrency('AUD')->setExpressCheckout($data, true);			
				return redirect($response['paypal_link']);			
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
    }	
	public function returnView($id, $subscription, $price, $membership, $oldlevel, $pid) {
		try {
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
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function manage_paypal_ipn(Request $request) {
		try {
			if (!($this->provider instanceof ExpressCheckout)) {
				$this->provider = new ExpressCheckout();
			} 
			$post = [
				'cmd' => '_notify-validate',
			]; 
			$data = $request->all();
			foreach ($data as $key => $value) { 
				$post[$key] = $value;
			}
			$response = (string) $this->provider->verifyIPN($post);
			if($response == "VERIFIED") {
				$p = PaymentDetail::where('PAYERID', $post["payer_id"])->first();	
				$rec_count = PaymentDetail::where('PAYERID', $post["payer_id"])->where('customer_id', $p->customer_id)->count();	
				$now = Carbon::now();
				if($post["profile_status"] == "Cancelled") {				
					$privilege = Privilege::where('level', 'Local Resident')->first();
					$data = [
						'ad_limit' => $privilege->ad_limit,
						'photo_limit' => $privilege->photo_limit,
						'event_limit' => $privilege->event_limit,
						'article_limit' => $privilege->article_limit,
						'customer_level' => 'Local Resident',
					];
					$c = User::where('customer_id', $p->customer_id)->update($data);
					$date_cancelled = $now;
					$date_paid = $p->date_paid;
				} else {
					$date_cancelled = null;
					$date_paid = $now;
				}		
				$ipn = new PaymentDetail();
				$ipn->TOKEN = $p->TOKEN;
				$ipn->BILLINGAGREEMENTACCEPTEDSTATUS = $p->BILLINGAGREEMENTACCEPTEDSTATUS;
				$ipn->CHECKOUTSTATUS = $p->CHECKOUTSTATUS;
				$ipn->TIMESTAMP = $p->TIMESTAMP;
				$ipn->CORRELATIONID = $p->CORRELATIONID;
				$ipn->ACK = $p->ACK;
				$ipn->VERSION = $p->VERSION;
				$ipn->BUILD = $p->BUILD;
				$ipn->EMAIL = $p->EMAIL;
				$ipn->PAYERID = $p->PAYERID;
				$ipn->PAYERSTATUS = $p->PAYERSTATUS;
				$ipn->FIRSTNAME = $p->FIRSTNAME;
				$ipn->LASTNAME = $p->LASTNAME;
				$ipn->COUNTRYCODE = $p->COUNTRYCODE;
				$ipn->ADDRESSSTATUS = $p->ADDRESSSTATUS;
				$ipn->CURRENCYCODE = $p->CURRENCYCODE;
				$ipn->AMT = $p->AMT;
				$ipn->ITEMAMT = $p->ITEMAMT;
				$ipn->SHIPPINGAMT = $p->SHIPPINGAMT;
				$ipn->HANDLINGAMT = $p->HANDLINGAMT;
				$ipn->TAXAMT = $p->TAXAMT;
				$ipn->DESC = $p->DESC;
				$ipn->INVNUM = $p->INVNUM;
				$ipn->NOTIFYURL = $p->NOTIFYURL;
				$ipn->INSURANCEAMT = $p->INSURANCEAMT;
				$ipn->SHIPDISCAMT = $p->SHIPDISCAMT;
				$ipn->INSURANCEOPTIONOFFERED = $p->INSURANCEOPTIONOFFERED;
				$ipn->L_NAME0 = $p->L_NAME0;
				$ipn->L_QTY0 = $p->L_QTY0;
				$ipn->L_TAXAMT0 = $p->L_TAXAMT0;
				$ipn->L_AMT0 = $p->L_AMT0;
				$ipn->PAYMENTREQUEST_0_CURRENCYCODE = $p->PAYMENTREQUEST_0_CURRENCYCODE;
				$ipn->PAYMENTREQUEST_0_AMT = $p->PAYMENTREQUEST_0_AMT;
				$ipn->PAYMENTREQUEST_0_ITEMAMT = $p->PAYMENTREQUEST_0_ITEMAMT;
				$ipn->PAYMENTREQUEST_0_SHIPPINGAMT = $p->PAYMENTREQUEST_0_SHIPPINGAMT;
				$ipn->PAYMENTREQUEST_0_HANDLINGAMT = $p->PAYMENTREQUEST_0_HANDLINGAMT;
				$ipn->PAYMENTREQUEST_0_TAXAMT = $p->PAYMENTREQUEST_0_TAXAMT;
				$ipn->PAYMENTREQUEST_0_DESC = $p->PAYMENTREQUEST_0_DESC;
				$ipn->PAYMENTREQUEST_0_INVNUM = $p->PAYMENTREQUEST_0_INVNUM;
				$ipn->PAYMENTREQUEST_0_NOTIFYURL = $p->PAYMENTREQUEST_0_NOTIFYURL;
				$ipn->PAYMENTREQUEST_0_INSURANCEAMT = $p->PAYMENTREQUEST_0_INSURANCEAMT;
				$ipn->PAYMENTREQUEST_0_SHIPDISCAMT = $p->PAYMENTREQUEST_0_SHIPDISCAMT;
				$ipn->PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID = $p->PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID;
				$ipn->PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED = $p->PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED;
				$ipn->L_PAYMENTREQUEST_0_NAME0 = $p->L_PAYMENTREQUEST_0_NAME0;
				$ipn->L_PAYMENTREQUEST_0_QTY0 = $p->L_PAYMENTREQUEST_0_QTY0;
				$ipn->L_PAYMENTREQUEST_0_TAXAMT0 = $p->L_PAYMENTREQUEST_0_TAXAMT0;
				$ipn->L_PAYMENTREQUEST_0_AMT0 = $p->L_PAYMENTREQUEST_0_AMT0;
				$ipn->PAYMENTREQUESTINFO_0_ERRORCODE = $p->PAYMENTREQUESTINFO_0_ERRORCODE;
				$ipn->customer_id = $p->customer_id;
				$ipn->customer_level = $p->customer_level;
				$ipn->period = $p->period;
				$ipn->date_paid = $date_paid;
				$ipn->payment_status = $post["profile_status"];
				$ipn->date_cancelled = $date_cancelled;
				if($rec_count > 1 && $post["profile_status"] == "Active") {
					$ipn->save();
				} elseif($rec_count >= 1 && $post["profile_status"] == "Cancelled") {
					$ipn->save();
				} elseif($rec_count == 1 && $post["profile_status"] == "Active") {
					$dp = Carbon::parse($date_paid);
					if($now->gt($dp->addMinute())) {
						$ipn->save();
					}
				}
			}
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function payment_successful(Request $request) {
		try {
			$pid = session('payment_id');
			session(['runningbg' => session('runningbg')]);
			session(['unsafe_loc' => session('location')]);
			session(['unsafe_url' => session('url')]);
			session(['location' => session('location')]);
			session(['url' => session('url')]);
			$m = session('user')->customer_level;		
			$token = $request->query('token', '');			
			$response = $this->provider->getExpressCheckoutDetails($token);	
			$userdata = explode('|@|', $response["L_NAME0"]);
			$id = $userdata[0];
			$membership = $userdata[1];
			$subscription = $userdata[2];
			$price = $response["AMT"];			
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
			];
			/* 'TRIALBILLINGPERIOD' => 'Day',
				'TRIALBILLINGFREQUENCY' => 1, 
				'TRIALTOTALBILLINGCYCLES' => 1,
				'TRIALAMT' => $price, */
			$response2 = $this->provider->createRecurringPaymentsProfile($data, $token);		
			if($freq == 'Month') {
				$response3 = $this->provider->createMonthlySubscription($token, $price, $profile_desc);
			} else {
				$response3 = $this->provider->createYearlySubscription($token, $price, $profile_desc);
			}					
			$response["customer_id"] = $id;
			$response["customer_level"] = $membership;
			$response["period"] = $period;
			$response["payment_status"] = 'Active';
			$response["date_paid"] = Carbon::now();
			$s = PaymentDetail::create($response);
			return $this->returnView($id, $subscription, $price, $membership, $m, $pid);
		} catch(\Exception $e) {
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
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
			$store = Storage::disk('errors')->put("errors.txt", $e->getMessage());
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function payment_failed(Request $request) {
		return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'))->with('uri', session('serveruri'))->with('rootpath', session('rootpath'));        
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
