@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="{{ route('list.add') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add List</a>
    <center><h3>List of Emails</h3></center>    
  </div>
  <div class="panel-body">
    <table class="display" id="lists-table" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th>List ID</th>
				<th>Date Created</th>
                <th>Date Updated</th>               
                <th>List Name</th>				
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
    </table>
  </div> 
</div>
@endsection