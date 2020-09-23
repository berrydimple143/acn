<?php

/* This is the model for the advertisement in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'ad';
    public $timestamps = false;
    protected $fillable = [
        'ad_id', 'ad_portal', 'ad_businessname', 'customer_id', 'ad_status', 'ad_banner',
        'ad_review', 'ad_location', 'ad_directory', 'ad_category', 'ad_map', 'ad_latitude', 
        'ad_longitude', 'ad_zoom', 'ad_url', 'ad_email', 'ad_type', 'ad_teaser', 
        'ad_phone', 'ad_mobile', 'ad_address_1', 'ad_address_2', 'ad_city', 'ad_state',  
        'ad_postcode', 'ad_country', 'ad_video', 'ad_vurl', 'ad_vembed', 'ad_videoid',
        'ad_ip', 'ad_content', 'ad_stream', 'modified_date', 'ad_example', 'ad_locationtype',		
    ];
}
