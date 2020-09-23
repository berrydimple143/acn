<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the domains in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'Domains';
    public $timestamps = false;
    protected $fillable = [
        'dsn', 'flag', 'domain', 'expires', 'registrar', 'domaintype', 'tld', 'expirynote', 'googlemeta',
        'bingmeta', 'pingstamp', 
    ];
}
