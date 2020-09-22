@include('partials.admin.portrait_note')
<div class="row">			    	
	<div class="col-sm-8">
		<div class="form-group">
			{{ Form::label('caption', 'Caption', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">			    	
				<div class="input-group">
						{{ Form::text('caption', null, ['class' => 'form-control input-sm', 'placeholder' => 'Portrait caption or title goes here ...', 'required']) }}
						<span class="input-group-addon"><i class="fa fa-edit"></i></span>
				</div>		
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('primary_portrait', 'Primary', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				<select class="form-control input-sm" id="primary_portrait" name="primary_portrait" required>
					@if($hasPrimary == "yes")
						<option value="No">No</option>	
						<option value="Yes">Yes</option>						
					@else
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					@endif
				</select>				                               
			</div>
		</div>
		 <div class="form-group">
			{{ Form::label('filename', 'Upload File', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				{{ Form::file('filename', ['required']) }}
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<img src="{{ asset('images/image-placeholder.png') }}" alt="Image Placeholder" class="img-thumbnail img-responsive center-block">		
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Begin Upload</button>
		<a href="{{ route('portraits') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>
