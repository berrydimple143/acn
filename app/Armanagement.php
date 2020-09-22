<?php

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
