@extends('layouts.admin')
@section('title', $title)
@section('content')
<meta http-equiv="refresh" content="60;url=https://login.ausreg.net/index.php" />
<div class="panel panel-default">  
  <div class="panel-body">		
	  <h2 align="center"><img title="The Australian Regional Network"
		 style="WIDTH: 100%"
		 border="0"
		 alt="The Australian Regional Network"
		 src="{{ asset('images/Australian-Regional-Network.png') }}"></h2>
	  <h2 align="center"><img title="Thankyou"
		 style="HEIGHT: 229px; WIDTH: 235px"
		 border="0"
		 alt="Thankyou"
		 src="{{ asset('images/smile.png') }}"></h2>
	  <h2 align="center">Thank you!</h2>
	  <p align="center"><strong>You should receive an email with Receipt from PayPal<br>
		</strong>
		<br>
		<strong>You can access </strong><a style="COLOR: ; TEXT-DECORATION: underline"
	   href="http://www.paypal.com/au"
	   rel="nofollow"
	   target="_blank"><strong>www.paypal.com/au</strong></a> <strong>to view your subscription</strong></p>
	  <p align="center"><strong>We are waiting for PayPal's servers to send us a confirmation<br><br>
		Please wait about 1 minute while we prepare your account</strong></p>
	  <p align="center"><img title="Please wait about 1 Minute"
		 style="HEIGHT: 77px; WIDTH: 173px"
		 border="0"
		 alt="Please wait about 1 Minute"
		 src="{{ asset('images/1-min-timer.gif') }}"></p>
	  <p align="center"><strong>then</strong></p>
	  <h2 align="center"><a href="https://login.ausreg.net/index.php">Refresh the page</a></h2><br>    
	  <h3 align="center">If you have any problems or need help do<br><a href="Contact-us.php">Contact Us</a></h3>
	  <br>
	  <p align="center"><img title="4ustralia.com" border="0" style="width:100%;max-width:321px" alt="4ustralia.com" src="{{ asset('images/4ustralia.png') }}" /><strong>Pty Ltd</strong></p>
	  <h3 align="center">"4&nbsp;you 4&nbsp;us 4ustralia.com"<br>
		Building the Australian Regional Network</h3>
	  <p align="center"><strong>Is a True Blue Australian business developed and owned by the Hill family
		of Alice Springs, Outback Central Australia, Melbourne Australia, and NSW Central Coast.</strong></p>
	  <br>
	  <p align="center">&nbsp;<img title="Flag"
		 style="HEIGHT: 62px; WIDTH: 119px"
		 border="0"
		 alt="Flag"
		 src="{{ asset('images/flag.gif') }}"></p>
  </div> 
</div>
@endsection