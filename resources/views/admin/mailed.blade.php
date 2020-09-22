@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="success-container">
		<div class="alert alert-success" role="alert">
			A validation link was sent to your email. Please open your email and click or visit the link in order to validate your email. Thankyou.
		</div>
		<br/><br/>
		<center><a href="{{ route('home') }}"><button type="button" class="btn btn-success"><< Go back to homepage</button></a></center>
	</div>
@endsection
<style>
        #success-container { margin: 10px auto; width: 500px; background-color: #fff; padding: 20px; border: 1px solid #003399; }
</style>
