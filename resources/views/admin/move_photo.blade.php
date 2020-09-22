@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-send"></i> Please choose a gallery location below</h3>   
  </div>
  <div class="panel-body">
              
	{!! Form::model($photo, ['route' => ['move.photo.update', $photo->id], 'class' => 'form-horizontal row-fluid']) !!}
        {{ method_field('PUT') }}          
        <div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>		
        <div class="row">			    	
			<div class="col-sm-12">
				<div class="form-group">
					{{ Form::label('category', 'Category', ['class' => 'col-sm-3 control-label']) }}					
					<div class="col-sm-9">
						{{ Form::select('category', $categories, null, ['class' => 'form-control input-sm']) }}											
					</div>
				</div>
			</div>
		</div>
		<div class="row">			    	
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Move Now</button>
				<a href="{{ route('photos') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
			</div>
		</div>
    {!! Form::close() !!}
  </div> 
</div>
@endsection