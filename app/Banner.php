<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	protected $table = 'customer_banners';
	public $timestamps = false;
	protected $fillable = [
		'id', 'customer_id', 'title', 'description', 'filename', 'photo_quality',
		'thumb_width', 'thumb_height',  	
	];
}
