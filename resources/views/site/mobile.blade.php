@extends('layouts.front')
@section('title', 'Mobile Page')
@section('content')
	<div id="mobile-container">
		<p class="text-red text-center">Enter your mobile phone number</p>											
		<a>&nbsp;</a>
		{!! Form::open(['route' => 'mobile.post', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('email', $email) }}
		    <div class="form-group">
		    	<div class="input-group">
			    	<span class="input-group-addon" style="margin: 0; padding: 0; height: 10px; width: 70px;" id="area-code"><select class="form-control">
					  <option value="61">61</option>					    
					</select></span>
					<input id="mobile" type="text" class="form-control" style="width: 157%;" name="mobile" value="{{ old('mobile') }}" maxlength="10" aria-describedby="area-code" required>   
				</div>
		    </div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Send</button>  
		    <a href="{{ route('login.with') }}" class="pull-right"><< Back to login</a>
		{!! Form::close() !!}
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>
