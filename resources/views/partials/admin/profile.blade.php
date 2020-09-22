<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_name', 'Name', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">			    	
				{{ Form::text('customer_name', null, ['class' => 'form-control input-sm', 'disabled' => 'true']) }}					
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_description', 'Self Description', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				{{ Form::textarea('customer_description', null, ['class' => 'form-control input-sm', 'rows' => 4]) }}							
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_facebook', 'Facebook URL', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_facebook', null, ['class' => 'form-control input-sm', 'id' => 'customer_facebook', 'placeholder' => 'https://www.facebook.com/your.facebook.page']) }}					
					<span class="input-group-addon" id="fb-button"><i class="fa fa-facebook-official"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_twitter', 'Twitter URL', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_twitter', null, ['class' => 'form-control input-sm', 'id' => 'customer_twitter', 'placeholder' => 'https://twitter.com/your.twitter.feed']) }}					
					<span class="input-group-addon" id="twitter-button"><i class="fa fa-twitter"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_linkedin', 'Linked in URL', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_linkedin', null, ['class' => 'form-control input-sm', 'id' => 'customer_linkedin', 'placeholder' => 'https://www.linkedin.com/in/your.profile']) }}					
					<span class="input-group-addon" id="linkedin-button"><i class="fa fa-linkedin"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_pwebsite', 'Personal Website', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_pwebsite', null, ['class' => 'form-control input-sm', 'id' => 'customer_pwebsite', 'placeholder' => 'http(s)://your.website.com']) }}					
					<span class="input-group-addon" id="pw-button"><i class="fa fa-globe"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_cwebsite', 'Community Website', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_cwebsite', null, ['class' => 'form-control input-sm', 'id' => 'customer_cwebsite', 'placeholder' => 'http(s)://your.community.website']) }}					
					<span class="input-group-addon" id="cw-button"><i class="fa fa-globe"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_businessname', 'Business Name', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				{{ Form::text('customer_businessname', null, ['class' => 'form-control input-sm', 'disabled' => 'true']) }}										
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_bdescription', 'Business Description', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				{{ Form::textarea('customer_bdescription', null, ['class' => 'form-control input-sm', 'placeholder' => 'Business Description here ...', 'rows' => 4]) }}							
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('customer_bwebsite', 'Business Website', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('customer_bwebsite', null, ['class' => 'form-control input-sm', 'id' => 'customer_bwebsite', 'placeholder' => 'http(s)://your.business.website.com']) }}					
					<span class="input-group-addon" id="bw-button"><i class="fa fa-globe"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
		<a href="{{ route('home') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>