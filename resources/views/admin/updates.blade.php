@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">  		
    <h3 class="box-title text-red text-center"><i class="fa fa-certificate"></i> {{ $title }}</h3> 	
  </div>
  <div class="panel-body">
    <div class="row">		
		<div class="col-sm-12">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<ul><li><strong>{{ $status }}</strong></li></ul>
			</div>
		</div>		
	</div>
  </div> 
</div>
@endsection