<?php
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