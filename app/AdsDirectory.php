<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the advertisement directory */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsDirectory extends Model
{
    protected $table = 'ad_directories';
    public $timestamps = false;
    protected $fillable = [
        'id', 'directory', 'access_level', 'ad_type',        
    ];
}
