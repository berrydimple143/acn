<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
	protected $table = 'customer_logo';
	public $timestamps = false;
	protected $fillable = [
		'id', 'customer_id', 'filename', 'caption', 'width', 'height', 'status', 'selected', 'primary_logo', 'location',  
	];
}
