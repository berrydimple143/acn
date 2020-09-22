@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-user-plus"></i> {{ $title }}</h3>   
  </div>
  <div class="panel-body">
    {!! Form::model($list, ['route' => ['list.update', $list->id], 'class' => 'form-horizontal row-fluid', 'id' => 'email-list-form']) !!}
        {{ method_field('PUT') }}        
        <div class="row">
          <div class="col-sm-12">
            @include('partials.admin.errors')
          </div>
        </div>  
        @include('partials.admin.list_form')
    {!! Form::close() !!}
  </div> 
</div>
@endsection