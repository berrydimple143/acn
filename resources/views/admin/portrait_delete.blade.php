@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h3>Portrait Delete Confirmation</h3></center>    
  </div>
  <div class="panel-body">
    <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden=true>&times;</span></button> 
		<h4>Warning! This portrait will be deleted permanently.</h4> 
		<p>Are you sure you want to delete this portrait with a filename '{{ $portrait->filename }}'?</p> 
		<p>
			{!! Form::open(['route' => ['portrait.destroy', $portrait->id], 'method' => 'post']) !!}
				{{ method_field('DELETE') }}
				<button type="submit" class="btn btn-warning">Yes</button> 
			{!! Form::close() !!}			 
		</p> 
	</div> 
  </div> 
</div>
@endsection