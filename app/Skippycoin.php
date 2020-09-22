<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skippycoin extends Model
{
    protected $fillable = [
			'status', 'key', 'customer_id',
	];
}
