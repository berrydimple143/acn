<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the banners in the database */

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
