@extends('layouts.admin')
@section('title', 'Event List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h2>Choose Event Type</h2></center>    
  </div>
  <div class="panel-body">
    <center>
		<img src="{{ asset('images/Choose-Event-Type.png') }}" class="img-responsive" border="0" /><br/>		
		<a href="{{ route('event.selected', ['evtype' => 'community']) }}" class="btn btn-primary btn-app-normal"><span class="badge bg-green">{{ $cvt }}</span><i class="fa fa-users"></i> Community</a>&nbsp;&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('event.selected', ['evtype' => 'business']) }}" class="btn btn-primary btn-app-normal"><span class="badge bg-green">{{ $bvt }}</span><i class="fa fa-credit-card"></i> Business</a>&nbsp;&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('event.selected', ['evtype' => 'national']) }}" class="btn btn-primary btn-app-normal"><span class="badge bg-green">{{ $nvt }}</span><i class="fa fa-flag"></i> National</a>
	</center>
  </div> 
</div>
@endsection