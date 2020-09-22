<?php
	$locationTip1 = "Post your Ad to all websites in a specific town.\nNote:\nDisabled as per membership privilege.\n";
	$locationTip2 = "Post your Ad to all websites in the selected state.\nNote:\nDisabled as per membership privilege.\n";
	$locationTip3 = "Post your Ad to all websites in the entire country\nNote:\nDisabled as per membership privilege.\n";
	$categoryTip = "When adding new categories we may bundle, move or deny your new category for sanity.\n";
	$tooltip1 = "Choose this if you have a locally based business with premises, shop, show room, yard or counter<br/>";
	$tooltip1 .= "Example: <br/>Shop, Bank, Hotel, Car Sales, School, Restaurant, Market, Pub, Car Parking, Horse Riding<br/>";
	$tooltip1 .= "(You will probably want to include Maps)<br/>";
	$tooltip2 = "Choose this if you have a local services based business<br/>";
	$tooltip2 .= "Example: <br/>Builder, Lawn Mowing, Plumber, Mobile Mechanic, Web Site Developer, Taxi<br/>";
	$tooltip2 .= "(It may or may not be a good idea to include Maps)<br/>";                                                                                
	$tooltip3 = "Choose this if you are a remote services or product provider such as a statewide or national business with no direct local office however you have capability to deliver into this region<br/>";
	$tooltip3 .= "Example: <br/>Online Shop, Telephone Information Service, Internet Banking Service, Radio Station, Virtual Assistant<br/>";
	$tooltip3 .= "(You probably do not want to include Maps)<br/>";
	$tooltip5 = "We recommend you use <br/>1. Your business name <br/>2. Principal product or service name <br/>3. Town, Suburb or Region name. <br/>";
	$tooltip5 .= "Give outline directions. Please do not include your full address here. <br/>";
	$tooltip5 .= "Here are some Examples: <br/>"; 
	$tooltip5 .= "Michelles Gifts is located on the second level within Knox City Shopping Centre in Wantirna South. ";
	$tooltip5 .= "Sprint Bikes is located on the Stuart Highway one kilometer North of Alice Springs, find us on the left as you head out of town towards the MVR. ";
	$tooltip5 .= "Coffee &#013;Wizard &#013;Cafe is located in the Australia Fair Shopping Centre two kilometers North of Surfers Paradise";	
	$tooltip6 = "We recommend you use: <br/>";
	$tooltip6 .= "1. Your business name <br/>";
	$tooltip6 .= "2. Principal service or product name <br/>";
	$tooltip6 .= "3. Town, Suburb or Region names. <br/>";
	$tooltip6 .= "Please do not include your full address here. <br/>";
	$tooltip6 .= "Here are some Examples: <br/>";
	$tooltip6 .= "Jims Antennas provides communications services to Southport, Surfers Paradise and Mermaid Beach in the Queensland Gold Coast Region. ";
	$tooltip6 .= "Sparks Electrical services Alice Springs and Surrounding Communities within 200 kilometers. We also have a trade shop in the Milner industrial area. ";
	$tooltip6 .= "Peters Plumbing is located in Mitcham. We service Melbourne Eastern Suburbs preferably from Box Hill to Ringwood and within The City of Whitehorse";	
	$tooltip7 = "We recommend you use: <br/>";
	$tooltip7 .= "1. Your business name <br/>";
	$tooltip7 .= "2. Principal product or service name. <br/>";
	$tooltip7 .= "Here are some Examples: <br/>";
	$tooltip7 .= "Hairy Wombat Media is an Australian based internet media creation company specializing in affordable web sites and  internet video. ";
	$tooltip7 .= "The Online Flower Shop offering arrangements, bouquets and orchid plants for delivery locally by our affiliates throughout all Australia. ";
	$tooltip7 .= "The Miracle Life Coach delivers coaching and mentoring to Australians through Telephone and Email";
	$contentTip = "<ul><li>What Where Why Who When. What you provide or do or sell (and perhaps what you do not do).</li>";
	$contentTip .= " <li>Why should a customer choose your business or product?</li>";
	$contentTip .= " <li>What you believe in or your ethic?</li>";
	$contentTip .= " <li>Briefly explain your or Service or Experience or Facilities or Product Line.</li>";
	$contentTip .= " <li>The scope or main capabilities of your organization.</li>";
	$contentTip .= " <li>Use keywords that your customers may use in search terms!</li>";
	$contentTip .= " <li>Consider describing your opening hours.</li></ul>";	
	$account_completed = "Yes";
	$post_status = "allowed";
	$ad_limit_exceeded = "no";
	$cust_id = session('user')->customer_id;
	$customer = \App\User::where('customer_id', $cust_id)->first();
	$numOfAds = \App\Advertisement::where('customer_id', $cust_id)->count();
	if($customer->customer_title == "" || $customer->customer_tax_id == "" || $customer->customer_businessname == "" || $customer->customer_state == "") {
		$account_completed = "No";
	}
	//if($customer->customer_level == "Local Resident") {
	//	$post_status = "not allowed";
	//}	
	$adlmt = $customer->ad_limit;
	if($adlmt != "" || !empty($adlmt) || $adlmt != null || $adlmt != 0 || $adlmt != '0') {
		if($adlmt == "") {
			$ad_limit_exceeded = "no";
		} else {
			$adlimit = (int)$adlmt;
			if($numOfAds >= $adlimit) {
				$ad_limit_exceeded = "yes";
			}
		}		
	}	
	$states = [
		"Australian Capital Territory",
		"New South Wales",
		"Northern Territory",
		"Queensland",
		"South Australia",
		"Tasmania",
		"Victoria",
		"Western Australia"
	];	
?>
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
      </div>
      <div class="modal-body">        
			<div class="row">
				<center>
					<h3 id="youtube-video-title"></h3>
					<p id="youtube-video-show"></p>
				</center>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="youtubeid">Enter a YouTube Video ID Code (11 characters)</label></div>			  
			</div>
			<div class="row">
			    <div class="col-sm-12"><input type="text" class="form-control" id="youtubeid" placeholder="Type youtube video id code here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="youtubeurl">Or Paste a YouTube URL (Begins with http)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><input type="text" class="form-control" id="youtubeurl" placeholder="Paste youtube url here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="youtubeembed">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><textarea class="form-control" id="youtubeembed" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
			</div>
			<div class="row">			  
			  <div class="col-sm-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkVideo"><i class="fa fa-check-circle-o"></i> Check Video</button>					
				</div>
			</div>		
      </div>
      <div class="modal-footer">        
		<button type="button" class="btn btn-success btn-flat btn-sm" id="addVideo" data-dismiss="modal">Add</button>
		<button type="button" id="cancelVideo" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Choose a banner</h4>
      </div>
      <div class="modal-body">  
		@if($numOfBanners > 0)
			<div class="row">			
				@foreach($banners as $b)
					<div class="col-sm-6 col-md-4">
						<?php
							$imgsrc = "/images/noimage.png";
							if($b->filename != "") {
								$imgsrc = "/publicimages/banners/" . $b->filename;
							}
						?> 
						<div class="thumbnail">
							<img alt="Sample Banner" src="{{ $imgsrc }}"> 
							<div class="caption">							
								<p>{{ $b->description }}</p><br/>
								<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-banner" role=button>Add</a></p>
							</div> 
						</div>
					</div>
				@endforeach				
			</div>
		@else 
			<div class="row"><center><h3>No banner uploaded yet. Please click <a href="{{ route('banner.selection') }}">here</a> to make or upload one.</h3></center></div>		
		@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="dummyadsvideoid" value="">
<input type="hidden" id="videoid" name="videoid" value="">
<input type="hidden" id="admap" name="admap" value="{{ $admap }}">
<input type="hidden" id="ad_stream" name="ad_stream" value="{{ $ad_stream }}">
<input type="hidden" id="location_map" name="location_map" value="" />
<?php if($account_completed == "No") : ?>
	<div class="row">
		<div class="col-sm-12">
			<center><h3 class="text-red"><i class="fa fa-warning"></i> Please complete your <a href="{{ route('settings') }}">Account Settings</a></h3></center>
		</div>
	</div>
	<div class="row">&nbsp;</div>
<?php endif; ?>
@if($numOfBanners <= 0)
	@include('partials.admin.banner_note')
@endif
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			<label for="directory" class="col-sm-4 control-label">Directory <span class="req directory-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">				
				<select name="ad_directory" id="directory" class="form-control input-sm" required>
					@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
						<option value="{{ $ad->ad_directory }}">{{ $ad->ad_directory }}</option>
					@else
						<option value=""></option>	
					@endif									
					@foreach($directories as $dir)
		                <option value="{{ $dir->directory }}">{{ $dir->directory }}</option>  
		            @endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="category" class="col-sm-4 control-label">Category <span class="req category-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">			
				<div class="input-group">					
					<select id="category" class="form-control input-sm" name="ad_category" required>
						@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
							<option value="{{ $ad->ad_category }}">{{ $ad->ad_category }}</option>
						@else
							<option value=""></option>	
						@endif
					</select>
					<span class="input-group-addon"><a href="#" id="category_add" data-original-title="Tip:" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $categoryTip }}"><i class="fa fa-plus-circle"></i> Add</a></span>
				</div>
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			<label for="banner" class="col-sm-4 control-label">Banner <span class="req banner-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">						
				<div class="input-group">
				  {{ Form::text('ad_banner', null, ['class' => 'form-control', 'id' => 'ad_banner', 'placeholder' => 'Banner here ...', 'required', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="selectBanner" type="button">Select</button>
					<button class="btn btn-default" id="clearAdsBanner" title="Clear Banner" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('ad_videoid', 'Video', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">			
				<div class="input-group">
				  {{ Form::text('ad_videoid', null, ['class' => 'form-control', 'id' => 'ad_videoid', 'placeholder' => 'Include a Video in your Ads', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="testYoutube" type="button">Put</button>
					<button class="btn btn-default" id="clearAdsVideo" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="col-sm-offset-4 col-sm-8" id="ads_banner_thumb">
			{!! $bannersrc !!}
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col-sm-offset-4 col-sm-8" id="ads_video_thumb">
			{!! $vidsrc !!}
		</div>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			<label for="businessname" class="col-sm-4 control-label">Business <span class="req businessname-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_businessname', null, ['class' => 'form-control input-sm', 'id' => 'businessname', 'placeholder' => 'Business Name here ...', 'required']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('url', 'Web URL', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_url', null, ['class' => 'form-control input-sm', 'id' => 'url', 'placeholder' => 'Web URL here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('email', 'Email ', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_email', null, ['class' => 'form-control input-sm', 'id' => 'email', 'placeholder' => 'Email here ...', $email_status]) }}					
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('phone', 'Phone', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_phone', null, ['class' => 'form-control input-sm', 'id' => 'phone', 'placeholder' => 'Phone here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('mobile', 'Mobile', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_mobile', null, ['class' => 'form-control input-sm', 'id' => 'mobile', 'placeholder' => 'Mobile here ...', $mobile_status]) }}					
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('address1', 'Address Line 1', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_address_1', null, ['class' => 'form-control input-sm', 'id' => 'address1', 'placeholder' => 'Primary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('address2', 'Address Line 2', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_address_2', null, ['class' => 'form-control input-sm', 'id' => 'address2', 'placeholder' => 'Secondary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('city', 'City', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_city', null, ['class' => 'form-control input-sm', 'id' => 'city', 'placeholder' => 'Town or City here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('state', 'State', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select name="ad_state" id="state" class="form-control input-sm">		
					@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
						<option value="{{ $ad->ad_state }}">{{ $ad->ad_state }}</option>
					@else
						<option value="">&nbsp;</option>
					@endif
					@foreach($states as $st)
		                <option value="{{ $st }}">{{ $st }}</option>  
		            @endforeach
				</select>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('postcode', 'Post Code', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('ad_postcode', null, ['class' => 'form-control input-sm', 'id' => 'postcode', 'placeholder' => 'Post Code here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">	
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('country', 'Country', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select id="country" name="ad_country" class="form-control input-sm">		
					@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
						<option value="{{ $ad->ad_country }}">{{ $ad->ad_country }}</option>
					@else 
						<option value="">&nbsp;</option>
					@endif		            
		            <option value="Australia">Australia</option>
					<option value="Outside Australia">Outside Australia</option>
		            
		        </select>						
			</div>
		</div>
	</div>
	<div class="col-sm-6">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Where to Post this Ad?</h3>	
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<label class="radio-inline">
			  <input type="radio" class="locationtype" name="ad_locationtype" id="town" {{ $check4 }} value="town" {{ session('townStyle') }} data-toggle="popover" title="Tip" data-content="{{ $locationTip1 }}"> Location <span class="badge {{ session('townbadge') }}">{{ session('townbadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="locationtype" name="ad_locationtype" id="state" {{ $check5 }} value="state" {{ session('stateStyle') }} data-toggle="popover" title="Tip" data-content="{{ $locationTip2 }}"> Entire State <span class="badge {{ session('statebadge') }}">{{ session('statebadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="locationtype" name="ad_locationtype" id="country" {{ $check6 }} value="country" {{ session('countryStyle') }} data-toggle="popover" title="Tip" data-content="{{ $locationTip3 }}"> Entire Country <span class="badge {{ session('countrybadge') }}">{{ session('countrybadgetext') }}</span>
			</label>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">	
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('postlocation', 'Post To', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select id="postlocation" name="ad_portal" class="form-control input-sm">
					@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
						<option value="{{ $ad->ad_portal }}">{{ $ad->ad_portal }}</option>						
					@endif
					{!! $locationHTML !!}					
		        </select>						
			</div>
		</div>
	</div>
	<div class="col-sm-6">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<div class="checkbox">
				<label>
					@if($adpage == "Advertisement Editor" || $adpage == "Advertisement Editor")
						@if($ad->ad_map == "no")
							<input class="form-check-input" type="checkbox" name="nomap" id="nomap" {{ old('nomap') ? 'checked' : 'checked' }}> {{ __('I do not want to add Maps') }}
						@else
							<input class="form-check-input" type="checkbox" name="nomap" id="nomap" {{ old('nomap') ? 'checked' : '' }}> {{ __('I do not want to add Maps') }}
						@endif
					@else
						<input class="form-check-input" type="checkbox" name="nomap" id="nomap" {{ old('nomap') ? 'checked' : '' }}> {{ __('I do not want to add Maps') }}
					@endif					
				</label>
			</div>	
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div id="map-container">
	<div class="row">
		<div class="col-sm-1">&nbsp;</div>
		<div class="col-sm-10">		
			<div class="form-group">
				<center>								
					<div class="input-group">
					  {{ Form::text('search_input', null, ['class' => 'form-control', 'id' => 'search-input', 'placeholder' => 'Seach a place from here ...']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="search" type="button"><i class="fa fa-search"></i> Search</button>
					  </span>				  
					</div>	
				</center>
			</div>
		</div>
		<div class="col-sm-1">&nbsp;</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">	
				<center>					
					<div id="pip-pano"></div>								
					<div id="ad-map"></div>				
				</center>
			</div>	
		</div>		
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">	
				<center>						
					Latitude: <input type="text" class="input-sm" name="ad_latitude" id="latitude" value="{{ $latitude }}" style="width: 20%;">&nbsp;&nbsp;
					Longitude: <input type="text" class="input-sm" name="ad_longitude" id="longitude" value="{{ $longitude }}" style="width: 20%;">&nbsp;&nbsp;
					Zoom: <input type="text" class="input-sm" name="ad_zoom" id="zoom" value="{{ $zoom }}" style="width: 5%;">&nbsp;&nbsp;
					<button class="btn btn-sm btn-success" id="searchCoord" type="button"><i class="fa fa-search"></i> Locate</button>					
				</center>
			</div>	
		</div>		
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">What type of business do you have?</h3>	
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">		
		<center>
			<label class="radio-inline">
			  <input type="radio" class="businesstype" name="ad_type" id="located" value="located" {{ $check1 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip1 }}"> Located
			</label>
			<label class="radio-inline">
			  <input type="radio" class="businesstype" name="ad_type" id="services" value="services" {{ $check2 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip2 }}"> Services
			</label>
			<label class="radio-inline">
			  <input type="radio" class="businesstype" name="ad_type" id="provides" value="provides" {{ $check3 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip3 }}"> Provides
			</label>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h4 id="defHint" class="text-light-blue" id="btype-label">Please choose your type of business above.</h4>
			<h4 id="hint1" data-toggle="popover" title="Examples" data-content="{{ $tooltip5 }}">Describe where your business is located</h4>
			<h4 id="hint2" data-toggle="popover" title="Examples" data-content="{{ $tooltip6 }}">Describe your customer service geography</h4>
			<h4 id="hint3" data-toggle="popover" title="Examples" data-content="{{ $tooltip7 }}">Briefly describe what you provide or sell or do</h4>
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>			
			<center>
				{{ Form::textarea('ad_teaser', null, ['class' => 'form-control', 'cols' => 75, 'rows' => 2, 'maxlength' => 160, 'id' => 'ad_teaser', 'placeholder' => 'Type your advertisement teaser here ...', 'required']) }}				
			</center>			
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Ad Content</h3>	
			<p id="content-info" data-toggle="popover" title="Things to consider?" data-content="{{ $contentTip }}">Describe the features and benefits of your business</p>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		{{ Form::textarea('ad_content', null, ['class' => 'form-control input-sm', 'id' => 'ad_content', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your content here ...']) }}				
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">		
			<?php if($account_completed == "No") : ?>	
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Unable to Save: Please complete your <a href="{{ route('settings') }}">Account Settings</a></h3></center>
			<?php elseif($post_status == "not allowed") : ?>
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Unable to Save. Please choose a <a href="{{ route('membership') }}">Membership</a></h3></center>			
			<?php elseif($ad_limit_exceeded == "yes") : ?>
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Limit exceeded. <a href="{{ route('membership') }}">Please Upgrade Membership</a></h3></center>
			<?php elseif($numOfBanners <= 0 || $numOfBanners == '0') : ?>
				<center><h3 class="text-red"><i class="fa fa-warning"></i> First Create or Upload your <a href="{{ route('banner.selection') }}">Banner</a></h3></center>
			<?php else : ?>	
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
				<a href="{{ route('advertisements') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
			<?php endif; ?>
		</center>
	</div>
</div>