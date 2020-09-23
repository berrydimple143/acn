<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the article category in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'article_categories';
    public $timestamps = false;
    protected $fillable = [
        'id', 'category', 'status', 'LR', 'CL', 'LB', 'NB', 'LG', 'SG', 'FG', 'ES', 'AD',    
    ];
}
