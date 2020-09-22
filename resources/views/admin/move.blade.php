@extends('layouts.admin')
@section('title', 'Account Settings')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-group"></i> Move Community Portal</h3>   
  </div>
  <div class="panel-body">
	<form class="form-horizontal row-fluid">
		<input type="hidden" id="homeportal" value="{{ $hp }}">		
		<div class="row">		
			<div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-10">
				<div class="form-group">
					{{ Form::label('stateportal', 'State', ['class' => 'col-sm-3 control-label']) }}					
					<div class="col-sm-9">			    	
						<select name="stateportal" id="stateportal" class="form-control input-sm">
							<option value="">Select State</option>
							<?php foreach($states as $key => $value) : ?>
								<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php endforeach; ?>
						</select>					
					</div>
				</div>
			</div>
			<div class="col-sm-1">&nbsp;</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">		
			<div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-10">
				<div class="form-group">
					{{ Form::label('regionportal', 'Region', ['class' => 'col-sm-3 control-label']) }}					
					<div class="col-sm-9">			    	
						<select name="regionportal" id="regionportal" class="form-control input-sm" required>
							<option value="">Select Region</option>
						</select>					
					</div>
				</div>
			</div>
			<div class="col-sm-1">&nbsp;</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">		
			<div class="col-sm-4">&nbsp;</div>
			<div class="col-sm-4">
				<div class="form-group">
					<button type="button" class="btn btn-block btn-social btn-facebook btn-flat" id="gotoportal"><i class="fa fa-hand-o-right"></i> Go There</button>
				</div>
			</div>
			<div class="col-sm-4">&nbsp;</div>
		</div>	
		<div class="row">&nbsp;</div>
		@if($hp !== $cp)
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row">				
				<div class="col-sm-12">
					<div class="form-group">							
						<h2 class="text-green text-center"><i class="fa fa-home"></i> Move Home Portal</h2>
					</div>
				</div>				
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">						
				<div class="col-sm-12">
					<div class="form-group">							
						<h3 class="text-center">Your Home Portal is <span class="text-green">{{ $hp }}</span></h3>
					</div>
				</div>				
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">				
				<div class="col-sm-12">
					<div class="form-group">							
						<h3 class="text-center">Your Current Portal is <span class="text-red">{{ $cp }}</span></h3>
					</div>
				</div>				
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">		
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="form-group">
						<button type="button" class="btn btn-block btn-social btn-github btn-flat" id="movehere"><i class="fa fa-hand-o-down"></i> Move Here</button>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">		
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="form-group">
						<button type="button" class="btn btn-block btn-social btn-google-plus btn-flat" id="gohome"><i class="fa fa-home"></i> Go Home</button>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>
		@endif
		<div class="row">&nbsp;</div>
	</form>
  </div> 
</div>
@endsection