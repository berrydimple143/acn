<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'emailtemplates';
    public $timestamps = false;
    protected $fillable = [
        'id', 'emailvalidation_subject', 'emailvalidation_content', 'customewelcome_subject', 'customerwelcome_content',     
		'facebook_welcome_subject', 'facebook_welcome_content', 'passwordreset_subject', 'passwordreset_content', 
	];
}
