@extends('layouts.admin')
@section('title', 'Articles List')
@section('content')
<div class="panel panel-default">  
  <div class="panel-heading">
    <a href="{{ route('article.add') }}" class="btn btn-primary btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add Article</a>
    <center><h3>List of Articles <span class="badge">{{ $artCount }}</span></h3></center>
  </div>
  <div class="panel-body">
    <table class="display" id="artable" cellspacing="0" width="100%">
        <thead>
            <tr>                
                <th>Title</th>
                <th>Portal</th>
				<th>Category</th>                
                <th style="text-align: center;">Status</th>
                <th style="text-align: center; width: 125px;">Action</th>
            </tr>
        </thead>
    </table>
  </div> 
</div>
@endsection
