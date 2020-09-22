{{ Form::hidden('status', $stat) }}
{{ Form::hidden('filename', $flname) }}
<div class="row">			    	
	<div class="col-sm-8">
		<div class="form-group">
			{{ Form::label('title', 'Short Name', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">			    	
				<div class="input-group">
                                        {{ Form::text('title', $imgtitle, ['class' => 'form-control input-sm', 'placeholder' => 'Short Name goes here ...']) }}
                                        <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                </div>		
			</div>
		</div>
		<div class="form-group">
                        {{ Form::label('description', 'Long Description', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-9">
                                <div class="input-group">
                                        {{ Form::text('description', $description, ['class' => 'form-control input-sm', 'placeholder' => 'Long description goes here ...']) }}
                                        <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                </div>
                        </div>
                </div>		
		@if($stat == "GALLERY") 
			<div class="form-group">
                        	{{ Form::label('category', 'Add to Public Gallery', ['class' => 'col-sm-3 control-label']) }}
                        	<div class="col-sm-9">
					{{ Form::select('category', $categories, null, ['class' => 'form-control input-sm']) }}                                
                             	</div>
                	</div>
		@endif		
	</div>
	<div class="col-sm-4">
		<img src="{{ $imgsrc }}" width="{{ $nwidth }}" height="{{ $nheight }}" alt="Image Placeholder" class="img-thumbnail img-responsive center-block">
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		<a href="{{ route('cancel', ['flname' => $flname]) }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>
