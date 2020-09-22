@extends('layouts.admin')
@section('title', 'Images List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h3>List of Images <span class="badge">{{ session('numOfImages') }}</span></h3></center>    
  </div>
  <div class="panel-body">
	@if(session('numOfImages') > 0)
	<div class="row">
		{!! Form::open(['route' => 'photo.search', 'method' => 'POST']) !!}
            <div class="col-sm-5">
    		<div class="input-group">
      			<input type="text" name="image" id="image" class="form-control" placeholder="Search image here ...">
      			<span class="input-group-btn">
        			<button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Search</button>
      			</span>
    		</div>
	    </div>
		{!! Form::close() !!}
	    <div class="col-sm-7"><a href="{{ route('photo.add') }}" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Add Image</a></div>
  	</div>
   	<div class="row">&nbsp;</div>     
	<div class="row">
	@foreach($photos as $p)		
		<div class="col-sm-6 col-md-4"> 
			<?php
				$imgsrc = "images/noimage.png";				
				if($p->filename != "") {
					$imgsrc = "publicimages/thumbs/" . $p->filename;
				}
			?>
			<div class="thumbnail"><img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
				<div class="caption">
					<h3 class="text-center">{{ $p->title }}</h3>
					<p class="text-center">{{ $p->description }}</p>
					<p class="text-center">{{ $p->category }}</p>
					@if($p->selected == 'Yes')
						<p class="text-center"><span class="label label-success">Used</span></p>
					@else
						<p class="text-center"><span class="label label-danger">Not Used</span></p>
					@endif				
					<br/>
					<p class="text-center">		
						<a href="{{ route('delete.image', ['id' => $p->id]) }}" class="btn btn-danger btn-sm btn-flat" role='button'>Delete</a>
						@if($p->photo_quality == 'GALLERY')
							@if($p->published == 'yes')
								<span class="label label-success">Published</span>
							@else
								<a href="{{ route('publish.gallery', ['id' => $p->id]) }}" class="btn btn-warning btn-sm btn-flat" role='button'>Publish to gallery</a> 
							@endif
						@endif									
					</p> 
				</div> 
			</div> 
		</div>
    @endforeach			
	</div>
	<div class="row">
		<center>{{ $photos->links() }}</center>
	</div>	
	@else
		<div class="alert alert-warning" role="alert">  			
  			<strong>No images yet!</strong> Please add one. <a href="{{ route('photo.add') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Image</a>
		</div>	
	@endif
  </div> 
</div>
@endsection
