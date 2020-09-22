@extends('layouts.admin')
@section('title', 'Limit Exceeded')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h2>Warning!</h2></center>    
  </div>
  <div class="panel-body">
    <center>
		<h2 class="text-yellow"><i class="fa fa-warning"></i>&nbsp;Advertisement Limit exceeded. <a href="{{ route('membership') }}">Please Upgrade Membership</a></h2>
	</center>
  </div> 
</div>
@endsection