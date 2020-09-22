<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'customer';
    public $timestamps = false;
    
    protected $fillable = [
        'customer_id', 'customer_name', 'customer_surname', 'customer_middlename', 'customer_facebook_id', 'customer_tax_id',
        'customer_owneraffiliate', 'customer_title', 'customer_businessname', 'customer_position', 'customer_status', 'customer_email', 
        'customer_distribution', 'customer_phone', 'customer_mobile', 'customer_address_1', 'customer_address_2', 'customer_city', 
        'customer_state', 'customer_postcode', 'customer_country', 'customer_password', 'customer_requestpassword', 'customer_rating',  
        'customer_notes', 'customer_ip', 'customer_nickname', 'customer_displaynickname', 'customer_emailvalidated', 'customer_displayname',
        'customer_level', 'customer_homeportal', 'customer_currentportal', 'customer_homeurl', 'customer_currenturl', 'customer_portalindicator',
        'customer_currentlatitude', 'customer_currentlongitude', 'customer_currentzoom', 'customer_homelatitude', 'customer_homelongitude', 'customer_homezoom',
        'customer_facebook', 'customer_linkedin', 'customer_twitter', 'customer_pwebsite', 'customer_cwebsite', 'customer_description',
        'customer_bdescription', 'customer_bwebsite', 'customer_skcwallet', 'article_limit', 'ad_limit', 'photo_limit',
        'date_created', 'date_deleted', 'membership_key', 'trust_level', 'event_limit', 'customer_mobilevalidated',
    ];

    protected $hidden = [
        'customer_password', 'remember_token',
    ];    
}
