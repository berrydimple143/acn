<?php

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
