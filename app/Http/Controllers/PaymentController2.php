<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypalpayment;
use Redirect;
use Carbon\Carbon;
use App\Privilege;
use App\User;
use Illuminate\Support\Str;
use App\Exceptions\GeneralException;

class PaymentController extends Controller
{    
	public function processPayment(Request $request) {
		try {
			$cmd = $request->input('cmd', '');
			$business = $request->input('business', '');
			$item_name = $request->input('item_name', '');
			$membership = $request->input('membership', '');		
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
			$payment_type = $request->input('payment_type', '');		
			if($payment_type == "paypal") {
				return $this->payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price);
			} else {
				$cardno = $request->input('cardno', '');
				$xmonth = $request->input('xmonth', '');
				$xyear = $request->input('xyear', '');
				$cvv = $request->input('cvv', '');
				return $this->paywithCreditCard($cardno, $xmonth, $xyear, $cvv, $cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price);
			}
		} catch(\Exception $e) {
			throw new GeneralException("Oops! There was an error somewhere in the process.");
		}
	}
	public function selectPayment(Request $request) {
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
		$dt = Carbon::now();
		$yearnow = $dt->year;
		$yearfrom = $yearnow - 10;
		$yearto = $yearnow + 10;
		return view('admin.payment_method', [
			'title' => 'Payment Method Selection Page', 
			'runningbg' => session('runningbg'),
			'yearfrom' => $yearfrom,
			'yearto' => $yearto,
			'cmd' => $cmd,
			'business' => $business,
			'item_name' => $item_name,
			'membership' => $membership,
			'on0' => $on0,
			'os0' => $os0,
			'image_url' => $image_url,
			'currency_code' => $currency_code,
			'a3' => $a3,
			'p3' => $p3,
			't3' => $t3,
			'return' => $return,
			'cancel_return' => $cancel_return,
			'src' => $src,
			'sra' => $sra,
			'receiver_email' => $receiver_email,
			'no_shipping' => $no_shipping,
			'no_note' => $no_note,
			'on1' => $on1,
			'mrb' => $mrb,
			'pal' => $pal,
			'subscription' => $subscription,
			'price' => $price			
		]);
	}
	public function payWithPaypal($cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price) {
        $oldlevel = session('user')->customer_level;
		$newlevel = Str::replaceFirst('-', ' ', $membership);
		if($oldlevel == $newlevel) {
			return redirect()->route('membership');
		} else {
			$id = session('user')->customer_id;          		
			$payer = Paypalpayment::payer();
			$payer->setPaymentMethod("paypal");        
			$desc = ucfirst($subscription) . " ARN Subscription";
			$price = (float)($price);
			$desc2 = "ARN payment for " . $subscription . " subscription";
			$item1 = Paypalpayment::item();		
			$item1->setName($desc2)->setDescription($desc)->setCurrency($currency_code)->setQuantity(1)->setPrice($price);
			$itemList = Paypalpayment::itemList();
			$itemList->setItems([$item1]);
			$amount = Paypalpayment::amount();
			$amount->setCurrency($currency_code)->setTotal($price);
			$transaction = Paypalpayment::transaction();
			$transaction->setAmount($amount)->setItemList($itemList)->setDescription("ARN Subscription Payment")->setInvoiceNumber(uniqid());
			$redirectUrls = Paypalpayment::redirectUrls();
			$myurl = "/payments/success/". $id . "/" . $subscription . "/" . $price . "/" . $membership;
			$furl = "/payments/fails/" . $id; 		
			$redirectUrls->setReturnUrl(url($myurl))->setCancelUrl(url($furl));
			$payment = Paypalpayment::payment();
			$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);
			try {
				$payment->create(Paypalpayment::apiContext());
			} catch (\PPConnectionException $ex) {
				return response()->json(["error" => $ex->getMessage()], 400);
			}
			$redirect_url = $payment->getApprovalLink();
			$pid = $payment->getId();
			if(isset($redirect_url)) {
				return redirect()->away($redirect_url)->with('payment_id', $pid)->with('runningbg', session('runningbg'))->with('location', session('location'))->with('url', session('url'));            
			}
			return Redirect::route('payment.failed', ['id' => $id]);
		}
    }
	public function paywithCreditCard($cardno, $xmonth, $xyear, $cvv, $cmd, $business, $item_name, $membership, $on0, $os0, $image_url, $currency_code, $a3, $p3, $t3, $return, $cancel_return, $src, $sra, $receiver_email, $no_shipping, $no_note, $on1, $mrb, $pal, $subscription, $price) {
        $oldlevel = session('user')->customer_level;
		$newlevel = Str::replaceFirst('-', ' ', $membership);
		if($oldlevel == $newlevel) {
			return redirect()->route('membership');
		} else {
			$id = session('user')->customer_id;	
			$firstname = session('user')->customer_name;
			$lastname = session('user')->customer_surname;
			$cardno = Str::replaceArray('-', ['','',''], $cardno);
			$card = Paypalpayment::creditCard();
			$card->setType('visa')->setNumber($cardno)->setExpireMonth($xmonth)->setExpireYear($xyear)->setCvv2($cvv)->setFirstName($firstname)->setLastName($lastname);
			$fi = Paypalpayment::fundingInstrument();
			$fi->setCreditCard($card);
			$payer = Paypalpayment::payer();
			$payer->setPaymentMethod("credit_card")->setFundingInstruments([$fi]);        
			$desc = "Subscription for " . $subscription;        
			$item1 = Paypalpayment::item();
			$item1->setName('Payment for subscription')->setDescription($desc)->setCurrency($currency_code)->setQuantity(1)->setPrice($price);
			$itemList = Paypalpayment::itemList();
			$itemList->setItems([$item1]);
			$amount = Paypalpayment::amount();
			$amount->setCurrency($currency_code)->setTotal($price);
			$transaction = Paypalpayment::transaction();
			$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Subscription Payment")->setInvoiceNumber(uniqid());
			$payment = Paypalpayment::payment();
			$payment->setIntent("sale")->setPayer($payer)->setTransactions([$transaction]);
			try {
				$payment->create(Paypalpayment::apiContext());
			} catch (\PPConnectionException $ex) {
				return response()->json(["error" => $ex->getMessage()], 400);
			}
			if($payment->state == "approved") {				
				return $this->returnView($id, $subscription, $price, $membership, $oldlevel, '');
			}
			return Redirect::route('payment.failed', ['id' => $id]);
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
	public function payment_successful($id, $subscription, $price, $membership) {
		$pid = session('payment_id');
		session(['runningbg' => session('runningbg')]);
		session(['unsafe_loc' => session('location')]);
		session(['unsafe_url' => session('url')]);
		session(['location' => session('location')]);
		session(['url' => session('url')]);
		$m = session('user')->customer_level;
		return $this->returnView($id, $subscription, $price, $membership, $m, $pid);
    }
	public function updateUserData($id, $membership) {
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
	}
	public function payment_failed($id) {				
        //return 'payment failed.';
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
