<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nolink implements Rule
{    
    public function __construct() {
        
    }
    public function passes($attribute, $value) {
        $regex='|<a\s*href="([^"]+)"[^>]+>([^<]+)</a>|';
		$howmany = preg_match_all($regex,$value,$res,PREG_SET_ORDER);
		$cntr = count($res);
		if($cntr > 0) {
			return false;
		} 
		return true;		
    }
    public function message() {
        return 'The content must not include link tags. You must upgrade your membership.';
    }
}
