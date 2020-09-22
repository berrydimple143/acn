@extends('layouts.admin')
@section('title', 'Account Settings')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">  
	<button type="button" id="deleteAccount" class="btn btn-danger pull-right"><i class="fa fa-trash"></i> Delete My Account</button>	
    <h3 class="box-title text-green text-center"><i class="fa fa-gears"></i> Account Settings</h3> 	
  </div>
  <div class="panel-body">
    {!! Form::model($user, ['route' => ['settings.update', $user->customer_id], 'class' => 'form-horizontal row-fluid', 'id' => 'account-settings-form']) !!}
        {{ method_field('PUT') }}        
        <div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>  
        @include('partials.admin.settings')
    {!! Form::close() !!}
  </div> 
</div>
@endsection