@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><h3>Paypal Payments <span class="badge">{{ $cntr }}</span></h3></center>    
  </div>
  <div class="panel-body">
    <table class="display" id="payments-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Level</th>                
                <th>Period</th>                
				<th>Amount(in AUD)</th>				
				<th style="text-align: center;">Payment Status</th>                
            </tr>
        </thead>
    </table>
	<center><a href="https://www.paypal.com" target="_blank" class="btn btn-primary btn-flat">Manage Paypal</a></center>   
  </div> 
</div>
@endsection