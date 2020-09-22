@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		{!! Form::open(['route' => 'user.create', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}
		    <div class="alert alert-danger" role="alert">
                	<strong>{{ $title }}</strong> You can click <a href="{{ route('password.request') }}">{{ __('here') }}</a> to retrieve your password or you can just continue to fill-up the form below with a different email address.
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
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
