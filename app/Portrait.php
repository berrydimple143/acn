<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portrait extends Model
{
	protected $table = 'customer_portrait';
	public $timestamps = false;
	protected $fillable = [
		'id', 'customer_id', 'caption', 'width', 'height', 'status', 'primary_portrait', 'filename', 'location',
	];	
}
