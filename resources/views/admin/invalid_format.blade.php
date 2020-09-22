@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">  
  <div class="panel-body">
	<div class="alert alert-warning" role="alert">			
  		<strong>{{ $title }}!</strong> Click <a href="{{ $route }}">here</a> to go back.
	</div>
  </div> 
</div>
@endsection
