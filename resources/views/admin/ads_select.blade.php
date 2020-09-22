@extends('layouts.admin')
@section('title', 'Advertisements List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h2>Choose Advertisement Type</h2></center>    
  </div>
  <div class="panel-body">
    <center>
		<img src="{{ asset('images/AdType.png') }}" class="img-responsive" border="0" /><br/>
		<a href="{{ route('ads.selected', ['adtype' => 'community']) }}" class="btn btn-primary btn-app-normal"><span class="badge bg-green">{{ session('community_ads') }}</span><i class="fa fa-users"></i> Community</a>&nbsp;&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('ads.selected', ['adtype' => 'commercial']) }}" class="btn btn-primary btn-app-normal"><span class="badge bg-green">{{ session('commercial_ads') }}</span><i class="fa fa-credit-card"></i> Commercial</a>
	</center>
  </div> 
</div>
@endsection