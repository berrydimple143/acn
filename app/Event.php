<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'customer_events';
    public $timestamps = false;
    protected $fillable = [
        'event_id', 'event_name', 'event_start', 'event_stop', 'event_url', 'event_banner',
        'event_video', 'event_videoid', 'event_location', 'event_portal', 'customer_id', 'event_phone', 
        'event_mobile', 'event_email', 'event_address_1', 'event_address_2', 'event_city', 'event_state', 
        'event_postcode', 'event_country', 'event_stream', 'event_type', 'event_teaser', 'event_content',     
        'event_latitude', 'event_longitude', 'event_zoom', 'event_status', 'event_locationtype', 'event_map',
		'event_review',
    ];
}
