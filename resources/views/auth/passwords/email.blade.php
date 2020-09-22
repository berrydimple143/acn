@extends('layouts.front')
@section('title', 'Reset Password Page')
@section('content')
<div id="recovery-container">                            
    <h3 class="text-red text-center">Reset Password</h3>                  
    <a>&nbsp;</a>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">     
	  @csrf
      <div class="form-group">     
          <label for="email">E-Mail Address</label>        
          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>                     
          @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif          
      </div>
      <div class="form-group">
	<p><?php echo \Captcha::img(); ?></p>
	<p><input type="text" name="captcha"></p>	
      </div>	  
	  <button type="submit" class="btn btn-primary">Send Password Reset Link</button>                                   
      <a href="{{ route('login.with') }}" class="pull-right"><< Back to login</a>
      <p class="text-center text-red">Type your email to recover your password Then check your email</p>
    </form>
</div>      
@endsection
<style>  
  .text-red { color: #CD0000; }
  #recovery-container { margin:10px auto; width: 350px; background-color: #fff; border: 1px solid #003399; padding: 15px; } 
</style>
