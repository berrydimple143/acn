@extends('layouts.admin')
@section('title', 'Images List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h3>List of Images <span class="badge">{{ $numOfImages }}</span></h3></center>    
  </div>
  <div class="panel-body">
	@if($numOfImages > 0)
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
				$cls2 = "btn-danger";				
				$rt2 = 'href="'.route('delete.image', ['id' => $p->id]).'"';
				$usage = "NOT USED";								
				$lbl = "label-danger";
				$cntr = \App\Article::where('article_image', $p->filename)->count();
				if($cntr > 0) {
					$num = (string)$cntr;
					if($cntr == 1) {
						$usage = "Used in ".$num." article";
					} else {
						$usage = "Used in ".$num." articles";
					}
					$lbl = "label-primary";
					$cls2 = "btn-default disabled-btn";
					$rt2 = "";
				}
				//if($p->selected == 'Yes') { $lbl = "label-primary"; }	
				$fp = '';
				$res = '<p class="text-center">Low Resolution Image</p><p class="text-center">Article Use Only</p>';				
				$cls = "btn-default disabled-btn";
				$rt = "";				
				if($p->photo_quality == 'GALLERY') {
					$cls = "btn-primary";					
					$rt = 'href="'.route('photo.move', ['id' => $p->id]).'"';				
				}
				if($p->frontpage == 'Yes') {
					$im = '<i class="fa fa-star text-yellow"></i>';
					$fp = '<p class="text-center">'.$im.' FRONT PAGE AWARD '.$im.'</p>';
				}				
				if($p->category != 'NOGALLERY') {
					$res = '<p class="text-center">Published into ' .$p->category. '</p>';					
				}
			?>
			<div class="modal fade" id="photosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Choose an action</h4>
				  </div>
				  <div class="modal-body">
					<center>
						<a class="btn btn-flat btn-success proceedMove" role='button'>Continue moving</a>						
						@if($p->category != 'NOGALLERY')
							&nbsp;&nbsp;	
							<a class="btn btn-flat btn-danger removeGallery" role='button'>Remove from gallery</a>
						@endif
					</center>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
				  </div>
				</div>
			  </div>
			</div>
			<input type="hidden" id="dummyid" value="">
			<div class="thumbnail"><img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
				<div class="caption">
					<h3 class="text-center">{{ $p->title }}</h3>
					<p class="text-center">{{ $p->description }}</p>
					{!! $fp !!}
					{!! $res !!}
					<p class="text-center"><span class="label <?php echo $lbl; ?>"><?php echo $usage; ?></span></p>									
					<br/>
					<p class="text-center">											
						@if($rt != "")
							<a id="{{ $p->id }}" class="showPhotosModal btn btn-sm btn-flat <?php echo $cls; ?>" role='button'>Move</a>
						@else
							<a <?php echo $rt; ?> class="btn btn-sm btn-flat <?php echo $cls; ?>" role='button'>Move</a>
						@endif
						<a <?php echo $rt2; ?> class="btn btn-sm btn-flat <?php echo $cls2; ?>" role='button'>Delete</a>															
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
