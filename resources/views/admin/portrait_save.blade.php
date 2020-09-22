@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-upload"></i>  Portrait Uploader</h3>   
  </div>
  <div class="panel-body">
    {!! Form::open(['route' => 'portrait.save', 'method' => 'POST', 'class' => 'form-horizontal row-fluid']) !!}               
        <div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>  
        @include('partials.admin.portrait_save')
    {!! Form::close() !!}
  </div> 
</div>
@endsection
