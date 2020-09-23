<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the contacts in the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'email', 'subject', 'message',
    ];
}
