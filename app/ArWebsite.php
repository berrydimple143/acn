<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the manually populated table in the mysql database. The work is done by a data entry job or something else. */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArWebsite extends Model
{ 
    protected $table = 'ARWebsites';
    public $timestamps = false;    
    protected $fillable = [
        'domain', 'subdomain', 'domainname', 'localname', 'preferred', 'link', 'scope', 'flavor', 'location',
        'aclg', 'lgalink', 'shortstate', 'longstate', 'population', 'uclpopulation', 'suapopulation', 'lgapopulation',
		'country', 'news', 'summary', 'latitude', 'longitude', 'zoom', 'mapset', 'mapsapikey', 'notes', 'wplga',
        'wpregion', 'wptown', 'lgc', 'uclnumbus', 'suanumbus', 'lganumbus', 'busnum', 'field32', 'field33',
    ];
}
