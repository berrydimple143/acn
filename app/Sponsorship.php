<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $table = 'sponsorship';
    public $timestamps = false;
    protected $fillable = [
        'agreement', 'sponsor', 'sponsoree', 'key', 'status', 
    ];
} 
