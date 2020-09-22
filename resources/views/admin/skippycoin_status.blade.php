@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <center><h3>&nbsp;</h3></center>    
  </div>
  <div class="panel-body">	
	<div class="alert alert-warning" role="alert">  			
		Skippycoin Flag Status: <strong><span class="badge">{{ $status }}</span></strong> 
		<?php
			$rt = route('skippycoin.status.update', ['old' => $status]);
		?>
		@if($status == 'off')
			<a href="{{ $rt }}" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> Turn it on!</a>
		@else
			<a href="{{ $rt }}" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i> Turn it off!</a>
		@endif
	</div>		
  </div> 
</div>
@endsection
