@extends('layouts.admin')
@section('title', 'Advertisements List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h2>Add a Banner</h2></center>    
  </div>
  <div class="panel-body">
    <center>
		<img src="{{ asset('images/BannerType.png') }}" class="img-responsive" border="0" /><br/>		
		<a href="{{ route('banner.selected', ['btype' => 'creator']) }}" class="btn btn-primary btn-app-normal" id="banner-maker"><i class="fa fa-thumbs-o-up"></i> Use the Banner Maker</a>&nbsp;&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('banner.selected', ['btype' => 'uploader']) }}" class="btn btn-primary btn-app-normal" id="banner-uploader"><i class="fa fa-upload"></i> Upload Your Banner</a>
	</center>
  </div> 
</div>
@endsection