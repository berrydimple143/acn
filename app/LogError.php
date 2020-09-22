<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogError extends Model
{
    protected $fillable = [
        'customer_id', 'error_message', 'missing', 'parameter',
    ];
}
