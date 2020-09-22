<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $table = 'customer_images';
	public $timestamps = false;
	protected $fillable = [
		'id', 'customer_id', 'title', 'description', 'filename', 'photo_quality', 'thumb_width', 'thumb_height', 'category', 'frontpage',
		'viewed', 'location', 'photo_status', 'photo_frontpage', 'approval_queue', 'selected', 'published',
	];
}
