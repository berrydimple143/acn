@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="confirm-container">		
		{!! Form::open(['route' => 'mobile.confirmed', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}
			{{ Form::hidden('SMS_key', $SMS_key) }}
		    <div class="alert alert-success" role="alert">
                	<strong>The code has been sent to your mobile phone.</strong> Please get it and fill up the form below.
        	    </div>
		    <div class="form-group">
			<label for="code">Enter the code:</label>
		    	<input id="code" type="text" class="form-control" name="code" required>   			
		    </div>
		    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" name="firstname" required>
                    </div>
		    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
		    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
		    <div class="checkbox">
        		<label>
          			<input class="form-check-input" type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : '' }} required> {{ __('Accept Terms and Conditions') }}
        		</label>
      		    </div>
		    <div class="form-group">&nbsp;</div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  		   
		{!! Form::close() !!}
	</div>
@endsection
<style>
	#confirm-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
