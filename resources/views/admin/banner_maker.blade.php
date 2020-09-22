@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-flag"></i> Choose your type of background</h3>   
  </div>
  <div class="panel-body">		
	<div class="row" id="banner-form">		
		<div class="col-sm-2">
			<a class="btn btn-primary btn-app-banner btn-app-popup" id="bimgupload" data-toggle="popover" title="Tip" data-content="Image Background"><i class="fa fa-image"></i></a>			
			<a class="btn btn-primary btn-app-banner btn-app-popup" id="bsquare" data-toggle="popover" title="Tip" data-content="Normal Background"><i class="fa fa-square"></i></a>
		</div>
		<div class="col-sm-10">
			<img src="{{ asset('images/placeholder-image.png') }}" alt="Image Placeholder" class="img-thumbnail img-responsive center-block">							
		</div>		
	</div>
  </div> 
</div>
@endsection