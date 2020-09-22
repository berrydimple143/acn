@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-body">  	
		<div class="row">
			<div class="media paddingleft"> 
				<div class="media-left"> 
					<a href="{{ $plink }}"><img class="media-object" src="{{ $profile_image }}" alt="Profile Image"></a> 
				</div> 
				<div class="media-body">  
					<h2 class="media-heading">{{ session('user')->customer_name }} {{ session('user')->customer_surname }}</h2> 				
					<?php if(session('user')->customer_description == "") : ?>	
						<h3><strong>Welcome to the Australian Regional Network</strong></h3>
						<?php if(session('user')->customer_title == "" || session('user')->customer_tax_id == "" || session('user')->customer_businessname == "" || session('user')->customer_state == "") : ?>					
							<h4><strong>Please review your </strong><a href="{{ route('settings') }}"><span class="label label-danger">Account Settings</span></a></h4>
							<h4><strong>Complete </strong><a href="#"><span class="label label-danger">Your Profile</span></a></h4>						
						<?php endif; ?>				
					<?php else: ?>
						<p>{{ session('user')->customer_description }}</p>
					<?php endif; ?>
					@if($cstatus != "")
						<div class="row">&nbsp;</div>
						<div class="row">
							<div class="col-sm-12">
								<strong class="text-red">{{ $cstatus }}</strong>&nbsp;&nbsp;<button type="button" title="Keep my account" id="cancelDeleteAccount" class="btn btn-danger"><i class="fa fa-cancel"></i> CANCEL DELETE</button>
							</div>					  				  
						</div>
					@endif
				    <div class="row">&nbsp;</div>
				    <div class="row">
				      <div class="col-sm-12">
						<div class="btn-group" role="group" aria-label="...">
						  <button type="button" id="validateMobile" class="{{ $mobile_btn_class }}"><i class="fa fa-phone"></i> Mobile</button>
						  <button type="button" id="validateEmail" class="{{ $email_btn_class }}"><i class="fa fa-envelope"></i> Email</button>
						  <button type="button" id="fb-btn" class="{{ $fb_btn_class }}"><i class="fa fa-facebook"></i> Facebook</button>
						  <button type="button" id="twitter-btn" class="{{ $twt_btn_class }}"><i class="fa fa-twitter"></i> Twitter</button>
						  <button type="button" id="linkedin-btn" class="{{ $lnkin_btn_class }}"><i class="fa fa-linkedin"></i> LinkedIn</button>
						</div>				      	
				      </div>					  				  
					</div>
					@if($invalids == "yes")
						<div class="row">&nbsp;</div>
						<div class="row">
							<div class="col-sm-12">
								<strong class="text-red">{{ $message }}</strong>
							</div>					  				  
						</div>
					@endif					
				</div> 
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('advertisements') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $ad_bg }}">+<i class="fa fa-laptop"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Advertisements</span>
						  <span class="info-box-number">{{ $numOfAds }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('articles') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $article_bg }}">+<i class="fa fa-newspaper-o"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Articles</span>
						  <span class="info-box-number">{{ $numOfArticle }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('events') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $event_bg }}">+<i class="fa fa-film"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Events</span>
						  <span class="info-box-number">{{ $numOfEvent }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('photos') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $photo_bg }}">+<i class="fa fa-image"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Images</span>
						  <span class="info-box-number">{{ $numOfImages }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('banners') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $banner_bg }}">+<i class="fa fa-flag"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Banners</span>
						  <span class="info-box-number">{{ $numOfBanners }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('portraits') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $portrait_bg }}">+<i class="fa fa-user"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Portraits</span>
						  <span class="info-box-number">{{ $numOfPortraits }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('logos') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $logo_bg }}">+<i class="fa fa-apple"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Your Logos</span>
						  <span class="info-box-number">{{ $numOfLogos }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('settings') }}">
					<div class="info-box">
						<span class="info-box-icon bg-green">+<i class="fa fa-wrench"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Account Settings</span>
						  <span class="info-box-number">Set your account details</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('membership') }}">
					<div class="info-box">
						<span class="info-box-icon {{ $membership_bg }}">+<i class="fa fa-user"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Membership</span>
						  <span class="info-box-number">Upgrade your membership</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xs-12">
				<a href="{{ route('sponsorship') }}">
					<div class="info-box">
						<span class="info-box-icon bg-aqua">+<i class="fa fa-bookmark"></i></span>
						<div class="info-box-content">
						  <span class="info-box-text">Sponsorship</span>
						  <span class="info-box-number">Set your sponsorship</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		@if($primary_logo != 'none')
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12 col-xs-24">
					<center><img src="{{ $primary_logo }}" class="img-responsive" alt="Responsive image"></center>
				</div>			
			</div>
		@endif
   </div>
</div>
@endsection
