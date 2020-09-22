<?php	
	$clevel = session('user')->customer_level;
	$cust_id = session('user')->customer_id;
	$limit_exceeded = "no";	
	$customer = \App\User::where('customer_id', $cust_id)->first();
	$numOfEvent = \App\Event::where('customer_id', $cust_id)->count();	
	$lmt = $customer->event_limit;
	if($lmt != "" || !empty($lmt) || $lmt != null || $lmt != 0 || $lmt != '0') {
		if($lmt == "") {
			$limit_exceeded = "no";
		} else {
			$arlimit = (int)$lmt;
			if($numOfEvent >= $arlimit) {
				$limit_exceeded = "yes";
			}
		}	
	}
	$mapTip = "<ul><li>Where are you?</li>";	
    $mapTip .= "<li>Think about where you want us to send your customers or members, expect more to find you with accurate car and pocket GPS.</li>";
    $mapTip .= "<li>Zoom in all the way to ground level with the scroll wheel or plus symbol,  drag and place the pointer exactly on your front door, show room, driveway, or meeting place.</li>";
    $mapTip .= "<li>You can use the search function, it may help to type your full address including 'Australia'.</li>";
    $mapTip .= "<li>Last: Center the map and zoom out to set your desired map height!</li>";
    $mapTip .= "<li>A good height includes some nearby highway or landmark labels to give your visitor a idea where you are in relation to your town.</li></ul>";
    $mapTip .= "<u>Tips</u><br/>";
	$mapTip .= "<ul><li>Hold your click and drag the map background to navigate.</li>";
    $mapTip .= "<li>Drag the orange peg man onto the map to see street level views</li>";
    $mapTip .= "<li>Click the top right corner X to exit street view.</li>";
    $mapTip .= "<li>Click to toggle between Satellite and Map views.</li>";
    $mapTip .= "<li>Alternatively you may elect NOT to add Maps, i.e If you are home based, mobile or web services/provider</li>";
    $mapTip .= "<li>Later: Confirm your map settings in your live Ad!</li></ul>";    
    $tooltip1 = "Events in a Physical Place";	
	$tooltip2 = "Events that have no fixed location such as Queens Birthday";	                                                                                
	$tooltip3 = "Virtual Events that take place on the Internet or Media or have no Physical Place";	
	$tooltip8 = "Events in a Physical Place";		
	$tooltip9 = "Events that have no fixed location such as Queens Birthday";		
	$tooltip10 = "Virtual Events that take place on the Internet or Media or have no Physical Place";		
	$contentTip = "<ul><li>What Where Why Who When. What you provide or do or sell (and perhaps what you do not do).</li>";
	$contentTip .= " <li>Why should a customer choose your business or product?</li>";
	$contentTip .= " <li>What you believe in or your ethic?</li>";
	$contentTip .= " <li>Briefly explain your or Service or Experience or Facilities or Product Line.</li>";
	$contentTip .= " <li>The scope or main capabilities of your organization.</li>";
	$contentTip .= " <li>Use keywords that your customers may use in search terms!</li>";
	$contentTip .= " <li>Consider describing your opening hours.</li></ul>";
	$locationTip1 = "Post your Ad to all websites in a specific town.\n";
	$locationTip2 = "Post your Ad to all websites in the selected state.\n"; 
	$locationTip3 = "Post your Ad to all websites in the entire country\n";			
	$post_status = "not allowed";
	$ad_location = $location.", Australia";
	if($evtype == "business") {
		if($clevel == "Local Business" || $clevel == "National Business" || $clevel == "Administrator") {			
			$post_status = "allowed";		
		}
	} elseif($evtype == "community") {
		if($clevel == "Community Leader" || $clevel == "Local Business" || $clevel == "National Business" || $clevel == "Administrator") {			
			$post_status = "allowed";		
		}		
	} elseif($evtype == "national") {
		if($clevel == "National Business" || $clevel == "Administrator") {			
			$post_status = "allowed";		
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
<div class="modal fade" id="videoModalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
      </div>
      <div class="modal-body">
			<div class="row">
				<center>
					<h3 id="event-video-title"></h3>
					<p id="event-video-show"></p>
				</center>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="event_yid">Enter a YouTube Video ID Code (11 characters)</label></div>			  
			</div>
			<div class="row">
			    <div class="col-sm-12"><input type="text" class="form-control" id="event_yid" placeholder="Type youtube video id code here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="event_yurl">Or Paste a YouTube URL (Begins with http)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><input type="text" class="form-control" id="event_yurl" placeholder="Paste youtube url here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="event_yembed">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><textarea class="form-control" id="event_yembed" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
			</div>
			<div class="row">			  
			  <div class="col-sm-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkEventVideo"><i class="fa fa-check-circle-o"></i> Check Video</button>					
				</div>
			</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-flat btn-sm" id="addEventVideo" data-dismiss="modal">Add</button>
		<button type="button" id="cancelEventVideo" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>       
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="bannerModalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
								<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-banner-event" role=button>Add</a></p>
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
<input type="hidden" id="dummyvideoid" value="">
<input type="hidden" id="eventvideoid" name="eventvideoid" value="">
<input type="hidden" id="location_map" name="location_map" value="{{ $location_map }}">
<input type="hidden" id="evtype" name="evtype" value="{{ $evtype }}">
<input type="hidden" id="admap" name="admap" value="{{ $admap }}">
@if($numOfBanners <= 0)
	@include('partials.admin.banner_note')
@endif
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">			
			<label for="event_start" class="col-sm-4 control-label">Start <span class="req"><i class="fa fa-asterisk"></i></span></label>
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_start', $start, ['class' => 'form-control', 'id' => 'event_start', 'required']) }}					
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>							
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="event_stop" class="col-sm-4 control-label">Stop <span class="req"><i class="fa fa-asterisk"></i></span></label>								
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_stop', $stop, ['class' => 'form-control', 'id' => 'event_stop', 'required']) }}						
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			<label for="event_banner" class="col-sm-4 control-label">Banner <span class="req"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">				
				<div class="input-group">
				  {{ Form::text('event_banner', null, ['class' => 'form-control', 'id' => 'event_banner', 'placeholder' => 'Banner here ...', 'required', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="selectBannerEvent" type="button">Select</button>
					<button class="btn btn-default" id="clearEventBanner" title="Clear Banner" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_videoid', 'Video', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">
				<div class="input-group">
				  {{ Form::text('event_videoid', null, ['class' => 'form-control', 'id' => 'event_videoid', 'placeholder' => 'Include a Video in your Event', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="testYoutubeEvent" type="button">Put</button>
					<button class="btn btn-default" id="clearEventVideo" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="col-sm-offset-4 col-sm-8" id="event_banner_thumb">
			{!! $bannersrc !!}
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col-sm-offset-4 col-sm-8" id="event_video_thumb">
			{!! $vidsrc !!}
		</div>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			<label for="event_name" class="col-sm-4 control-label">Event Name <span class="req"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_name', null, ['class' => 'form-control input-sm', 'placeholder' => 'Event name here ...', 'required']) }}					
					<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_url', 'Event Web URL', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_url', null, ['class' => 'form-control input-sm', 'placeholder' => 'Event Web URL here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-globe"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('event_email', 'Event Email Address ', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_email', null, ['class' => 'form-control input-sm', 'placeholder' => 'Event Email here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_phone', 'Event Phone Number', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_phone', null, ['class' => 'form-control input-sm', 'placeholder' => 'Event Phone here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('event_mobile', 'Optional Mobile Number', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_mobile', null, ['class' => 'form-control input-sm', 'placeholder' => 'Mobile here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_address_1', 'Address Line 1', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_address_1', null, ['class' => 'form-control input-sm', 'placeholder' => 'Primary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('event_address_2', 'Address Line 2', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_address_2', null, ['class' => 'form-control input-sm', 'placeholder' => 'Secondary Address here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_city', 'City', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_city', null, ['class' => 'form-control input-sm', 'placeholder' => 'Event City here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">						
		<div class="form-group">
			{{ Form::label('event_state', 'State', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select name="event_state" id="event_state" class="form-control input-sm">	
					@if($title == "Business Event Editor" || $title == "Community Event Editor" || $title == "National Event Editor")
						<option value="{{ $event->event_state }}">{{ $event->event_state }}</option>
					@else 
						<option value="">Choose State Here</option>
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
			{{ Form::label('event_postcode', 'Post Code', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<div class="input-group">
					{{ Form::text('event_postcode', null, ['class' => 'form-control input-sm', 'placeholder' => 'Post Code here ...']) }}					
					<span class="input-group-addon"><i class="fa fa-codepen"></i></span>
				</div>				
			</div>
		</div>
	</div>
</div>	
<div class="row">	
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_country', 'Country', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				{{ Form::select('event_country', ['Australia' => 'Australia', 'Outside Australia' => 'Outside Australia'], null, ['placeholder' => 'Select here ...', 'class' => 'form-control']) }}										
			</div>
		</div>
	</div>
	<div class="col-sm-6">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Where to Post this Event?</h3>	
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<label class="radio-inline">
			  <input type="radio" class="event_locationtype" name="event_locationtype" id="town" value="town" {{ session('townStyle') }} {{ $check1 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip1 }}"> Location <span class="badge {{ session('townbadge') }}">{{ session('townbadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="event_locationtype" name="event_locationtype" id="state" value="state" {{ session('stateStyle') }} {{ $check2 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip2 }}"> Entire State <span class="badge {{ session('statebadge') }}">{{ session('statebadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="event_locationtype" name="event_locationtype" id="country" value="country" {{ session('countryStyle') }} {{ $check3 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip3 }}"> Entire Country <span class="badge {{ session('countrybadge') }}">{{ session('countrybadgetext') }}</span>
			</label>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">	
	<div class="col-sm-6">
		<div class="form-group">
			{{ Form::label('event_portal', 'Post To', ['class' => 'col-sm-4 control-label']) }}			
			<div class="col-sm-8">	
				<select id="event_portal" name="event_portal" class="form-control input-sm">	
					{!! $locationHTML !!}					
		        </select>						
			</div>
		</div>
	</div>
	<div class="col-sm-6">&nbsp;</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center><h2 class="text-green">Maps</h2></center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<div class="checkbox">
				<label>				
					@if($title == "Community Event Editor" || $title == "Business Event Editor" || $title == "National Event Editor")
						@if($event->event_map == "no")
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
					Latitude: <input type="text" class="input-sm" name="event_latitude" id="latitude" value="{{ $latitude }}" style="width: 20%;" readonly>&nbsp;&nbsp;
					Longitude: <input type="text" class="input-sm" name="event_longitude" id="longitude" value="{{ $longitude }}" style="width: 20%;" readonly>&nbsp;&nbsp;
					Zoom: <input type="text" class="input-sm" name="event_zoom" id="zoom" value="{{ $zoom }}" style="width: 5%;" readonly>
				</center>
			</div>	
		</div>		
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Event Summary</h3>	
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<label class="radio-inline">
			  <input type="radio" class="event_type" name="event_type" id="located" value="located" {{ $check4 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip1 }}"> Located
			</label>
			<label class="radio-inline">
			  <input type="radio" class="event_type" name="event_type" id="observed" value="observed" {{ $check5 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip2 }}"> Observed
			</label>
			<label class="radio-inline">
			  <input type="radio" class="event_type" name="event_type" id="occasion" value="occasion" {{ $check6 }} data-toggle="popover" title="Tip" data-content="{{ $tooltip3 }}"> Occasion
			</label>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		<center>			
			<h4 id="hint4" data-toggle="popover" title="Examples" data-content="{{ $tooltip8 }}">Describe where the event is located</h4>
			<h4 id="hint5" data-toggle="popover" title="Examples" data-content="{{ $tooltip9 }}">Describe the event reason or milestone</h4>
			<h4 id="hint6" data-toggle="popover" title="Examples" data-content="{{ $tooltip10 }}">Write a  brief event summary or slogan</h4>
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>		
			{{ Form::textarea('event_teaser', null, ['class' => 'form-control', 'cols' => 75, 'rows' => 2, 'maxlength' => 160, 'id' => 'event_teaser', 'placeholder' => 'Type your event teaser here ...']) }}									
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Event Content</h3>	
			<p id="content-info" data-toggle="popover" title="Things to consider?" data-content="{{ $contentTip }}">Describe the features and benefits of your event</p>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
		{{ Form::textarea('event_content', null, ['class' => 'form-control input-sm', 'id' => 'event_content', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your content here ...']) }}				
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-sm-12">		
			<?php if($post_status == "not allowed") : ?>	
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Unable to Save. Please choose a <a href="{{ route('membership') }}">Membership</a></h3></center>			
			<?php elseif($limit_exceeded == "yes") : ?>					
				<center><h3 class="text-red"><i class="fa fa-warning"></i> Limit exceeded. <a href="{{ route('membership') }}">Please Upgrade Membership</a></h3></center>
			<?php else : ?>	
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
				<a href="{{ route('events') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
			<?php endif; ?>
		</center>
	</div>
</div>