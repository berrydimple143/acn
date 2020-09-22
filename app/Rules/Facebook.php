<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Facebook implements Rule
{
    public function __construct() {
        
    }
    public function passes($attribute, $value) {
        return Str::startsWith($value, "https://www.facebook.com/");
    }
    public function message() {
        return 'Invalid facebook url.';
    }
}
