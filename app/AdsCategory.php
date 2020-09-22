<?php

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