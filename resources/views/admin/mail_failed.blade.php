@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="failed-container">
		<div class="alert alert-danger" role="alert">  		
			<strong>Message sending failed.</strong> There was a problem with the mail server.
		</div>
		<br/><br/>
		<center><a href="{{ route('home') }}"><button type="button" class="btn btn-success"><< Go back to homepage</button></a></center>
	</div>
@endsection
<style>
        #failed-container { margin: 10px auto; width: 500px; background-color: #fff; padding: 20px; border: 1px solid #003399; }
</style>
