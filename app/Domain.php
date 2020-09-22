<?php

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
