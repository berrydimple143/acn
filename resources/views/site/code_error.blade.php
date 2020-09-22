@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		@if((int)session('pagecounter') <= 4)
		{!! Form::open(['route' => 'mobile.confirmed', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}
			{{ Form::hidden('SMS_key', $SMS_key) }}
		    <div class="alert alert-danger" role="alert">
                	<strong>{{ $title }}</strong> Please try again.
        	    </div>
		    <div class="form-group">
			<label for="code">Enter the code:</label>
		    	<input id="code" type="text" class="form-control" name="code" required>   			
		    </div>
		    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" name="firstname" value="{{ $firstname }}" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" value="{{ $lastname }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" value="{{ $email }}" required>
                    </div>
		    <div class="checkbox">
                        <label>
                                <input class="form-check-input" type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : '' }} required> {{ __('Accept Terms and Conditions') }}
                        </label>
                    </div>
		    <div class="form-group">&nbsp;</div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  		   
		{!! Form::close() !!}
		@else
			<div class="alert alert-danger" role="alert">
                        	<strong>Oops! You have reached up to 3 maximum attempts to put the right code.</strong> Please try again later. Click <a href="{{ route('login') }}">here</a> to go back to the login page. 
                    	</div>
		@endif
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
