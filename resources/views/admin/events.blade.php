@extends('layouts.admin')
@section('title', 'Articles List')
@section('content')
<div class="panel panel-default">  
  <div class="panel-heading">
    <a href="{{ route('event.select') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add Event</a>
    <center><h3>List of Events <span class="badge">{{ $evCount }}</span></h3></center>
  </div>
  <div class="panel-body">
    <table class="display" id="events-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th style="text-align: center; width: 125px;">Action</th>
            </tr>
        </thead>
    </table>
  </div> 
</div>
@endsection