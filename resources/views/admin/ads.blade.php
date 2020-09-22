@extends('layouts.admin')
@section('title', 'Advertisements List')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="{{ route('ads.select') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add Advertisement</a>
    <center><h3>List of Advertisements <span class="badge">{{ $adCount }}</span></h3></center>    
  </div>
  <div class="panel-body">
    <table class="display" id="ads-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Ad ID</th>
                <th>Portal</th>                
                <th>Directory</th>
                <th>Category</th>
				<th style="text-align: center;">Status</th>
                <th style="text-align: center; width: 125px;">Action</th>
            </tr>
        </thead>
    </table>
  </div> 
</div>
@endsection