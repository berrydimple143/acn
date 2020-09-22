@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <center><img src="{{ asset('images/Australian-Regional-Network.png') }}" id="nationalbusiness-focus" width="640" height="56" alt="Australian Regional Network"></center>   
  </div>
  <div class="panel-body">					
		@if(isset($postdecrypt))
			Decrypted Key is set <br>	
		@endif	
		@if($sponsor_result == "Not Found")
			<script>
				$("a[href=\'#top\']").click(function() {
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				});
			</script>			
			<br><br><br><br><h2 align="center">Key is not valid</h2><br>
		@endif		
		<br>This key was issued by Member {{ $sponsor }}				
		<br>This key was generated on {{ $keyepochtime }}
		<br>		
		This key is {{ $epochday }} days old<br>
		@if($epochday < 32)
			This key date is valid
		@endif			
		@if($result != "Not Found") 
			<font color="FF0000"><h3>
			You have already registered this agreement<br>
			Please wait till we process it for you
			</h3></font><br>
		@endif		
		@if($stored)			
			<br> Registered Agreement Number = {{ $agreement }}
			<br> Sponsors key = {{ $getkey }}
			<br> Sponsor = {{ $sponsor }}
			<br> Sponsoree = {{ $sponsoree }}
			<br> Status = {{ $status }} <br>			
			<font color="FF0000"><h3>
			You have registered your agreement with QUERY SPONSOR NAME<br>
			We will verify and upgrade your account shortly
			</h3></font><br>		
		@else
			Database Failed
		@endif	
  </div> 
</div>
@endsection