<div class="row">			    	
	<div class="col-sm-8">
		<div class="form-group">
			{{ Form::label('caption', 'Caption', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">			    	
				<div class="input-group">
						{{ Form::text('caption', null, ['class' => 'form-control input-sm', 'placeholder' => 'Logo caption or title goes here ...', 'required']) }}
						<span class="input-group-addon"><i class="fa fa-edit"></i></span>
				</div>		
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('primary_logo', 'Primary', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				<select class="form-control input-sm" id="primary_logo" name="primary_logo" required>
					<option value="No">--Select this as primary--</option>	
					<option value="Yes">Yes</option>
					<option value="No">No</option>
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
		<a href="{{ route('logos') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>
