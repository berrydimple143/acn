<?php

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
