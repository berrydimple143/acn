@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="confirm-container">		
		{!! Form::open(['route' => 'admin.mobile.confirmed', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}
			{{ Form::hidden('SMS_key', $SMS_key) }}
			@if($title != "Wrong code.")
				<div class="alert alert-success" role="alert">
					<strong>The code has been sent to your mobile phone.</strong> Please get it and enter the code below to continue.
				</div>
			@else
				<div class="alert alert-danger" role="alert">
                	<strong>{{ $title }}</strong> Please try again.
        	    </div>
			@endif
		    <div class="form-group">
				<label for="code">Enter the Code:</label>
		    	<input id="code" type="text" class="form-control" name="code" required>   			
		    </div>
		    <div class="form-group">&nbsp;</div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  	
			<a href="{{ route('home') }}" class="pull-right"><< Go back to homepage</a>
		{!! Form::close() !!}
	</div>
@endsection
<style>
	#confirm-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
