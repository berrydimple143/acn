@extends('layouts.admin')
@section('title', 'Profile Settings')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-user-plus"></i> Your Australian Regional Network Public Profile</h3>   
  </div>
  <div class="panel-body">
    {!! Form::model($user, ['route' => ['profile.update', $user->customer_id], 'class' => 'form-horizontal row-fluid']) !!}
        {{ method_field('PUT') }}        
        <div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>  
        @include('partials.admin.profile')
    {!! Form::close() !!}
  </div> 
</div>
@endsection