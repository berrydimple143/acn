@extends('layouts.front')
@section('title', $title)
@section('content')
<div class="panel panel-default">  
  <div class="panel-body">
	<div class="alert alert-danger" role="alert">			
  		<strong>You still cannot login with mobile!</strong> Please try again later after a minute. Go <a href="{{ route('login') }}">back</a> to the login page.
	</div>
  </div> 
</div>
@endsection
