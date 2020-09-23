<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This is the model for the email list in the database used for marketing purposes like mailchimp */

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $fillable = [
        'name', 'customer_id',
    ];
}
