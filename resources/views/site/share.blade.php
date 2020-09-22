@extends('layouts.front')
@section('title', 'Tell a friend Page')
@section('content')
	<div id="share-container">
		<p class="text-yellow text-center">Tell a friend</p>											
		<a>&nbsp;</a>
		<form method="POST" action="{{ route('post.share') }}">
		@csrf
			<div class="form-group">
		        <label for="name">{{ __('Name') }}</label>     
		        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>   
		    </div>
		    <div class="form-group">
		        <label for="email">{{ __('Your E-Mail Address') }}</label>     
		        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>   
		    </div>
		    <div class="form-group">
		        <label for="friendmail">{{ __("Your Friend's E-Mail Address") }}</label>     
		        <input id="friendmail" type="email" class="form-control{{ $errors->has('friendmail') ? ' is-invalid' : '' }}" name="friendmail" value="{{ old('friendmail') }}" required>   
		    </div>
		    <div class="form-group">
		        <label for="subject">{{ __('Subject') }}</label>     
		        <input id="subject" type="text" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}">   
		    </div>
		    <div class="form-group">
		        <label for="message">{{ __('Message') }}</label>     
		        <textarea id="message" name="message" class="form-control" rows="4"></textarea> 
		    </div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Send</button>  
		    <a href="{{ route('login.with') }}" class="pull-right"><< Back to login</a>
		</form>
	</div>
@endsection
<style>
	#share-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>
