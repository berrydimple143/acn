@extends('layouts.admin')
@section('title', 'Portrait List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <center><h3>List of Portraits <span class="badge">{{ $numOfPortraits }}</span></h3></center>    
  </div>
  <div class="panel-body">
	@if($numOfPortraits > 0)
	<div class="row">
		{!! Form::open(['route' => 'portrait.search', 'method' => 'POST']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                        <input type="text" name="portrait" id="portrait" class="form-control" placeholder="Search portrait here ...">
                        <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Search</button>
                        </span>
                </div>
            </div>
		{!! Form::close() !!}
            <div class="col-sm-7"><a href="{{ route('portrait.add') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Portrait</a></div>
        </div>
        <div class="row">&nbsp;</div>
	<div class=row>
	@foreach($portraits as $p)        	

	<div class="col-sm-6 col-md-4"> 
			<?php
				$imgsrc = "images/noimage.png";
				$prim = 'no';
				if($p->filename != "") {
					$imgsrc = "publicimages/portraits/" . $p->filename;
				}
			?>
		<div class="thumbnail"><img alt="Sample Logo" src="{{ asset($imgsrc) }}"> 
			<div class="caption">
				<h3 class="text-center">{{ $p->caption }}</h3> <br/>				
				@if($p->primary_portrait == 'Yes')
					<?php $prim = 'yes'; ?>
					<p class="text-center"><span class="label label-success">Primary</span></p>
				@else
					<p class="text-center"><span class="label label-danger">Not Primary</span></p>
				@endif
				<br/>
				<p>		
					@if($prim == 'no')
						<a href="{{ route('portrait.set.primary', ['id' => $p->id]) }}" class="btn btn-primary" role='button'>Set as Primary</a> 
					@endif				
					<a href="{{ route('delete.portrait', ['id' => $p->id]) }}" class="btn btn-danger" role='button'>Delete</a>
				</p> 
			</div> 
		</div> 
	</div>


    	@endforeach			
	</div>
	<div class=row>
                <center>{{ $portraits->links() }}</center>
        </div>    
	@else
		<div class="alert alert-warning" role="alert">  			
  			<strong>No portraits yet!</strong> Please add one. <a href="{{ route('portrait.add') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Portrait</a>
		</div>	
	@endif
  </div> 
</div>
@endsection
