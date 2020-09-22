@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="{{ route('email.add.options') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add Email</a>
    <center><h3>Emails for "{{ $list->name }}" list</h3></center>    
  </div>
  <div class="panel-body">
    <table class="display" id="emails-table" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th>Email</th>
				<th>First Name</th>
                <th>Last Name</th>               
                <th style="text-align: center;">Status</th>				
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
    </table>
  </div> 
</div>
@endsection