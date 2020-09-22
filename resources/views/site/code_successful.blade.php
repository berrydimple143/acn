@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="mobile-container">		
		<div class="alert alert-success" role="alert">
				<strong>Congratulations!</strong> You have signed up successfully. Please click <a href="{{ $loginrt }}" class="btn btn-primary">here</a> to continue to your account. 
		</div>
	</div>
@endsection
<style>
	#mobile-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 20px; border: 1px solid #003399; } 
</style>
