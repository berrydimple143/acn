@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h2>Warning!</h2></center>    
  </div>
  <div class="panel-body">
    <center>
		<h2 class="text-yellow"><i class="fa fa-warning"></i>&nbsp;Please validate your email and mobile first before you can add an advertisement. <a href="{{ route('home') }}">Click here</a></h2>
	</center>
  </div> 
</div>
@endsection