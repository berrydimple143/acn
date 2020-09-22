{{ Form::hidden('filename', $flname, ['id' => 'filename']) }}
<input type="hidden" id="ext" value="{{ $ext }}">
@include('partials.admin.portrait_note')
<div class="row">			    	
	<div class="col-sm-8">		
		<div class="form-group">
			{{ Form::label('caption', 'Caption', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				<div class="input-group">
					{{ Form::text('caption', $caption, ['class' => 'form-control input-sm', 'placeholder' => 'Logo caption or title goes here ...']) }}
					<span class="input-group-addon"><i class="fa fa-edit"></i></span>
				</div>
			</div>
		</div>		
		<div class="form-group">
			{{ Form::label('primary_portrait', 'Primary', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				{{ Form::select('primary_portrait', ['Yes' => 'Yes', 'No' => 'No'], $primary, ['class' => 'form-control input-sm']) }}                                
			</div>
		</div>	
		<div class="form-group">
			{{ Form::label('angle', 'Rotation', ['class' => 'col-sm-3 control-label']) }}
			<div class="col-sm-9">
				{{ Form::select('angle', ['0' => 'Select an angle', '90' => 'Left', '-90' => 'Right', '180' => 'Flip'], null, ['class' => 'form-control input-sm', 'id' => 'angle']) }}                                
			</div>
		</div>
	</div>	
	<div class="col-sm-4" id="imghandler">
		<img src="{{ $imgsrc }}" width="{{ $nwidth }}" height="{{ $nheight }}" alt="Banner Placeholder" class="img-thumbnail img-responsive center-block">
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		<span id="cancelBtn">
			<a href="{{ route('cancel.portrait', ['flname' => $flname]) }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
		</span>
	</div>
</div>