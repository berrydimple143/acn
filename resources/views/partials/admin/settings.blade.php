<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_nickname', 'Nickname', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_nickname', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nickname here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">						
			<label for="customer_title" class="col-sm-4 control-label">Title <span class="req title-marker"><i class="fa fa-asterisk"></i></span></label>
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_title', null, ['class' => 'form-control input-sm', 'id' => 'customer_title', 'placeholder' => 'Title here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">			
			<label for="customer_tax_id" class="col-sm-4 control-label">Tax ABN/ACN <span class="req tax-marker"><i class="fa fa-asterisk"></i></span></label>
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_tax_id', null, ['class' => 'form-control input-sm', 'id' => 'customer_tax_id', 'placeholder' => 'Tax ABN/ACN here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_name', 'Firstname', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Firstname here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_middlename', 'Middlename', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_middlename', null, ['class' => 'form-control input-sm', 'placeholder' => 'Middlename here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_surname', 'Lastname', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_surname', null, ['class' => 'form-control input-sm', 'placeholder' => 'Lastname here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_position', 'Position', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_position', null, ['class' => 'form-control input-sm', 'placeholder' => 'Position here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-hand-o-left"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="customer_businessname" class="col-sm-4 control-label">Business Name <span class="req businessname-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_businessname', null, ['class' => 'form-control input-sm', 'id' => 'customer_businessname', 'placeholder' => 'Business Name here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">			
			<label for="customer_password" class="col-sm-4 control-label">Password <span class="req password-marker"><i class="fa fa-asterisk"></i></span></label>
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_password', null, ['class' => 'form-control input-sm', 'id' => 'customer_password', 'placeholder' => 'Password here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="customer_email" class="col-sm-4 control-label">Email <span class="req email-marker"><i class="fa fa-asterisk"></i></span></label>			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_email', null, ['class' => 'form-control input-sm', 'id' => 'customer_email', 'placeholder' => 'Email here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_phone', 'Phone', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_phone', null, ['class' => 'form-control input-sm', 'placeholder' => 'Phone number here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_mobile', 'Mobile', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_mobile', null, ['class' => 'form-control input-sm', 'placeholder' => 'Mobile number here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_address_1', 'Address Line 1', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_address_1', null, ['class' => 'form-control input-sm', 'placeholder' => 'Primary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_address_2', 'Address Line 2', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_address_2', null, ['class' => 'form-control input-sm', 'placeholder' => 'Secondary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_city', 'City', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_city', null, ['class' => 'form-control input-sm', 'placeholder' => 'City here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-globe"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">					
			<label for="customer_state" class="col-sm-4 control-label">State <span class="req state-marker"><i class="fa fa-asterisk"></i></span></label>	
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_state', null, ['class' => 'form-control input-sm', 'id' => 'customer_state', 'placeholder' => 'State here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-globe"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('customer_postcode', 'Postcode', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_postcode', null, ['class' => 'form-control input-sm', 'placeholder' => 'Postcode here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-globe"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_country', 'Country', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select id="customer_country" name="customer_country" class="form-control input-sm">
		            @if($title == "Account Settings")
		                <option value="{{ $user->customer_country }}">{{ $user->customer_country }}</option>  
		            @endif
		            @foreach($countries as $country)
		                <option value="{{ $country->country }}">{{ $country->country }}</option>  
		            @endforeach
		        </select>						
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('customer_skcwallet', 'SKC Wallet', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('customer_skcwallet', null, ['class' => 'form-control input-sm', 'placeholder' => 'Skippycoin address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-certificate"></i></span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">&nbsp;</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
		<a href="{{ route('home') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>