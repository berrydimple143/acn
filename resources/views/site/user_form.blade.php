@extends('layouts.front')
@section('title', $title)
@section('content')
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">Terms of Use</h3>
      </div>
      <div class="modal-body">
		@include('partials.terms')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>
	<div id="confirm-container">		
		{!! Form::open(['route' => 'user.create', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}
			{{ Form::hidden('mobile', $mobile) }}					    
		    <div class="form-group">
				<label for="firstname">First Name:</label>
				<input type="text" class="form-control" name="firstname" required>
			</div>
		    <div class="form-group">
				<label for="lastname">Last Name:</label>
				<input type="text" class="form-control" name="lastname" required>
			</div>
		    <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" name="email" required>
			</div>
		    <div class="checkbox">
				<label>
					<input class="form-check-input" type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : 'checked' }} required> {{ __('Accept Terms and Conditions') }}
				</label>
			</div>
		    <div class="form-group">&nbsp;</div>
		    <button type="submit" class="btn btn-primary"><i class="fa fa-share"></i> Submit</button>  		   
		{!! Form::close() !!}
	</div>
@endsection
<style>
	#confirm-container { margin: 10px auto; width: 420px; background-color: #fff; padding: 30px; border: 1px solid #003399; } 
</style>
