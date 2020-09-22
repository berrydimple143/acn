@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-laptop"></i> {{ $title }}</h3>   
  </div>
  <div class="panel-body">	
	@if($restricted == "yes")
		<div class="row">
			<div class="col-sm-12">
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Please Validate your {{ $restrict_text }} first before you can add an advertisement. <a href="{{ $restricted_route }}">Click here</a></h3></center>
			</div>
		</div>
	@else
		{!! Form::open(['route' => 'ads.post', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal row-fluid', 'id' => 'ads-form']) !!}          
			<div class="row">
			  <div class="col-sm-12">
				@include('partials.admin.errors')
			  </div>
			</div>  
			@include('partials.admin.ads_form')
		{!! Form::close() !!}
	@endif
  </div> 
</div>
@endsection