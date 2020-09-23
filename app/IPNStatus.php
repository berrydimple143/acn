<?php

/* Note: Some of the models refers to different databases in mysql because this project uses multiple mysql database */
/* This model is responsible for storing data from Instant Paypal Notification into the database */

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPNStatus extends Model {
    protected $table = 'ipn_status';
	public $timestamps = false;
    protected $fillable = [
        'payload',
        'status',
    ];
}
