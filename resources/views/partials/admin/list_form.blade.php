<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label">List Name</label>					
			<div class="col-sm-9">						
				<div class="input-group">
				  {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Type your list name here ...']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" type="button"><i class="fa fa-text-width"></i></button>
				  </span>				  
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>			
		<a href="{{ route('email.lists') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>
