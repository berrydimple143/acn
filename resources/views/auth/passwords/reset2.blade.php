@extends('layouts.front')
@section('title', 'Reset Password Page')
@section('content')
<div id="login-container">
    <h3 class="text-red text-center">{{ __('Reset Password') }}</h3>       
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">{{ __('E-Mail Address') }}</label>     
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>   
            @if ($errors->has('email'))
                <p>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                </p>
            @endif
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>     
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
