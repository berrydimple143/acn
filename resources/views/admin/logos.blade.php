@extends('layouts.admin')
@section('title', 'Images List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <center><h3>List of Logos <span class="badge">{{ $numOfLogos }}</span></h3></center>    
  </div>
  <div class="panel-body">
	@if($numOfLogos > 0)
	<div class="row">
		{!! Form::open(['route' => 'logo.search', 'method' => 'POST']) !!}
            <div class="col-sm-5">
                <div class="input-group">
                        <input type="text" name="logo" id="logo" class="form-control" placeholder="Search logo here ...">
                        <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Search</button>
                        </span>
                </div>
            </div>
		{!! Form::close() !!}
            <div class="col-sm-7"><a href="{{ route('logo.add') }}" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Logo</a></div>
        </div>
        <div class="row">&nbsp;</div>
	<div class="row">
	@foreach($logos as $l)
        	<div class="col-sm-6 col-md-4"> 
		<?php
			$imgsrc = "images/noimage.png";
			$prim = 'no';
			if($l->filename != "") {
				$imgsrc = "publicimages/logos/" . $l->filename;
			}
		?>
	<div class="thumbnail"><img alt="Sample Logo" src="{{ asset($imgsrc) }}"> 
		<div class="caption">
			<h3 class="text-center">Title/Caption: {{ $l->caption }}</h3> <br/>
			@if($l->selected == 'Yes')
				<p class="text-center"><span class="label label-success">Used</span></p>
			@else
				<p class="text-center"><span class="label label-danger">Not Used</span></p>
			@endif
			@if($l->primary_logo == 'Yes')
				<?php $prim = 'yes'; ?>
				<p class="text-center"><span class="label label-success">Primary</span></p>
			@else
				<p class="text-center"><span class="label label-danger">Not Primary</span></p>
			@endif
			<br/>
			<p>		
				@if($prim == 'no')
					<a href="{{ route('logo.set.primary', ['id' => $l->id]) }}" class="btn btn-primary" role='button'>Set as Primary</a> 
				@endif				
				<a href="{{ route('delete.logo', ['id' => $l->id]) }}" class="btn btn-danger" role='button'>Delete</a>
			</p> 
		</div> 
	</div> 
</div>
    	@endforeach			
	</div>    
	<div class=row>
                <center>{{ $logos->links() }}</center>
        </div>
	@else
		<div class="alert alert-warning" role="alert">  			
  			<strong>No logo yet!</strong> Please add one. <a href="{{ route('logo.add') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Logo</a>
		</div>	
	@endif
  </div> 
</div>
@endsection
