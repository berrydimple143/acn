<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the countries in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;
    protected $fillable = [
        'id', 'country',  
    ];
}
