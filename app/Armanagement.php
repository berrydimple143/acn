<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the manually populated table in the mysql database. The work is done by a data entry job or something else. */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Armanagement extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'ARWebsites';
    public $timestamps = false;    
    protected $fillable = [
        'subdomain', 'domainname', 'localname', 'preferred', 'location', 'scope', 'flavor', 'shortstate', 'longstate',
        'country', 'news', 'summary', 'latitude', 'longitude', 'zoom', 'mapsapikey', 'wplga', 'aclg', 'lgalink',
        'wpregion', 'wptown', 'lgc', 'population', 'uclpopulation', 'suapopulation', 'lgapopulation', 'uclnumbus',
        'suanumbus', 'lganumbus', 'busnum',
    ];
}
