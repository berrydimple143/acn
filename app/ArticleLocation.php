<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This model is responsible for fetching article locations from the ARWebsites table in the database */

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
