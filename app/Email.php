<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'email', 'firstname', 'lastname', 'email_list_id', 'customer_id', 'verified',
    ];
}
