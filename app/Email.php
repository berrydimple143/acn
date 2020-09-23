<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the emails in the database used for marketing purposes */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'email', 'firstname', 'lastname', 'email_list_id', 'customer_id', 'verified',
    ];
}
