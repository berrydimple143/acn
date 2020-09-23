<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the advertisement category */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsCategory extends Model
{
    protected $table = 'ad_categories';
    public $timestamps = false;
    protected $fillable = [
        'id', 'category', 'access_level', 'dir',        
    ];
}
