@extends('layouts.front')
@section('title', $title)
@section('content')
	<div id="confirm-container">		
		<a href="#"><img src="{{ $article_image }}" class="img-responsive" alt="{{ $subject }}"></a><br/>
		<h3>{{ $subject }}</h3><br/>
		<p>{!! $body !!}</p>
	</div>
@endsection
<style>
	#confirm-container { width: 100%; background-color: #fff; padding: 10px; border: 1px solid #bcbcbc; } 
</style>
