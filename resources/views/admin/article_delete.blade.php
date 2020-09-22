@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h3>Article Delete Confirmation</h3></center>    
  </div>
  <div class="panel-body">
    <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden=true>&times;</span></button> 
		<h4>Warning! This article will be deleted permanently.</h4> 
		<p>Are you sure you want to delete this article with ID No. '{{ $article->article_id }}'?</p> 
		<p>
			{!! Form::open(['route' => ['article.destroy', $article->article_id], 'method' => 'post']) !!}
				{{ method_field('DELETE') }}
				<button type="submit" class="btn btn-warning">Delete</button> 
			{!! Form::close() !!}			 
		</p> 
	</div> 
  </div> 
</div>
@endsection