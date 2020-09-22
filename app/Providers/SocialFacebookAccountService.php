<?php

namespace App\Providers;

use App\SocialFacebookAccount;
use App\User;
use App\Privilege;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Carbon\Carbon;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
		$now = Carbon::now();				
		$date_created = $now->toDateTimeString();		
		$fb_email = $providerUser->getEmail();
		$fb_id = $providerUser->getId();		
		if($fb_email == '' || $fb_email == null || empty($fb_email)) {
			return ['user' => null, 'status' => 'no email', 'fb_id' => $fb_id];
		} else {
			$fbuser = User::where('customer_facebook_id', $fb_id)->orWhere('customer_email', $fb_email)->first();
			if($fbuser) {
				$usr = User::where('customer_facebook_id', $fb_id)->where('customer_email', $fb_email)->first();
				if($usr) {
					return ['user' => $usr, 'status' => 'go', 'fb_id' => $fb_id];
				} else {
					$usr2 = User::where('customer_email', $fb_email)->first();				
					if($usr2) {	
						$info = ['user' => $usr2, 'status' => 'email found', 'fb_id' => $fb_id];
					} else {
						$usr2 = User::where('customer_facebook_id', $fb_id)->first();
						$info = ['user' => $usr2, 'status' => 'fbid found', 'fb_id' => $fb_id];
					}
					$data = [
						'customer_email' => $fb_email,
						'customer_facebook_id' => $fb_id,
					];
					$c = User::where('customer_id', $usr2->customer_id)->update($data);
					return $info;
				}	
			} else {
				$ddate = str_replace_array('-', ['', ''], $now->toDateTimeString());
				$ddate = substr($ddate, 2);
				$ddate = str_replace_array(' ', [''], $ddate);
				$ddate = str_replace_array(':', ['', ''], $ddate);
				$p_id = "4C".$ddate;
				$privilege = Privilege::where('level', 'Local Resident')->first();
				$flname = (string)$providerUser->getName();
				$fullname = explode(' ', $flname);
				$cntr = count($fullname);
				$fname = $fullname[0];
				$mname = '';
				$lname = $fullname[1];
				if($cntr >= 3) {
					$mname = $fullname[1]; 
					$lname = $fullname[2];
				}				 				
				$user = User::create([
					'customer_id' => $p_id,
					'date_created' => $date_created,
					'customer_email' => $fb_email,
					'customer_name' => $fname,
					'customer_middlename' => $mname,
					'customer_surname' => $lname,
					'customer_password' => str_random(10),
					'customer_facebook_id' => $fb_id,
					'customer_ip' => \Request::ip(),
					'customer_nickname' => $providerUser->getNickname(),
					'customer_status' => 'NEW',
					'customer_emailvalidated' => 1,
					'customer_mobilevalidated' => 0,
					'customer_level' => 'Local Resident',
					'customer_distribution' => 'YES',
					'ad_limit' => $privilege->ad_limit,
					'article_limit' => $privilege->article_limit,
					'photo_limit' => $privilege->photo_limit,
					'event_limit' => $privilege->event_limit,
					'customer_homeportal' => session('location'),
					'customer_currentportal' => session('location'),
					'customer_homeurl' => session('url'),
					'customer_currenturl' => session('url'),
				]);
				return ['user' => $user, 'status' => 'new account', 'fb_id' => $fb_id];
			}
		}		
    }
}
