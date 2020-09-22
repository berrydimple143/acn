<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Armanagement;
use App\User;
use Illuminate\Support\Facades\Crypt;

class ResetPasswordController extends Controller
{ 
    use ResetsPasswords;
    protected $redirectTo = '/';
    
    public function __construct()
    {
        $this->middleware('guest');
    }	
	public function reset(Request $request)
    {
		$v = $request->validate([
			'email' => 'required|string|email',
			'captcha' => 'required|captcha',		
		]);
		$loc = session('location');
		$runningbg = session('runningbg');
		$to = $request->input('email', '');
		$from = "admin@australianregionalnetwork.com";
		$headers = "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: $from";
		$subject = "Reset your password from ARN";			
		$subject = "&#9733; " . $subject;	
		$subject = htmlEntityDecode($subject, ENT_COMPAT, 'UTF-8');
		$subject = '=?UTF-8?B?' . base64Encode($subject) . '?=';		
		$rbg = Crypt::encryptString($runningbg);
		$loct = Crypt::encryptString($loc);	
		$eml = Crypt::encryptString($to);
		$rt = route('go.reset', ['email' => $eml]). "?bg=" . $rbg. "&loc=". $loct;
		try {
		  $usr = User::where('customer_email', $to)->firstOrFail();
		  $name = $usr->customer_name;
		} catch (ModelNotFoundException $ex) {	
		  $name = "member";
		}
		$body = "Dear ".$name.",<br/>
				<p>Here is your password reset link:</p>
				<p>
				<a href='".$rt."' target='_blank'>".$rt."</a>
				</p>
				";
		$body = htmlSpecialCharsDecode($body);	
		$ml = @mail($to, $subject, $body, $headers, "-f " . $from);			
		try {
		  $arwebsite = Armanagement::where('location', $loc)->firstOrFail();
		  $url = $arwebsite->domainname;
		} catch (ModelNotFoundException $ex) {
		  $arwebsite = "Not Found";
		  $url = "phillipisland.guide";
		}
		$loginrt = route('home'). "?loc=" . $loc. "&url=". $url;
		if(!$ml) {
			return view('admin.mail_failed', ['title' => 'Password Reset Link Sending Failed', 'runningbg' => $runningbg]);
		} else {
			return view('site.password_reset', ['title' => 'Password Reset Link Sent', 'loginrt' => $loginrt, 'runningbg' => $runningbg]);
		}        
    }	
}
