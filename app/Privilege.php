<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    	protected $table = 'customer_privileges';
        public $timestamps = false;
        protected $fillable = [
                'id', 'level', 'photo_limit', 'article_limit', 'ad_limit', 'event_limit',               
        ];
}
