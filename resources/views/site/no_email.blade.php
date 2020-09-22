@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="failed-container">
		<div class="alert alert-warning" role="alert">  		
			<strong>Hmmmm...</strong> You don't have any email setup from your facebook account.			
			<p>You may login with your mobile by clicking the button below.</p>
		</div>
		<br/><br/>
		<center><a href="{{ route('mobile', ['email' => 'none']) }}"><button type="button" class="btn btn-success">Login With Mobile</button></a></center>
	</div>
@endsection
<style>
        #failed-container { margin: 10px auto; width: 500px; background-color: #fff; padding: 20px; border: 1px solid #003399; }
</style>