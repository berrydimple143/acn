@extends('layouts.front')
@section('title', 'Reset Password Page')
@section('content')
<?php
	$msg = "Minimum of 8 characters<br/>";
	$msg .= "Maximum of 30 characters<br/>";
	$msg .= "At least one uppercase letter<br/>";
	$msg .= "At least one lowercase letter<br/>";
	$msg .= "At least one special character<br/>";
?>
<div id="login-container">
    <h3 class="text-red text-center">{{ __('Reset Password') }}</h3>       
    <form method="POST" action="{{ route('reset.now') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">        
        <div class="form-group">
            <label for="password">Password <span id="reset_hint" data-toggle="popover" title="Validation Rules:" data-content="{{ $msg }}"><i class="fa fa-question-circle"></i></span></label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>     
            @if ($errors->has('password'))
                <p>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                </p>
            @endif
        </div>  
        <div class="form-group">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>     
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>             
        </div>   
        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> {{ __('Reset Password') }}</button>    
    </form>
</div> 
@endsection
<style>  
  .text-red { color: #CD0000; }
  #login-container { margin:10px auto; width: 350px; background-color: #fff; border: 1px solid #003399; padding: 15px; } 
</style>