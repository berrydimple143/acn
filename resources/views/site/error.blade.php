@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		{!! Form::open(['route' => 'mobile.confirmed', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}
			{{ Form::hidden('email', $email) }}
			{{ Form::hidden('SMS_key', $SMS_key) }}
		    <div class="alert alert-danger" role="alert">
                	<strong>{{ $title }}</strong> Please try again.
        	    </div>
		    <div class="form-group">
			<label for="code">Enter the code:</label>
		    	<input id="code" type="text" class="form-control" name="code" required>   			
		    </div>		    
		    <div class="form-group">&nbsp;</div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  		   
		{!! Form::close() !!}		
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
