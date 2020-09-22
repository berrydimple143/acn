<?php	
	$tooltip = "Optional Field. Leave Blank or 00/00/0000 for Never Expires";
	$addPhotoMsg = "Add Photo\n";
	$addLogoMsg = "Add Logo\n";	
	$vidPop = 'data-toggle="popover" title="Tip" data-content="Add Video"';
	$locationTip1 = "Post your Article to all websites in a specific town.\n";
	$locationTip2 = "Post your Article to all websites in the selected state.\n"; 
	$locationTip3 = "Post your Article to all websites in the entire country\n";
	$limit_exceeded = "no";
	$cust_id = session('user')->customer_id;
	$customer = \App\User::where('customer_id', $cust_id)->first();
	$numOfArticle = \App\Article::where('customer_id', $cust_id)->count();
	$numOfLogos = \App\Logo::where('customer_id', $cust_id)->count();
	$lmt = $customer->article_limit;
	if($lmt != "" || !empty($lmt) || $lmt != null || $lmt != 0 || $lmt != '0') {
		if($lmt == "") {
			$limit_exceeded = "no";
		} else {
			$arlimit = (int)$lmt;
			if($numOfArticle >= $arlimit) {
				$limit_exceeded = "yes";
			}
		}		
	}
?>
<input type="hidden" id="article_counter" name="article_counter" value="{{ $ccounter }}">
<input type="hidden" id="articlevideoid" name="articlevideoid" value="">
<div class="modal fade" id="articleVideoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
		<h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
      </div>
      <div class="modal-body">
			<div class="row">
				<center>
					<h3 id="article-video-title"></h3>
					<p id="article-video-show"></p>
				</center>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yid">Enter a YouTube Video ID Code (11 characters)</label></div>			  
			</div>
			<div class="row">
			    <div class="col-sm-12"><input type="text" class="form-control" id="article_yid" placeholder="Type youtube video id code here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yurl">Or Paste a YouTube URL (Begins with http)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><input type="text" class="form-control" id="article_yurl" placeholder="Paste youtube url here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yembed">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><textarea class="form-control" id="article_yembed" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
			</div>
			<div class="row">			  
			  <div class="col-sm-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkArticleVideo"><i class="fa fa-check-circle-o"></i> Check Video</button>					
				</div>
			</div>		
      </div>
      <div class="modal-footer">        
		<button type="button" class="btn btn-success btn-flat btn-sm" id="addArticleVideo" data-dismiss="modal">Add</button>
		<button type="button" id="cancelArticleVideo" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Personal Images</h4>
      </div>
      <div class="modal-body">  
		@if($numOfImages > 0)
			<div class="row">			
				@foreach($photos as $b)
					<div class="col-sm-6 col-md-4">
						<?php
							$imgsrc = "images/noimage.png";
							if($b->filename != "") {
								$imgsrc = "publicimages/thumbs/" . $b->filename;
							}
						?> 
						<div class="thumbnail">
							<img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
							<div class="caption">		
								<h3 class="text-center">{{ $b->title }}</h3> <br/>
								<p class="text-center">{{ $b->description }}</p><br/>
								<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-image" role="button">Add</a></p>
							</div> 
						</div>
					</div>
				@endforeach				
			</div>
		@else 
			<div class="row"><center><h3>No photo uploaded yet. Please click <a href="{{ route('photo.add') }}">here</a> to upload one.</h3></center></div>		
		@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Personal Logos</h4>
      </div>
      <div class="modal-body">  
		@if($numOfLogos > 0)
			<div class="row">			
				@foreach($logos as $b)
					<div class="col-sm-6 col-md-4">
						<?php
							$imgsrc = "images/noimage.png";
							if($b->filename != "") {
								$imgsrc = "publicimages/logos/thumb_" . $b->filename;
							}
						?> 
						<div class="thumbnail">
							<img alt="Sample Logo" src="{{ asset($imgsrc) }}"> 
							<div class="caption">		
								<h3 class="text-center">{{ $b->caption }}</h3> <br/>
								@if($b->selected == 'Yes')
									<p class="text-center"><span class="label label-success">Used</span></p><br/>
								@else
									<p class="text-center"><span class="label label-danger">Not Used</span></p><br/>
								@endif
								@if($b->primary_logo == 'Yes')
									<p class="text-center"><span class="label label-success">Primary</span></p><br/>
								@endif
								<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-logo" role="button">Add</a></p>
							</div> 
						</div>
					</div>
				@endforeach				
			</div>
		@else 
			<div class="row"><center><h3>No logo uploaded yet. Please click <a href="{{ route('logo.add') }}">here</a> to upload one.</h3></center></div>		
		@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
      </div>
    </div>
  </div>
</div>
<?php if($limit_exceeded == "no") : ?>	
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="category" class="col-sm-3 control-label">Category <span class="req ar-category-marker"><i class="fa fa-asterisk"></i></span></label>					
			<div class="col-sm-9">					
				<select id="category" class="form-control input-sm" name="category" required>	
					@if($title == "Article Editor" or $title == "Warning!")
						<option value="{{ $article->category }}">{{ $article->category }}</option>
					@else
						<option value="">Choose category here</option>
					@endif					
					@foreach($categories as $category)								
						<option value="{{ $category->category }}">{{ $category->category }}</option>  
					@endforeach
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="subject" class="col-sm-3 control-label">Title <span class="req ar-title-marker"><i class="fa fa-asterisk"></i></span></label>							
			<div class="col-sm-9">	
				<div class="input-group">
						{{ Form::text('subject', null, ['class' => 'form-control input-sm', 'placeholder' => 'Type your article title here ...', 'required', 'id' => 'subject']) }}
						<span class="input-group-addon"><i class="fa fa-buysellads"></i></span>
				</div>			
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="description" class="col-sm-3 control-label">Description <span class="req ar-description-marker"><i class="fa fa-asterisk"></i></span></label>								
			<div class="col-sm-9">	
				<div class="input-group">
						{{ Form::text('description', null, ['class' => 'form-control input-sm', 'placeholder' => 'Type your keywords here ...', 'required', 'id' => 'description']) }}
						<span class="input-group-addon"><i class="fa fa-quote-right"></i></span>
				</div>			
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="photo" class="col-sm-3 control-label">Select Photo</label>					
			<div class="col-sm-9">						
				<div class="input-group">
				  {{ Form::text('article_image', null, ['class' => 'form-control', 'id' => 'photo', 'placeholder' => 'Click the button at the right to select photo', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="selectImage" data-toggle="popover" title="Tip" data-content="{{ $addPhotoMsg }}" type="button"><i class="fa fa-photo"></i></button>
					<button class="btn btn-default" id="clearImage" title="Clear Photo" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-offset-3 col-sm-9">
		<div id="article_image_thumb">
			{!! $photosrc !!}
		</div>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('article_videoid', 'Video', ['class' => 'col-sm-3 control-label']) }}			
			<div class="col-sm-9">			
				<div class="input-group">
				  {{ Form::text('article_videoid', null, ['class' => 'form-control', 'id' => 'article_videoid', 'placeholder' => 'Include a Video in your Article (Optional)', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="testArticleYoutube" <?php echo $vidPop; ?> type="button"><i class="fa fa-video-camera"></i></button>
					<button class="btn btn-default" id="clearVideo" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-offset-3 col-sm-9">
		<div id="article_video_thumb">
			{!! $vidsrc !!}
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="article-content" class="col-sm-2 control-label pull-left">Content</label>
			<div class="col-sm-10">&nbsp;</div>					
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="body" class="col-sm-1 control-label">&nbsp;</label>
			<div class="col-sm-11">
				{{ Form::textarea('body', null, ['class' => 'form-control input-sm', 'id' => 'body', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your article here ...', 'required']) }}				
			</div>					
		</div>
	</div>
</div>
<?php 
	$style2 = $style3 = $style4 = $style5 = "display: none;";
	if($body2 != "") { $style2 = "display: block;"; }
	if($body3 != "") { $style3 = "display: block;"; }
	if($body4 != "") { $style4 = "display: block;"; }
	if($body5 != "") { $style5 = "display: block;"; }
?>
<div id="article2" style="{{ $style2 }}">
<input type="hidden" id="articlevideoid2" name="articlevideoid2" value="">
<div class="modal fade" id="articleVideoModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
		<h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
      </div>
      <div class="modal-body">
			<div class="row">
				<center>
					<h3 id="article-video-title2"></h3>
					<p id="article-video-show2"></p>
				</center>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yid2">Enter a YouTube Video ID Code (11 characters)</label></div>			  
			</div>
			<div class="row">
			    <div class="col-sm-12"><input type="text" class="form-control" id="article_yid2" placeholder="Type youtube video id code here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yurl2">Or Paste a YouTube URL (Begins with http)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><input type="text" class="form-control" id="article_yurl2" placeholder="Paste youtube url here.."></div>
			</div>
			<div class="row">
			  <div class="col-sm-12"><label for="article_yembed2">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
			</div>
			<div class="row">			  
			  <div class="col-sm-12"><textarea class="form-control" id="article_yembed2" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
			</div>
			<div class="row">			  
			  <div class="col-sm-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkArticleVideo2"><i class="fa fa-check-circle-o"></i> Check Video</button>					
				</div>
			</div>		
      </div>
      <div class="modal-footer">        
		<button type="button" class="btn btn-success btn-flat btn-sm" id="addArticleVideo2" data-dismiss="modal">Add</button>
		<button type="button" id="cancelArticleVideo2" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="imageModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Personal Images</h4>
      </div>
      <div class="modal-body">  
		@if($numOfImages > 0)
			<div class="row">			
				@foreach($photos as $b)
					<div class="col-sm-6 col-md-4">
						<?php
							$imgsrc = "images/noimage.png";
							if($b->filename != "") {
								$imgsrc = "publicimages/thumbs/" . $b->filename;
							}
						?> 
						<div class="thumbnail">
							<img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
							<div class="caption">		
								<h3 class="text-center">{{ $b->title }}</h3> <br/>
								<p class="text-center">{{ $b->description }}</p><br/>
								<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-image2" role="button">Add</a></p>
							</div> 
						</div>
					</div>
				@endforeach				
			</div>
		@else 
			<div class="row"><center><h3>No photo uploaded yet. Please click <a href="{{ route('photo.add') }}">here</a> to upload one.</h3></center></div>		
		@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
      </div>
    </div>
  </div>
</div>

	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="photo2" class="col-sm-3 control-label">Select Photo 2</label>					
				<div class="col-sm-9">						
					<div class="input-group">
					  {{ Form::text('article_image_2', null, ['class' => 'form-control', 'id' => 'photo2', 'placeholder' => 'Click the button at the right to select photo', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="selectImage2" data-toggle="popover" title="Tip" data-content="{{ $addPhotoMsg }}" type="button"><i class="fa fa-photo"></i></button>
						<button class="btn btn-default" id="clearImage2" title="Clear Photo" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_image_thumb2">
				{!! $photosrc2 !!}
			</div>
		</div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				{{ Form::label('article_videoid_2', 'Video 2', ['class' => 'col-sm-3 control-label']) }}			
				<div class="col-sm-9">			
					<div class="input-group">
					  {{ Form::text('article_videoid_2', null, ['class' => 'form-control', 'id' => 'article_videoid_2', 'placeholder' => 'Include a Video in your Article (Optional)', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="testArticleYoutube2" <?php echo $vidPop; ?> type="button"><i class="fa fa-video-camera"></i></button>
						<button class="btn btn-default" id="clearVideo2" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_video_thumb2">
				{!! $vidsrc2 !!}
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="article-content-2" class="col-sm-2 control-label pull-left">Content 2</label>
				<div class="col-sm-10">&nbsp;</div>					
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="body_2" class="col-sm-1 control-label">&nbsp;</label>
				<div class="col-sm-11">
					{{ Form::textarea('body_2', null, ['class' => 'form-control input-sm', 'id' => 'body_2', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your article here ...']) }}				
				</div>					
			</div>
		</div>
	</div>
</div>
<div id="article3" style="{{ $style3 }}">	
	<input type="hidden" id="articlevideoid3" name="articlevideoid3" value="">
	<div class="modal fade" id="articleVideoModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
			<h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
		  </div>
		  <div class="modal-body">
				<div class="row">
					<center>
						<h3 id="article-video-title3"></h3>
						<p id="article-video-show3"></p>
					</center>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yid3">Enter a YouTube Video ID Code (11 characters)</label></div>			  
				</div>
				<div class="row">
					<div class="col-sm-12"><input type="text" class="form-control" id="article_yid3" placeholder="Type youtube video id code here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yurl3">Or Paste a YouTube URL (Begins with http)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><input type="text" class="form-control" id="article_yurl3" placeholder="Paste youtube url here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yembed3">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><textarea class="form-control" id="article_yembed3" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
				</div>
				<div class="row">			  
				  <div class="col-sm-12">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkArticleVideo3"><i class="fa fa-check-circle-o"></i> Check Video</button>					
					</div>
				</div>		
		  </div>
		  <div class="modal-footer">        
			<button type="button" class="btn btn-success btn-flat btn-sm" id="addArticleVideo3" data-dismiss="modal">Add</button>
			<button type="button" id="cancelArticleVideo3" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="imageModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Personal Images</h4>
		  </div>
		  <div class="modal-body">  
			@if($numOfImages > 0)
				<div class="row">			
					@foreach($photos as $b)
						<div class="col-sm-6 col-md-4">
							<?php
								$imgsrc = "images/noimage.png";
								if($b->filename != "") {
									$imgsrc = "publicimages/thumbs/" . $b->filename;
								}
							?> 
							<div class="thumbnail">
								<img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
								<div class="caption">		
									<h3 class="text-center">{{ $b->title }}</h3> <br/>
									<p class="text-center">{{ $b->description }}</p><br/>
									<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-image3" role="button">Add</a></p>
								</div> 
							</div>
						</div>
					@endforeach				
				</div>
			@else 
				<div class="row"><center><h3>No photo uploaded yet. Please click <a href="{{ route('photo.add') }}">here</a> to upload one.</h3></center></div>		
			@endif
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
		  </div>
		</div>
	  </div>
	</div>

	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="photo3" class="col-sm-3 control-label">Select Photo 3</label>					
				<div class="col-sm-9">						
					<div class="input-group">
					  {{ Form::text('article_image_3', null, ['class' => 'form-control', 'id' => 'photo3', 'placeholder' => 'Click the button at the right to select photo', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="selectImage3" data-toggle="popover" title="Tip" data-content="{{ $addPhotoMsg }}" type="button"><i class="fa fa-photo"></i></button>
						<button class="btn btn-default" id="clearImage3" title="Clear Photo" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_image_thumb3">
				{!! $photosrc3 !!}
			</div>
		</div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				{{ Form::label('article_videoid_3', 'Video 3', ['class' => 'col-sm-3 control-label']) }}			
				<div class="col-sm-9">			
					<div class="input-group">
					  {{ Form::text('article_videoid_3', null, ['class' => 'form-control', 'id' => 'article_videoid_3', 'placeholder' => 'Include a Video in your Article (Optional)', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="testArticleYoutube3" <?php echo $vidPop; ?> type="button"><i class="fa fa-video-camera"></i></button>
						<button class="btn btn-default" id="clearVideo3" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_video_thumb3">
				{!! $vidsrc3 !!}
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="article-content-3" class="col-sm-2 control-label pull-left">Content 3</label>
				<div class="col-sm-10">&nbsp;</div>					
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="body_3" class="col-sm-1 control-label">&nbsp;</label>
				<div class="col-sm-11">
					{{ Form::textarea('body_3', null, ['class' => 'form-control input-sm', 'id' => 'body_3', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your article here ...']) }}				
				</div>					
			</div>
		</div>
	</div>
</div>
<div id="article4" style="{{ $style4 }}">
	<input type="hidden" id="articlevideoid4" name="articlevideoid4" value="">
	<div class="modal fade" id="articleVideoModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
			<h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
		  </div>
		  <div class="modal-body">
				<div class="row">
					<center>
						<h3 id="article-video-title4"></h3>
						<p id="article-video-show4"></p>
					</center>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yid4">Enter a YouTube Video ID Code (11 characters)</label></div>			  
				</div>
				<div class="row">
					<div class="col-sm-12"><input type="text" class="form-control" id="article_yid4" placeholder="Type youtube video id code here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yurl4">Or Paste a YouTube URL (Begins with http)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><input type="text" class="form-control" id="article_yurl4" placeholder="Paste youtube url here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yembed4">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><textarea class="form-control" id="article_yembed4" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
				</div>
				<div class="row">			  
				  <div class="col-sm-12">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkArticleVideo4"><i class="fa fa-check-circle-o"></i> Check Video</button>					
					</div>
				</div>		
		  </div>
		  <div class="modal-footer">        
			<button type="button" class="btn btn-success btn-flat btn-sm" id="addArticleVideo4" data-dismiss="modal">Add</button>
			<button type="button" id="cancelArticleVideo4" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="imageModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Personal Images</h4>
		  </div>
		  <div class="modal-body">  
			@if($numOfImages > 0)
				<div class="row">			
					@foreach($photos as $b)
						<div class="col-sm-6 col-md-4">
							<?php
								$imgsrc = "images/noimage.png";
								if($b->filename != "") {
									$imgsrc = "publicimages/thumbs/" . $b->filename;
								}
							?> 
							<div class="thumbnail">
								<img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
								<div class="caption">		
									<h3 class="text-center">{{ $b->title }}</h3> <br/>
									<p class="text-center">{{ $b->description }}</p><br/>
									<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-image4" role="button">Add</a></p>
								</div> 
							</div>
						</div>
					@endforeach				
				</div>
			@else 
				<div class="row"><center><h3>No photo uploaded yet. Please click <a href="{{ route('photo.add') }}">here</a> to upload one.</h3></center></div>		
			@endif
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
		  </div>
		</div>
	  </div>
	</div>

	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="photo4" class="col-sm-3 control-label">Select Photo 4</label>					
				<div class="col-sm-9">						
					<div class="input-group">
					  {{ Form::text('article_image_4', null, ['class' => 'form-control', 'id' => 'photo4', 'placeholder' => 'Click the button at the right to select photo', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="selectImage4" data-toggle="popover" title="Tip" data-content="{{ $addPhotoMsg }}" type="button"><i class="fa fa-photo"></i></button>
						<button class="btn btn-default" id="clearImage4" title="Clear Photo" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_image_thumb4">
				{!! $photosrc4 !!}
			</div>
		</div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				{{ Form::label('article_videoid_4', 'Video 4', ['class' => 'col-sm-3 control-label']) }}			
				<div class="col-sm-9">			
					<div class="input-group">
					  {{ Form::text('article_videoid_4', null, ['class' => 'form-control', 'id' => 'article_videoid_4', 'placeholder' => 'Include a Video in your Article (Optional)', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="testArticleYoutube4" <?php echo $vidPop; ?> type="button"><i class="fa fa-video-camera"></i></button>
						<button class="btn btn-default" id="clearVideo4" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_video_thumb4">
				{!! $vidsrc4 !!}
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="article-content-4" class="col-sm-2 control-label pull-left">Content 4</label>
				<div class="col-sm-10">&nbsp;</div>					
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="body_4" class="col-sm-1 control-label">&nbsp;</label>
				<div class="col-sm-11">
					{{ Form::textarea('body_4', null, ['class' => 'form-control input-sm', 'id' => 'body_4', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your article here ...']) }}				
				</div>					
			</div>
		</div>
	</div>
</div>
<div id="article5" style="{{ $style5 }}">
	<input type="hidden" id="articlevideoid5" name="articlevideoid5" value="">
	<div class="modal fade" id="articleVideoModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
			<h4 class="modal-title" id="myModalLabel"><img src="{{ asset('images/YouTube.png') }}" class="img-responsive"></h4>
		  </div>
		  <div class="modal-body">
				<div class="row">
					<center>
						<h3 id="article-video-title5"></h3>
						<p id="article-video-show5"></p>
					</center>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yid5">Enter a YouTube Video ID Code (11 characters)</label></div>			  
				</div>
				<div class="row">
					<div class="col-sm-12"><input type="text" class="form-control" id="article_yid5" placeholder="Type youtube video id code here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yurl5">Or Paste a YouTube URL (Begins with http)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><input type="text" class="form-control" id="article_yurl5" placeholder="Paste youtube url here.."></div>
				</div>
				<div class="row">
				  <div class="col-sm-12"><label for="article_yembed5">Or a YouTube Embed Code (iFrame or Object Type)</label></div>			  
				</div>
				<div class="row">			  
				  <div class="col-sm-12"><textarea class="form-control" id="article_yembed5" rows="4" placeholder="Paster your embedded code here .."></textarea></div>
				</div>
				<div class="row">			  
				  <div class="col-sm-12">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="button" class="btn btn-primary btn-flat btn-sm" id="checkArticleVideo5"><i class="fa fa-check-circle-o"></i> Check Video</button>					
					</div>
				</div>		
		  </div>
		  <div class="modal-footer">        
			<button type="button" class="btn btn-success btn-flat btn-sm" id="addArticleVideo5" data-dismiss="modal">Add</button>
			<button type="button" id="cancelArticleVideo5" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="imageModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Personal Images</h4>
		  </div>
		  <div class="modal-body">  
			@if($numOfImages > 0)
				<div class="row">			
					@foreach($photos as $b)
						<div class="col-sm-6 col-md-4">
							<?php
								$imgsrc = "images/noimage.png";
								if($b->filename != "") {
									$imgsrc = "publicimages/thumbs/" . $b->filename;
								}
							?> 
							<div class="thumbnail">
								<img alt="Sample Photo" src="{{ asset($imgsrc) }}"> 
								<div class="caption">		
									<h3 class="text-center">{{ $b->title }}</h3> <br/>
									<p class="text-center">{{ $b->description }}</p><br/>
									<p><a id="{{ $b->filename }}" class="btn btn-primary chosen-image5" role="button">Add</a></p>
								</div> 
							</div>
						</div>
					@endforeach				
				</div>
			@else 
				<div class="row"><center><h3>No photo uploaded yet. Please click <a href="{{ route('photo.add') }}">here</a> to upload one.</h3></center></div>		
			@endif
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>        
		  </div>
		</div>
	  </div>
	</div>

	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="photo5" class="col-sm-3 control-label">Select Photo 5</label>					
				<div class="col-sm-9">
					<div class="input-group">
					  {{ Form::text('article_image_5', null, ['class' => 'form-control', 'id' => 'photo5', 'placeholder' => 'Click the button at the right to select photo', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="selectImage5" data-toggle="popover" title="Tip" data-content="{{ $addPhotoMsg }}" type="button"><i class="fa fa-photo"></i></button>
						<button class="btn btn-default" id="clearImage5" title="Clear Photo" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_image_thumb5">
				{!! $photosrc5 !!}
			</div>
		</div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				{{ Form::label('article_videoid_5', 'Video 5', ['class' => 'col-sm-3 control-label']) }}			
				<div class="col-sm-9">			
					<div class="input-group">
					  {{ Form::text('article_videoid_5', null, ['class' => 'form-control', 'id' => 'article_videoid_5', 'placeholder' => 'Include a Video in your Article (Optional)', 'readonly']) }}				  
					  <span class="input-group-btn">
						<button class="btn btn-default" id="testArticleYoutube5" <?php echo $vidPop; ?> type="button"><i class="fa fa-video-camera"></i></button>
						<button class="btn btn-default" id="clearVideo5" title="Clear Video" type="button"><i class="fa fa-remove"></i></button>
					  </span>				  
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-offset-3 col-sm-9">
			<div id="article_video_thumb5">
				{!! $vidsrc5 !!}
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="article-content-5" class="col-sm-2 control-label pull-left">Content 5</label>
				<div class="col-sm-10">&nbsp;</div>					
			</div>
		</div>
	</div>
	<div class="row">			    	
		<div class="col-sm-12">
			<div class="form-group">
				<label for="body_5" class="col-sm-1 control-label">&nbsp;</label>
				<div class="col-sm-11">
					{{ Form::textarea('body_5', null, ['class' => 'form-control input-sm', 'id' => 'body_5', 'style' => 'width: 640px; height: 640px;', 'placeholder' => 'Type your article here ...']) }}				
				</div>					
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<button type="button" class="btn btn-success" id="another-article"><i class="fa fa-plus-circle"></i> Add another content</button>		
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="logo" class="col-sm-3 control-label">Select Logo</label>					
			<div class="col-sm-9">						
				<div class="input-group">
				  {{ Form::text('article_logo', null, ['class' => 'form-control', 'id' => 'logo', 'placeholder' => 'Click the button at the right to select logo', 'readonly']) }}				  
				  <span class="input-group-btn">
					<button class="btn btn-default" id="selectLogo" data-toggle="popover" title="Tip" data-content="{{ $addLogoMsg }}" type="button"><i class="fa fa-photo"></i></button>
					<button class="btn btn-default" id="clearLogo" title="Clear Logo" type="button"><i class="fa fa-remove"></i></button>
				  </span>				  
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-offset-3 col-sm-9">
		<div id="article_logo_thumb">
			{!! $logosrc !!}
		</div>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('release_date', 'Release Article', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('release_date', $rdate, ['class' => 'form-control', 'id' => 'release_date']) }}										
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">			    	
	<div class="col-sm-12">
		<div class="form-group">
			{{ Form::label('expiry_date', 'Article Expires', ['class' => 'col-sm-3 control-label']) }}					
			<div class="col-sm-9">	
				<div class="input-group">
					{{ Form::text('expiry_date', $xdate, ['class' => 'form-control', 'id' => 'expiry_date']) }}					
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>									
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h3 class="text-green">Where to Post this Article?</h3>	
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<center>
			<label class="radio-inline">
			  <input type="radio" class="alocationtype" name="article_ltype" id="town" {{ session('townStyle') }} value="town" {{ $check1 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip1 }}"> Location <span class="badge {{ session('townbadge') }}">{{ session('townbadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="alocationtype" name="article_ltype" id="state" {{ session('stateStyle') }} value="state" {{ $check2 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip2 }}"> Entire State <span class="badge {{ session('statebadge') }}">{{ session('statebadgetext') }}</span>
			</label>
			<label class="radio-inline">
			  <input type="radio" class="alocationtype" name="article_ltype" id="country" {{ session('countryStyle') }} value="country" {{ $check3 }} data-toggle="popover" title="Tip" data-content="{{ $locationTip3 }}"> Entire Country <span class="badge {{ session('countrybadge') }}">{{ session('countrybadgetext') }}</span>
			</label>
		</center>
	</div>
</div>
<div class="row">&nbsp;</div>
<div class="row">	
	<div class="col-sm-12">
		<div class="form-group">
			<label for="artlocation" class="col-sm-3 control-label">Post To <span class="req ar-location-marker"><i class="fa fa-asterisk"></i></span></label>				
			<div class="col-sm-9">	
				<select id="artlocation" name="article_location" class="form-control input-sm">	
					@if($title == "Article Editor")
						<option value="{{ $article->article_location }}">{{ $article->article_location }}</option>						
					@endif
					{!! $locationHTML !!}					
		        </select>						
			</div>
		</div>
	</div>	
</div>
<?php else : ?>
	<div class="row">
		<div class="col-sm-12">		
			<center><h2 class="text-yellow"><i class="fa fa-warning"></i> Limit exceeded. <a href='#' id='membership'>Please Upgrade Membership</a></h2></center>	
		</div>
	</div>
<?php endif; ?>
<div class="row">			    	
	<div class="col-sm-12">
		<?php if($limit_exceeded == "no" and $restricted == "no") : ?>
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		<?php endif; ?>	
		<a href="{{ route('articles') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
	</div>
</div>
