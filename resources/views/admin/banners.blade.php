@extends('layouts.admin')
@section('title', 'Banners List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <center><h3>List of Banners <span class="badge">{{ $numOfBanners }}</span></h3></center>    
  </div>
  <div class="panel-body">
	@if($numOfBanners > 0)
	<div class="row">
		{!! Form::open(['route' => 'banner.search', 'method' => 'POST']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                        <input type="text" name="banner" id="banner" class="form-control" placeholder="Search banner here ...">
                        <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Search</button>
                        </span>
                </div>
            </div>
		{!! Form::close() !!}
            <div class="col-sm-7"><a href="{{ route('banner.selection') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add Banner</a></div>
        </div>
        <div class="row">&nbsp;</div>
	<div class="row">
	@foreach($banners as $b)
        <div class="col-sm-6 col-md-4">
			<?php
				$imgsrc = "/images/noimage.png";
				if($b->filename != "") {
					$imgsrc = "/publicimages/banners/" . $b->filename;
				}
			?> 
			<div class="thumbnail"><img alt="{{ $b->filename }}" id="banner-display" data-toggle="popover" title="Banner Information:" data-content="{{ $b->filename }}" src="{{ $imgsrc }}"> 
				<div class="caption">					
					<p>Description: {{ $b->description }}</p> <br/>					
					<p>
						<a href="{{ route('banner.delete', ['id' => $b->id]) }}" class="btn btn-danger btn-flat btn-sm deleteBanner" role="button">Delete this banner</a> 						
					</p> 
				</div> 
			</div> 
		</div>
    @endforeach			
	</div>
	<div class=row>
                <center>{{ $banners->links() }}</center>
        </div>    
	@else
		<div class="alert alert-warning" role="alert">  			
  			<strong>No banners yet!</strong> Please add one. <a href="{{ route('banner.selection') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Banner</a>
		</div>	
	@endif
  </div> 
</div>
@endsection
