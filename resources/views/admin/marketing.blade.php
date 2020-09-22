@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-body">  	
		<div class="row">
			<h3 class="text-center">Marketing Tools</h3>
			<hr width="100%" />
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="info-box">
			        <span class="info-box-icon bg-aqua"><a href="{{ route('email.lists') }}">+<i class="fa fa-envelope-o"></i></a></span>
			        <div class="info-box-content">
			          <span class="info-box-text">Email Lists</span>
			          <span class="info-box-number">Create a list of emails</span>
			        </div>
			    </div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="info-box">
			        <span class="info-box-icon bg-green"><a href="{{ route('email.templates') }}">+<i class="fa fa-clone"></i></a></span>
			        <div class="info-box-content">
			          <span class="info-box-text">Email Templates</span>
			          <span class="info-box-number">Create an email template</span>
			        </div>
			    </div>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="info-box">
			        <span class="info-box-icon bg-yellow"><a href="{{ route('email.campaigns') }}">+<i class="fa fa-send"></i></a></span>
			        <div class="info-box-content">
			          <span class="info-box-text">Email Campaigns</span>
			          <span class="info-box-number">Create an email campaign</span>
			        </div>
			    </div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="info-box">
			        <span class="info-box-icon bg-aqua"><a href="{{ route('email.exempted') }}">+<i class="fa fa-close"></i></a></span>
			        <div class="info-box-content">
			          <span class="info-box-text">Exempted Emails</span>
			          <span class="info-box-number">Add exempted emails</span>
			        </div>
			    </div>
			</div>
		</div>
		<div class="row">&nbsp;</div>			
   </div>
</div>
@endsection
