@extends('layouts.front')
@section('title', 'Login Page')
@section('content')
<div id="login-container">
    <center>
        <h4 class="text-blue">AUSTRALIAN REGIONAL NETWORK</h4>
        <p class="text-red">LOGIN to self publish your Articles, Ads and Events</p>
    </center>
    <center><a href="{{ route('mobile', ['email' => 'none']) }}" class="btn btn-success stretched"><span class="fa fa-phone-square"></span> Create an Account or Login<br>with Mobile<img src="/commonimages/arrows/redsidewinderright.gif"/></a>
    </center><div align="center">or</div>                       
    <center><a href="{{ route('facebook.redirect') }}" class="btn btn-info stretched"><i class="fa fa-facebook"></i> Sign in with Facebook</a></center>         
   </center><div align="center"><hr> Traditional Accounts Login</div>     
    <form method="POST" action="{{ route('login') }}">      
      @csrf
	  <input type="hidden" name="runningbg" id="runningbg" value="{{ $runningbg }}">
	  <input type="hidden" name="newloc" id="newloc" value="{{ $newloc }}">
	  <input type="hidden" name="newurl" id="newurl" value="{{ $newurl }}">
	  <input type="hidden" name="newuri" id="newuri" value="{{ $newuri }}">
	  <input type="hidden" name="newrootpath" id="newrootpath" value="{{ $newrootpath }}">
      <div class="form-group">
        <label for="email">{{ __('E-Mail Address') }}</label>     
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>   
      </div>
      <div class="form-group">
        <label for="password">{{ __('Password') }}</label>     
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>     
      </div>                                                   
      <div class="checkbox">
        <label>
          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
        </label>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Sign In</button>    
      <a class="btn btn-link pull-right" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>       
    </form>     
    <p class="text-green text-center">Your one account connects you to all 1000+ Australian Regional Network websites. Once logged in you can publish content here or into all websites in the country</p>
           
    <p class="text-center text-yellow">Know a friend that would benefit?</p>
    <center><a href="{{ route('share') }}" class="btn btn-info stretched"><span class="fa fa-envelope"></span> Tell a Friend</a></center>
</div>      
@endsection
<style>   
    .text-blue { color: #003399; }
    .text-red { color: #CD0000; }   
    .text-green { color: #009966; }
    .text-yellow { color: #ffd520; }
    .text-center { text-align: center; }
    #login-container { margin: 10px auto; max-width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
    .stretched { width: 100%; }
</style>
