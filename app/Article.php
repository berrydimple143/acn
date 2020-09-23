<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the articles in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'customer_articles';
    public $timestamps = false;
    protected $fillable = [
        'article_id', 'customer_id', 'description', 'username', 'subject', 'body',
        'article_image', 'article_image_thumb', 'article_logo', 'article_logo_thumb', 'creation_date', 'release_date', 
        'modified_date', 'expiry_date', 'category', 'article_location', 'modified_by', 'article_video', 
        'article_videoid', 'article_ltype', 'article_status', 'article_image_2', 'article_image_3', 'article_image_4', 'article_image_5',
		'article_video_2', 'article_video_3', 'article_video_4', 'article_video_5',
		'article_videoid_2', 'article_videoid_3', 'article_videoid_4', 'article_videoid_5',
		'body_2', 'body_3', 'body_4', 'body_5', 'content_count',
    ];
}
