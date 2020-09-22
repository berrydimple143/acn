<style type="text/css">
.footer-flex-container {
	display: flex;
	display: -ms-flex;
	display: -moz-flex;
	display: -webkit-flex;
	flex-wrap: wrap;
	align-items: center;
	justify-content: space-around;
	background: #003399;
}
.footer-key {
	padding-bottom:5px;
}
</style>

<div class="footer-flex-container">
  <div class="footer-key">
    <h4 align="center" class="wild-white"><strong>{{ session('location') }}</strong></h4>
  </div>
  <div class="footer-bookmarking">
    <div align="center">      
      <table width=100% border="0" align="center" cellpadding="0">
        <tr>
          <td>

          <div align="left">
            <!-- AddThis Button BEGIN -->
          </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="footer-menu">
    <nav class="bottomnav"> 
      <div align="center" class="minimenu">
        <a href="/Terms-of-use.php">Terms of use</a> <a href="/Privacy-Policy.php">Privacy Policy</a>
      </div>
    </nav>
  </div>
</div>
<div align="center"> <img title="The Australian Regional Network"
     style="WIDTH: 100%"
     border="0"
     alt="The Australian Regional Network"
     src="{{ asset('images/Australian-Regional-Network.png') }}"> </div>
@if($title == "Advertisement Show Page" || $title == "Community Advertisement Creator" || $title == "National Event Editor" || $title == "Business Event Editor" || $title == "Community Event Editor" || $title == "National Event Creator" || $title == "Business Event Creator" || $title == "Community Event Creator" || $title == "Commercial Advertisement Creator" || $title == "Commercial Advertisement Editor" || $title == "Community Advertisement Editor")
	@include('partials.admin.map')
@endif
@if($title == "Banner Maker Upload")
	<script src="{{ asset('js/canvas.js') }}"></script>
@endif
<script>
$(function() {	
	var admap = $('#admap').val() + "";	
	var customer_password = $('#customer_password').val() + "";
	var customer_email = $('#customer_email').val() + "";
	var customer_title = $('#customer_title').val() + "";
	var customer_tax_id = $('#customer_tax_id').val() + "";
	var customer_businessname = $('#customer_businessname').val() + "";
	var customer_state = $('#customer_state').val() + "";
	var sub = $('#articles-form #subject').val() + "";	
	var desc = $('#articles-form #description').val() + "";
	var cat = $('#articles-form #category').val() + "";
	var loc = $('#articles-form #artlocation').val() + "";			
	var dir = $('#ads-form #directory').val() + "";	
	var cat2 = $('#ads-form #category').val() + "";
	var ban = $('#ads-form #ad_banner').val() + "";
	var bname = $('#ads-form #businessname').val() + "";
	$("#card-info").hide();
	toggleMap(admap);	
	toggleArticleRequired(cat, sub, desc, loc);
	toggleAdsRequired(dir, cat2, ban, bname);
	toggleSettings(customer_email, customer_password, customer_title, customer_tax_id, customer_businessname, customer_state);
	toggleAdHint('default');	
	toggleEventHint('located');
	$("#ads-form").keyup(function() {
		var dir = $('#ads-form #directory').val() + "";	
		var cat2 = $('#ads-form #category').val() + "";
		var ban = $('#ads-form #ad_banner').val() + "";
		var bname = $('#ads-form #businessname').val() + "";	
		toggleAdsRequired(dir, cat2, ban, bname);
	});
	$("#ads-form #directory").change(function() {
		var dir = $(this).val() + "";
		var cat2 = $('#ads-form #category').val() + "";
		var ban = $('#ads-form #ad_banner').val() + "";
		var bname = $('#ads-form #businessname').val() + "";	
		toggleAdsRequired(dir, cat2, ban, bname);
	});		
	$("#ads-form #category").change(function() {
		var dir = $('#ads-form #directory').val() + "";
		var cat2 = $(this).val() + "";
		var ban = $('#ads-form #ad_banner').val() + "";
		var bname = $('#ads-form #businessname').val() + "";	
		toggleAdsRequired(dir, cat2, ban, bname); 
	});
	$("#account-settings-form").keyup(function() {
	 	var cp = $('#customer_password').val() + "";
		var cm = $('#customer_email').val() + "";	
		var ct = $('#customer_title').val() + "";
		var ctax = $('#customer_tax_id').val() + "";
		var cb = $('#customer_businessname').val() + "";
		var cs = $('#customer_state').val() + "";
		toggleSettings(cm, cp, ct, ctax, cb, cs);     
	});
	$("#articles-form").keyup(function() {
		var sub = $('#subject').val() + "";	
		var desc = $('#description').val() + "";
		var cat = $('#category').val() + "";
		var loc = $('#artlocation').val() + "";	
		toggleArticleRequired(cat, sub, desc, loc);     
	});	
	$("#articles-form #category").change(function() {
		var sub = $('#subject').val() + "";	
		var desc = $('#description').val() + "";	
		var cat = $(this).val() + "";
		var loc = $('#artlocation').val() + "";
		toggleArticleRequired(cat, sub, desc, loc); 
	});		
	$("#articles-form #artlocation").change(function() {
		var sub = $('#subject').val() + "";	
		var desc = $('#description').val() + "";	
		var cat = $('#category').val() + "";
		var loc = $(this).val() + "";
		toggleArticleRequired(cat, sub, desc, loc); 
	});		
    $('#ads-table').DataTable({
        processing: true,
        serverSide: true,
		responsive: true,
        ajax: '{!! route("ads.information") !!}',
        columns: [
            { data: 'ad_id', name: 'ad_id' },
            { data: 'ad_portal', name: 'ad_portal' },            
            { data: 'ad_directory', name: 'ad_directory' },
            { data: 'ad_category', name: 'ad_category' },
			{ data: 'ad_status', name: 'ad_status', orderable: false, searchable: false },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });	
	$('#lists-table').DataTable({
        processing: true,
        serverSide: true,
		responsive: true,
        ajax: '{!! route("lists.information") !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', name: 'created_at' },            
            { data: 'updated_at', name: 'updated_at' },
            { data: 'name', name: 'name' },			
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });	
	$('#payments-table').DataTable({
        processing: true,
        serverSide: true,
		responsive: true,
        ajax: '{!! route("paypal.data") !!}',
        columns: [
            { data: 'date_paid', name: 'date_paid' },
            { data: 'customer_level', name: 'customer_level' },            
            { data: 'period', name: 'period' },            
			{ data: 'AMT', name: 'AMT' },			
            { data: 'payment_status', name: 'payment_status' }
        ]
    });	
    $('#artable').DataTable({
        processing: true,
        serverSide: true,
		responsive: true,
        ajax: '{!! route("articles.information") !!}',
        columns: [            
            { data: 'subject', name: 'subject' },
            { data: 'article_location', name: 'article_location' },
			{ data: 'category', name: 'category' },            
            { data: 'article_status', name: 'article_status', orderable: false, searchable: false },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    $('#events-table').DataTable({
        processing: true,
        serverSide: true,
		responsive: true,
        ajax: '{!! route("events.information") !!}',
        columns: [
            { data: 'event_id', name: 'event_id' },
            { data: 'event_name', name: 'event_name' },
            { data: 'event_start', name: 'event_start' },
            { data: 'event_stop', name: 'event_stop' },
            { data: 'event_status', name: 'event_status' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
	$('#nomap').click(function() {
		if($(this).is(":checked")) {
			$("#map-container").hide();
		} else {
			$("#map-container").show();
		}
	});
	$('#fb-button').click(function() {
		var id = $("#customer_facebook").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#twitter-button').click(function() {
		var id = $("#customer_twitter").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#linkedin-button').click(function() {
		var id = $("#customer_linkedin").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#pw-button').click(function() {
		var id = $("#customer_pwebsite").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#cw-button').click(function() {
		var id = $("#customer_cwebsite").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#bw-button').click(function() {
		var id = $("#customer_bwebsite").val() + "";
		if(id != "") {
			window.open(id, '_blank');
		}
	});
	$('#another-article').click(function() {
		var ac = $('#article_counter').val();	
		var acntr = parseInt(ac); 
		if(acntr == 1) {
			$("#article2").show();
			$('#article_counter').val(2);
		} else if(acntr == 2) {
			$("#article3").show();
			$('#article_counter').val(3);
		} else if(acntr == 3) {
			$("#article4").show();
			$('#article_counter').val(4);
		} else if(acntr == 4) {
			$("#article5").show();
			$('#article_counter').val(5);
			$("#another-article").attr("disabled", true);
		}
	});
	$('#release_date, #expiry_date, #event_start, #event_stop').datepicker({
		dateFormat: 'dd/mm/yy'
	});
	$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
		event.preventDefault(); 
		event.stopPropagation(); 
		$(this).parent().siblings().removeClass('open');
		$(this).parent().toggleClass('open');
	});
	$('#fb-btn, #twitter-btn, #linkedin-btn').click(function() {
		window.location = "{{ route('profile') }}";
	});	
	$('#bimgupload').click(function() {
		window.location = "{{ route('banner.maker.upload', ['type' => 'image']) }}";
	});
	$('#bsquare').click(function() {
		window.location = "{{ route('banner.maker.upload', ['type' => 'box']) }}";	
	});
	$('.showPhotosModal').click(function() {
		var id = $(this).attr('id');		
		$("#dummyid").val(id);
		$('#photosModal').modal('show');		
	});	
	$('.proceedMove').click(function() {
		var id = $("#dummyid").val() + "";
		$.get("{{ url('move') }}/now?id=" + id, function(data) {
            window.location = data.newrt;			
        });		
	});		
	$('.removeGallery').click(function() {
		var id = $("#dummyid").val() + "";
		$.get("{{ url('remove') }}/now?id=" + id, function(data) {
            window.location = "{{ route('photos') }}";			
        });		
	});		
	$('#validateMobile').click(function() {
		var stat = $(this).attr('class');
		if(stat == "btn btn-danger") {
			window.location = "{{ route('admin.mobile') }}";
		} else {
			window.location = "{{ route('settings') }}";
		}
	});
	$('#validateMobileText').click(function() {
		window.location = "{{ route('admin.mobile') }}";		
	});
	$('#validateEmailText').click(function() {
		window.location = "{{ route('validate.email') }}";		
	});
	$('#validateEmail').click(function() {
		var stat = $(this).attr('class');
		if(stat == "btn btn-danger") {
			window.location = "{{ route('validate.email') }}";
		} else {
			window.location = "{{ route('settings') }}";
		}
	});	
	$('#cancelDeleteAccount').click(function() {
		window.location = "{{ route('admin.cancel.delete') }}";		
	});	
	function toggleMap(nmap) {
		if(nmap == "no") {
			$("#map-container").hide();
		} else {
			$("#map-container").show();
		}
	}
	function toggleSettings(email, password, title, tax, business, state) {
		$(".password-marker").show();
		$(".email-marker").show();
		$(".title-marker").show();
		$(".tax-marker").show();
		$(".businessname-marker").show();
		$(".state-marker").show();
		if(email != "") { $(".email-marker").hide(); }
		if(password != "") { $(".password-marker").hide(); }		
		if(title != "") { $(".title-marker").hide(); }
		if(tax != "") { $(".tax-marker").hide(); }
		if(business != "") { $(".businessname-marker").hide(); }
		if(state != "") { $(".state-marker").hide(); }
	}
	function toggleArticleRequired(cat, sub, desc, loc) {
		$(".ar-category-marker").show();
		$(".ar-title-marker").show();
		$(".ar-description-marker").show();
		$(".ar-location-marker").show();		
		if(cat != "") { $(".ar-category-marker").hide(); }
		if(sub != "") { $(".ar-title-marker").hide(); }		
		if(desc != "") { $(".ar-description-marker").hide(); }
		if(loc != "") { $(".ar-location-marker").hide(); }		
	}
	function toggleAdsRequired(dir, cat, ban, bname) {
		$(".directory-marker").show();
		$(".category-marker").show();
		$(".banner-marker").show();
		$(".businessname-marker").show();		
		if(dir != "") { $(".directory-marker").hide(); }
		if(cat != "") { $(".category-marker").hide(); }
		if(ban != "") { $(".banner-marker").hide(); }
		if(bname != "") { $(".businessname-marker").hide(); }
	}
	$('#testYoutube').click(function() {		
		$('#videoModal').modal('show');        
	});	
	$('#checkVideo').click(function() {
		var code = $('#youtubeid').val() + "";
		var URL = $('#youtubeurl').val() + "";
		var embed = $('#youtubeembed').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {					
			$.post("{{ url('ads/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){								
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#videoid').val(vid);
				$("#youtube-video-show").html(result.content);
				$("#youtube-video-title").html(title);
			});			
		}
	});
	$('#angle').change(function() {
		var angle = $(this).val() + "";		
		var filename = $('#filename').val() + "";
		var ext = $('#ext').val() + "";
		if(angle == "") {
			alert("Please select an angle first.");
		} else {
			$.post("{{ url('portrait/angle') }}", { angle: angle, filename: filename, ext: ext, _token: '{{ csrf_token() }}' }, function(result){												
				var fn = result.filename;
				var imgsrc = "/publicimages/portraits/" + fn;
				$('#imghandler').empty();
				$('#imghandler').append('<img src="' + imgsrc + '" width="' + result.width + '" height="' + result.height + '" alt="Banner Placeholder" class="img-thumbnail img-responsive center-block">');
				$('#filename').val(fn);
				$('#cancelBtn').empty();
				$('#cancelBtn').append(result.btn);
			}); 
		}
	});
	$("#agree").click(function() {
		$('#termsModal').modal('show');
	});		
	$('#testArticleYoutube').click(function() {					
		$('#articleVideoModal').modal('show');        
	});	
	$('#testArticleYoutube2').click(function() {					
		$('#articleVideoModal2').modal('show');        
	});	
	$('#testArticleYoutube3').click(function() {					
		$('#articleVideoModal3').modal('show');        
	});
	$('#testArticleYoutube4').click(function() {					
		$('#articleVideoModal4').modal('show');        
	});
	$('#testArticleYoutube5').click(function() {					
		$('#articleVideoModal5').modal('show');        
	});
	$('#checkArticleVideo').click(function() {
		var code = $('#article_yid').val() + "";
		var URL = $('#article_yurl').val() + "";
		var embed = $('#article_yembed').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('article/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#articlevideoid').val(vid);
				$("#article-video-show").html(result.content);
				$("#article-video-title").html(title);
			});
		}
	});		
	$('#checkArticleVideo2').click(function() {
		var code = $('#article_yid2').val() + "";
		var URL = $('#article_yurl2').val() + "";
		var embed = $('#article_yembed2').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('article/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#articlevideoid2').val(vid);
				$("#article-video-show2").html(result.content);
				$("#article-video-title2").html(title);
			});
		}
	});	
	$('#checkArticleVideo3').click(function() {
		var code = $('#article_yid3').val() + "";
		var URL = $('#article_yurl3').val() + "";
		var embed = $('#article_yembed3').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('article/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#articlevideoid3').val(vid);
				$("#article-video-show3").html(result.content);
				$("#article-video-title3").html(title);
			});
		}
	});
	$('#checkArticleVideo4').click(function() {
		var code = $('#article_yid4').val() + "";
		var URL = $('#article_yurl4').val() + "";
		var embed = $('#article_yembed4').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('article/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#articlevideoid4').val(vid);
				$("#article-video-show4").html(result.content);
				$("#article-video-title4").html(title);
			});
		}
	});
	$('#checkArticleVideo5').click(function() {
		var code = $('#article_yid5').val() + "";
		var URL = $('#article_yurl5').val() + "";
		var embed = $('#article_yembed5').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('article/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#articlevideoid5').val(vid);
				$("#article-video-show5").html(result.content);
				$("#article-video-title5").html(title);
			});
		}
	});
	$("#addArticleVideo, #cancelArticleVideo").click(function() {
		var vid = $('#articlevideoid').val() + "";	
		$("#article-video-show").html('');
        $("#article-video-title").html('');
		$('#article_videoid').val(vid);
		if(vid != '') {
			var src = 'https://img.youtube.com/vi/' + vid + '/0.jpg';
			$('#article_video_thumb').append('<img src="' + src + '" class="img-responsive">');
		}
	});	
	$("#addArticleVideo2, #cancelArticleVideo2").click(function() {
		var vid = $('#articlevideoid2').val() + "";	
		$("#article-video-show2").html('');
        $("#article-video-title2").html('');
		$('#article_videoid_2').val(vid);
		if(vid != '') {
			var src = 'https://img.youtube.com/vi/' + vid + '/0.jpg';
			$('#article_video_thumb2').append('<img src="' + src + '" class="img-responsive">');
		}
	});	
	$("#addArticleVideo3, #cancelArticleVideo3").click(function() {
		var vid = $('#articlevideoid3').val() + "";	
		$("#article-video-show3").html('');
        $("#article-video-title3").html('');
		$('#article_videoid_3').val(vid);	
		if(vid != '') {
			var src = 'https://img.youtube.com/vi/' + vid + '/0.jpg';
			$('#article_video_thumb3').append('<img src="' + src + '" class="img-responsive">');
		}
	});
	$("#addArticleVideo4, #cancelArticleVideo4").click(function() {
		var vid = $('#articlevideoid4').val() + "";	
		$("#article-video-show4").html('');
        $("#article-video-title4").html('');
		$('#article_videoid_4').val(vid);
		if(vid != '') {
			var src = 'https://img.youtube.com/vi/' + vid + '/0.jpg';
			$('#article_video_thumb4').append('<img src="' + src + '" class="img-responsive">');
		}
	});
	$("#addArticleVideo5, #cancelArticleVideo5").click(function() {
		var vid = $('#articlevideoid5').val() + "";	
		$("#article-video-show5").html('');
        $("#article-video-title5").html('');
		$('#article_videoid_5').val(vid);
		if(vid != '') {
			var src = 'https://img.youtube.com/vi/' + vid + '/0.jpg';
			$('#article_video_thumb5').append('<img src="' + src + '" class="img-responsive">');
		}
	});
	$('#selectBanner').click(function() {       
        $('#bannerModal').modal('show');       
	});
	$('#selectBannerEvent').click(function() {       
        $('#bannerModalEvent').modal('show');       
	});
	$('#selectImage').click(function() {       
        $('#imageModal').modal('show');       
	});
	$('#clearImage').click(function() {
        $('#photo').val('');
		$("#article_image_thumb").empty();
	});
	$('#clearLogo').click(function() {
        $('#logo').val('');
		$("#article_logo_thumb").empty();
	});
	$('#clearEventBanner').click(function() {
        $('#event_banner').val('');
		$("#event_banner_thumb").empty();
	});
	$('#clearAdsBanner').click(function() {
        $('#ad_banner').val('');
		$("#ads_banner_thumb").empty();
	});
	$('#clearEventVideo').click(function() {
        $('#event_videoid').val('');
		$("#event_video_thumb").empty();
	});
	$('#clearAdsVideo').click(function() {
        $('#ad_videoid').val('');
		$("#ads_video_thumb").empty();
	});
	$('#clearVideo').click(function() {
        $('#article_videoid').val('');
		$("#article_video_thumb").empty();
	});
	$('#clearVideo2').click(function() {
        $('#article_videoid_2').val('');
		$("#article_video_thumb2").empty();
	});
	$('#clearVideo3').click(function() {
        $('#article_videoid_3').val('');
		$("#article_video_thumb3").empty();
	});
	$('#clearVideo4').click(function() {
        $('#article_videoid_4').val('');
		$("#article_video_thumb4").empty();
	});
	$('#clearVideo5').click(function() {
        $('#article_videoid_5').val('');
		$("#article_video_thumb5").empty();
	});
	$('#selectImage2').click(function() {       
        $('#imageModal2').modal('show');       
	});
	$('#clearImage2').click(function() {
        $('#photo2').val('');
	});
	$('#selectImage3').click(function() {       
        $('#imageModal3').modal('show');       
	});
	$('#clearImage3').click(function() {
        $('#photo3').val('');
	});
	$('#selectImage4').click(function() {       
        $('#imageModal4').modal('show');       
	});
	$('#clearImage4').click(function() {
        $('#photo4').val('');
	});
	$('#selectImage5').click(function() {       
        $('#imageModal5').modal('show');       
	});
	$('#clearImage5').click(function() {
        $('#photo5').val('');
	});
	$('#selectPhoto').click(function() {       
        $('#photoModal').modal('show');       
	});
	$('#selectLogo').click(function() {       
        $('#logoModal').modal('show');       
	});	
	$("#addVideo, #cancelVideo").click(function() {
		var vid = $('#videoid').val() + "";	
		$("#youtube-video-show").html('');
        $("#youtube-video-title").html('');
		$('#ad_videoid').val(vid);
		if(vid != '') {		
			$('#ads_video_thumb').empty();
			$('#ads_video_thumb').append('<img src="https://img.youtube.com/vi/' + vid + '/0.jpg" class="img-responsive" width="180" height="130">');
		}
	});		
	$('#testYoutubeEvent').click(function() {						
		$('#videoModalEvent').modal('show');        
	});	
	$('#checkEventVideo').click(function() {
		var code = $('#event_yid').val() + "";
		var URL = $('#event_yurl').val() + "";
		var embed = $('#event_yembed').val() + "";		
		if(code == "" && URL == "" && embed == "") {
			alert("You must provide something in the form field.");
		} else {
			$.post("{{ url('event/video/check') }}", { code: code, URL: URL, embed: embed, _token: '{{ csrf_token() }}' }, function(result){
				var vid = result.videoid;
				var title = "Video ID: " + vid;
				$('#eventvideoid').val(vid);
				$("#event-video-show").html(result.content);
				$("#event-video-title").html(title);
			});
		}
	});		
	$("#addEventVideo, #cancelEventVideo").click(function() {
		var vid = $('#eventvideoid').val() + "";	
		$("#event-video-show").html('');
        $("#event-video-title").html('');
		$('#event_videoid').val(vid);
		if(vid != '') {		
			$('#event_video_thumb').empty();
			$('#event_video_thumb').append('<img src="https://img.youtube.com/vi/' + vid + '/0.jpg" class="img-responsive" width="180" height="130">');
		}
	});		
	$(".chosen-banner").click(function(){
		var f = $(this).attr("id");
		$('#ad_banner').val(f);
		if(f != '') {	
			var ps = '<img src="/publicimages/banners/' + f + '" class="img-responsive" width="180" height="130">';
			$('#ads_banner_thumb').empty();	
			$('#ads_banner_thumb').append(ps);
		}
		$('#bannerModal').modal('hide');  
	});
	$(".chosen-banner-event").click(function(){
		var f = $(this).attr("id");
		$('#event_banner').val(f);
		if(f != '') {	
			var ps = '<img src="/publicimages/banners/' + f + '" class="img-responsive" width="180" height="130">';
			$('#event_banner_thumb').empty();	
			$('#event_banner_thumb').append(ps);
		}
		$('#bannerModalEvent').modal('hide');  
	});
	$(".chosen-logo").click(function(){
		var f = $(this).attr("id");
		$('#logo').val(f);
		if(f != '') {			
			var ps = '<img src="/publicimages/logos/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_logo_thumb').empty();	
			$('#article_logo_thumb').append(ps);
		}
		$('#logoModal').modal('hide');  
	});
	$(".chosen-photo").click(function(){
		var f = $(this).attr("id");
		$('#photo').val(f);
		$('#photoModal').modal('hide');  
	});
	$(".chosen-image").click(function(){
		var f = $(this).attr("id");
		$('#photo').val(f);
		if(f != '') {			
			var ps = '<img src="/publicimages/large_images/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_image_thumb').empty();	
			$('#article_image_thumb').append(ps);
		}
		$('#imageModal').modal('hide');  
	});
	$(".chosen-image2").click(function(){
		var f = $(this).attr("id");
		$('#photo2').val(f);
		if(f != '') {
			var ps = '<img src="/publicimages/large_images/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_image_thumb2').empty();	
			$('#article_image_thumb2').append(ps);
		}
		$('#imageModal2').modal('hide');  
	});
	$(".chosen-image3").click(function(){
		var f = $(this).attr("id");
		$('#photo3').val(f);
		if(f != '') {
			var ps = '<img src="/publicimages/large_images/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_image_thumb3').empty();	
			$('#article_image_thumb3').append(ps);
		}
		$('#imageModal3').modal('hide');  
	});
	$(".chosen-image4").click(function(){
		var f = $(this).attr("id");
		$('#photo4').val(f);
		if(f != '') {
			var ps = '<img src="/publicimages/large_images/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_image_thumb4').empty();	
			$('#article_image_thumb4').append(ps);
		}
		$('#imageModal4').modal('hide');  
	});
	$(".chosen-image5").click(function(){
		var f = $(this).attr("id");
		$('#photo5').val(f);
		if(f != '') {
			var ps = '<img src="/publicimages/large_images/' + f + '" class="img-responsive" width="480" height="auto">';
			$('#article_image_thumb5').empty();	
			$('#article_image_thumb5').append(ps);
		}
		$('#imageModal5').modal('hide');  
	});
	$("#directory").change(function() {
        var dir = $(this).val() + "";
        $.get("{{ url('ads') }}/category?dir=" + dir, function(data) {			
            $('#category').empty();		
			for(var i=0; i < data.length; i++) {				
				$('#category').append('<option value="' + data[i].category + '">' + data[i].category + '</option>');
			}            
        });
    });
	$("#payment_type").change(function() {
        var type = $(this).val() + "";			
        $("#card-info").hide();
		if(type == "creditcard") {
			$("#card-info").show();
		} 
    });
	$("#stateportal").change(function() {
        var state = $(this).val() + "";			
        $.get("{{ url('state') }}/regions?state=" + state, function(data) {			
            $('#regionportal').empty();		
			for(var i=0; i < data.length; i++) {	
				var temploc = data[i].location;
				var ml = temploc.replace("-", " ");
					ml = ml.replace("-ACT", "");
					ml = ml.replace(" ACT", "");					
					ml = ml.replace("-VIC-NSW", "");
					ml = ml.replace(" VIC-NSW", "");
					ml = ml.replace("-QLD-NSW", "");
					ml = ml.replace(" QLD-NSW", "");
					ml = ml.replace("-NSW", "");
					ml = ml.replace(" NSW", "");
					ml = ml.replace("-NT", "");
					ml = ml.replace(" NT", "");
					ml = ml.replace("-QLD", "");
					ml = ml.replace(" QLD", "");					
					ml = ml.replace("-SA", "");
					ml = ml.replace(" SA", "");
					ml = ml.replace("-TAS", "");
					ml = ml.replace(" TAS", "");
					ml = ml.replace("-VIC", "");
					ml = ml.replace(" VIC", "");
					ml = ml.replace("-WA", "");
					ml = ml.replace(" WA", "");
				$('#regionportal').append('<option value="' + data[i].domainname + '">' + ml + '</option>');
			}            
        });
    });	
	$("#gotoportal").click(function() {
		var region = $('#regionportal').val() + "";			
		if(region == ""){
			alert("Please select a state first and then a region.");				
		} else {				
			$.get("{{ url('goto') }}/region?region=" + region, function(data) {					
				if(data.status == "success") {		
					var viewbg = data.viewbg;					
					if(viewbg == "") { viewbg = "commonimages/backgrounds/default/default.jpg"; }
					window.location = "{{ url('/') }}/?loc=" + data.loc + "&url=" + data.url + "&viewbg=" + viewbg;
				} else {
					alert("Domain Name not found.");
				}				
			});		
		}
	});
	$("#movehere").click(function() {			
		var loc = "{{ session('location') }}";
		var url = "{{ session('url') }}";
		var bg = "{{ session('runningbg') }}";
		$.get("{{ url('move') }}/portal?portal=" + loc, function(data) {
			window.location = "{{ url('/') }}/?loc=" + loc + "&url=" + url + "&viewbg=" + bg;
		});
	});
	$("#deleteAccount").click(function() {			
		window.location = "{{ route('delete.account') }}";	
	});
	$("#gohome").click(function() {		
		var homeportal = $('#homeportal').val() + "";		
		$.get("{{ url('back') }}/home?portal=" + homeportal, function(data) {				
			var url = "{{ session('url') }}";
			var bg = "{{ session('runningbg') }}";
			window.location = "{{ url('/') }}/?loc=" + homeportal + "&url=" + url + "&viewbg=" + bg;
		});		
	});
	$(".locationtype").click(function() {
        var ltype = $(this).attr('id');
		var adtype = $('#adtype').val() + "";
        $.get("{{ url('ads') }}/location?ltype=" + ltype + "&adtype=" + adtype, function(data) {	        			
            $('#postlocation').empty();		
			$('#postlocation').append(data);			            
        });
    });
	$(".event_locationtype").click(function() {
        var ltype = $(this).attr('id');
		var evtype = $('#evtype').val() + "";
        $.get("{{ url('event') }}/location?ltype=" + ltype + "&evtype=" + evtype, function(data) {			
            $('#event_portal').empty();		
			$('#event_portal').append(data);			            
        });
    });
    $(".alocationtype").click(function() {
        var ltype = $(this).attr('id');
		var mode = "search";
        $.get("{{ url('art') }}/location?ltype=" + ltype + "&mode=" + mode, function(data) {	        		
            $('#artlocation').empty();		
			$('#artlocation').append(data);			            
        });
    });	
	$("#category_add").click(function() {
        var dir = $('#directory').val() + "";
		if(dir == "") {
			alert("You must select a directory first.");				
		} else {
			var category = prompt("Please enter a category: ","");                 
			if (category === null) {
				return; 
			} else if(category == ""){
				alert("Category must not be empty.");
			} else { 
				category = $.trim(category);        
				category = category.replace(/\s{2,}/g, ' ');
				category = toTitleCase(category);                        
				category = category.replace(' And ', ' and '); 
				var reg_category = /^[a-zA-Z ]*$/;
				var valid_ex = reg_category.test(category);  
				if(parseInt(category.length) > 50) {
					alert("Category must not be more than 50 characters long.");
				} else if(!valid_ex || valid_ex == false){
					alert("Category must contain letters and spaces only."); 
				} else {
					$.post("{{ url('check/category') }}", { category: category, dir: dir, _token: '{{ csrf_token() }}' }, function(result){
						var stat = result.stat;
						if(stat == "found") {
							alert('This category already exist.');
						} else {
							var cat_opt = $("#category").html();
							var cat_opt2 = "<option value='" + category + "'>" + category + "</option>";
							$("#category").empty();
							$("#category").html(cat_opt);
							$("#category").prepend(cat_opt2);
							alert('Category added successfully in the database.');							
						}
					});
				}
			}
		}
    });
	$('#reset_hint, .businesstype, #testArticleYoutube, #testArticleYoutube2, #testArticleYoutube3, #testArticleYoutube4, #testArticleYoutube5, #selectLogo, #selectImage, #selectImage2, #selectImage3, #selectImage4, #selectImage5, #banner-display, .locationtype, #category_add, .event_locationtype, .alocationtype, #hint1, #hint2, #hint3, #hint4, #hint5, #hint6, #content-info, .event_type').popover({
		trigger: 'hover',
		html: true,
		placement: 'top',
		template: '<div class="popover ads-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	});	
	$('.btn-app-popup').popover({
		trigger: 'hover',
		html: true,
		placement: 'right',
		template: '<div class="popover ads-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	});	
	$(".businesstype").click(function() {	
		var bType = $(this).attr('id');
		toggleAdHint(bType);			
	});	
	$(".event_type").click(function() {	
		var evType = $(this).attr('id');
		toggleEventHint(evType);			
	});	
	$('#ad_content, #body, #body_2, #body_3, #body_4, #body_5, #event_content').redactor({
		buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist',
		'outdent', 'indent', '|', 'table', '|', 'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule'],
		formatting: ['p', 'blockquote', 'pre', 'h2', 'h3', 'h4'],
		minHeight: 300,
		maxHeight: 500,
		plugins: ['table','fontcolor'],
		linkNofollow: true
	});		
	function toggleEventHint(h) {		
		$("#hint4").hide();
		$("#hint5").hide();
		$("#hint6").hide();
		if(h == 'located') {
			$("#hint4").show();
		} else if(h == 'observed') {
			$("#hint5").show();
		} else {
			$("#hint6").show();
		}
	}	
	function toggleAdHint(h) {
		$("#defHint").hide();
		$("#hint1").hide();
		$("#hint2").hide();
		$("#hint3").hide();
		if(h == 'default') {
			$("#defHint").show();
		} else if(h == 'located') {
			$("#hint1").show();
		} else if(h == 'services') {
			$("#hint2").show();
		} else {
			$("#hint3").show();
		}
	}
	function toTitleCase(str) {
		return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
	}	
});
</script>