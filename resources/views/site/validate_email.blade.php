@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		{!! Form::open(['route' => 'validate.email', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}		
		    <div class="form-group">
			<label for="code">Enter your email:</label>
		    	<input id="email" type="email" class="form-control" name="email" required>   			
		    </div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  		   
		{!! Form::close() !!}
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>
