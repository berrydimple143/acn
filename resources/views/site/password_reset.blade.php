@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		<div class="alert alert-success" role="alert">
			An email has been sent to you containing the "Password Reset Link". Please visit your Email and OPEN the Link.
		</div>
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>
