@extends('layouts.front')
@section('title', 'Mobile Page')
@section('content')
	<div id="mobile-container">
		<p class="text-red text-center">Enter your mobile phone number</p>											
		<a>&nbsp;</a>
		<form>
			<div class="form-group">
		        <label for="firstname">{{ __('First Name') }}</label>     
		        <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required>   
		    </div>
		    <div class="form-group">
		        <label for="lastname">{{ __('Last Name') }}</label>     
		        <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required>   
		    </div>
		    <div class="form-group">
		        <label for="email">{{ __('E-Mail Address') }}</label>     
		        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>   
		    </div>
		    <div class="form-group">
		    	<div class="input-group">
			    	<span class="input-group-addon" style="margin: 0; padding: 0; height: 10px; width: 70px;" id="area-code"><select class="form-control">
					  <option value="61">61</option>					    
					</select></span>
					<input id="mobile" type="text" class="form-control" style="width: 157%;" name="mobile" value="{{ old('mobile') }}" aria-describedby="area-code" required>   
				</div>
		    </div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Send</button>  
		    <a href="{{ route('login') }}" class="pull-right"><< Back to login</a>
		</form>
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>