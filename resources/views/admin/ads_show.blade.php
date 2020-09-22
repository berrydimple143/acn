@extends('layouts.front')
@section('title', $title)
@section('content')
	<input type="hidden" id="admap" name="admap" value="{{ $admap }}">
	<div id="confirm-container">		
		<a href="#"><img src="{{ $banner_image }}" class="img-responsive" alt="{{ $subject }}"></a><br/>
		<h3>{{ $subject }}</h3><br/>
		<p>{!! $body !!}</p>
		<div id="map-container">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">	
						<center>														
							<div id="ad-map"></div>				
						</center>
					</div>	
				</div>		
			</div>
		</div>
	</div>
@endsection
<style>
	#confirm-container { width: 100%; background-color: #fff; padding: 10px; border: 1px solid #bcbcbc; } 
</style>
