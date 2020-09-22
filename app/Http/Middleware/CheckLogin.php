<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckLogin
{
    public function handle($request, Closure $next)
    {           
        if(session('loggedin') == 'yes') {
        	try {
	          $user = User::where('customer_email', $request->email)
	                        ->where('customer_password', $request->password)
	                        ->where('customer_emailvalidated', 1)->firstOrFail();          
	        } catch (ModelNotFoundException $ex) {
	          $user = 'Not Found';          
	        }       
	        if($user != "Not Found") {
            	return redirect('/'); 
            }        
            return $next($request);          
        } else {
        	return redirect()->route('login');
        }        
    }
}
