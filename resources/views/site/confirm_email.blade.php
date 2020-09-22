@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="failed-container">
		<div class="alert alert-warning" role="alert">  		
			<strong>Hmmmm...</strong> We think you may already have an account.				
			<p>We've found your email '{{ $user->customer_email }}' in our database.</p>
			<p>Please login with your mobile by clicking the button below and validate your email.</p>
		</div>
		<br/><br/>
		<center><a href="{{ route('mobile', ['email' => $user->customer_email]) }}"><button type="button" class="btn btn-success">Login With Mobile</button></a></center>
	</div>
@endsection
<style>
        #failed-container { margin: 10px auto; width: 500px; background-color: #fff; padding: 20px; border: 1px solid #003399; }
</style>