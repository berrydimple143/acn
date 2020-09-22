@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-upload"></i> Banner Maker Background Uploader</h3>   
  </div>
  <div class="panel-body">    
	{!! Form::open(['route' => 'banner.maker.post', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal row-fluid']) !!}	
		<div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>
		<div class="row">			    	
			<div class="col-sm-12">
				<div class="form-group">
					{{ Form::label('filename', 'Upload Background', ['class' => 'col-sm-3 control-label']) }}
					<div class="col-sm-9">
						{{ Form::file('filename', ['required']) }}
					</div>
				</div>
				<div class="form-group">&nbsp;</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Begin Upload</button>&nbsp;&nbsp;
						<a href="{{ route('banner.selected', ['btype' => 'creator']) }}" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</a>
					</div>
				</div>
			</div>			
		</div>			
	{!! Form::close() !!}
  </div> 
</div>
@endsection