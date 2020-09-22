<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Armanagement;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;

class ResetPasswordController extends Controller
{
	public function go_reset(Request $request, $email) {
		$viewbg = $request->query('bg');
		$viewbg = Crypt::decryptString($viewbg);
		$loc = $request->query('loc');
		$loc = Crypt::decryptString($loc);
		$email = Crypt::decryptString($email);
		try {
		  $arwebsite = Armanagement::where('location', $loc)->firstOrFail();
		  $url = $arwebsite->domainname;
		} catch (ModelNotFoundException $ex) {
		  $arwebsite = "Not Found";
		  $url = "phillipisland.guide";
		}
		session(['loc' => $loc]);    
		session(['location' => $loc]);    
		session(['url' => $url]); 
		session(['viewbg' => $viewbg]);	
		session(['runningbg' => $viewbg]);
		return view('auth.passwords.reset', ['title' => 'Password Reset Page', 'email' => $email, 'runningbg' => $viewbg]);
	}
	
	public function reset_now(Request $request) {
		$v = $request->validate([
			'password' => 'required|string|confirmed|min:8|max:30|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,30}$/',
			'password_confirmation' => 'required|string|max:30',
		]);
		$password = $request->input('password', '');
		$email = $request->input('email', '');
		$user = User::where('customer_email', $email)->update(['customer_password' => $password]);
		return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'));
	}
	public function go_back() {
		return redirect('login')->with('loc', session('location'))->with('url', session('url'))->with('viewbg', session('runningbg'));
	}
}
