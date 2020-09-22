<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleLocation extends Model
{
    protected $table = 'ARWebsites';
    public $timestamps = false;
    protected $fillable = [
        'domain', 'subdomain', 'domainname', 'localname', 'preferred', 'link', 'scope', 'flavor', 'location', 'aclg',
		'lgalink', 'shortstate', 'longstate', 'population', 'uclpopulation', 'suapopulation', 'lgapopulation', 'country', 
		'news', 'summary', 'latitude', 'longitude', 'zoom', 'mapset', 'mapsapikey', 'notes', 'wplga', 'wpregion', 'wptown',
		'lgc', 'uclnumbus', 'suanumbus', 'lganumbus', 'busnum', 'field32', 'field33',
    ];
}
