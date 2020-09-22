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
		$fbuser = User::where('customer_facebook_id', $providerUser->getId())->first();
		if($fbuser) {
			$account2 = SocialFacebookAccount::whereProvider('facebook')->whereProviderUserId($providerUser->getId())->first();
			if(!$account2) {
				$account2 = new SocialFacebookAccount([
					'user_id' => $fbuser->id,
					'provider_user_id' => $providerUser->getId(),
					'provider' => 'facebook',					
					'created_at' => $date_created,
					'updated_at' => $date_created,
				]);
				$account2->user()->associate($fbuser);
				$account2->save();
			} else {
				return $account2->user;
			}		
		}		
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
			$ddate = str_replace_array('-', ['', ''], $now->toDateTimeString());
			$ddate = substr($ddate, 2);
			$ddate = str_replace_array(' ', [''], $ddate);
			$ddate = str_replace_array(':', ['', ''], $ddate);
			$p_id = "4C".$ddate;
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook',
				'user_id' => $p_id,
				'created_at' => $date_created,
				'updated_at' => $date_created,
            ]);
			$user = User::where('customer_email', $providerUser->getEmail())->first();            
            if (!$user) {								
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
                    'customer_email' => $providerUser->getEmail(),
                    'customer_name' => $fname,
					'customer_middlename' => $mname,
					'customer_surname' => $lname,
                    'customer_password' => str_random(10),
					'customer_facebook_id' => $providerUser->getId(),
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
					'customer_homeportal' => session('location'),
                    'customer_currentportal' => session('location'),
                    'customer_homeurl' => session('url'),
                    'customer_currenturl' => session('url'),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
