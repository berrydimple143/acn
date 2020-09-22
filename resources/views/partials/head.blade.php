<title>{{ session('localname') }} - Login</title>
<meta NAME="Keywords" Content='{{ session("localname") }},Login'>
@if($title == "Mobile Page" or $title == "Code Area" or $title == "Tell a friend Page" or $title == "Tell a friend successful" or $title == "Password Reset Page")
	<meta name="robots" content="no index, no follow" />
@endif
<meta NAME="Description" Content='{{ session("localname") }} - ACN - Login'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">
window.onorientationchange = function() { window.location.reload(); };
</script>
<?php
	$bgurl = '/' . $runningbg;
	if($runningbg == "") { $bgurl = "/commonimages/backgrounds/default/default.jpg"; }
?>
<style>	
@media (max-width: 960px) {
    body {		
        background-color:#619eff;!important;
    }
}
@media (min-width: 200px) {
	html { 
		background: url({{ $bgurl }}) no-repeat top center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
}
</style>
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-dropdownhover.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/networkmenu.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('css/colors.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('css/components.css') }}">
<link href="{{ asset('css/800below.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/pushy.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/fontselect.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/colorpicker.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('outdatedbrowser/outdatedbrowser.min.css') }}">
<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<?php 
	$robotsnoindex = '';
	if ($robotsnoindex == "TRUE") {		
		echo '<meta name="robots" content="noindex">';
	} 
?>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<link rel="alternate" href='{{ session("currentpageurl") }}' hreflang="en-au" />
<meta property="og:title" content="Check this out!"/> 
<meta property="og:type" content="article"/>
<meta property="og:url" content='{{ session("currentpageurl") }}'/> 
<meta property="og:image" content='http://{{ session("server") }}/commonimages/facebook/Australia.jpg' />
<meta property="og:site_name" content='{{ session("localname") }} Community and Visitor Information Portal'/>
<meta property="fb:admins" content="593694625" />
<meta property="fb:app_id" content="990383464374216" />
<meta property="og:description" content="The Australian Regional Network"/>
<?php
$googlemeta = session('googlemeta'); 
$bingmeta = session('bingmeta'); 
if (isset($googlemeta)) { echo '
<meta name="google-site-verification" content="' . $googlemeta . '" />
'; } ?>
<?php if (isset($bingmeta)) { echo '
<meta name="msvalidate.01" content="' . $bingmeta . '" />
'; } ?>

<div class="loading">Loading&#8230;</div>

<style>

.main {
  opacity: 0.0;
} 	

.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(97,158,255,0.0);
}

.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 20px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>
<script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALidEcjlcsZ5ohU3ZFIyodj9eN1OcJO_w"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-dropdownhover.min.js') }}"></script>
<script src="{{ asset('js/fabric.3.4.0.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fontselect.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('js/redactor.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('js/fontcolor.js') }}"></script> 
<script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/upclick-min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script type="text/javascript">
var preload = new Array();

preload[0] = "/images/flag.gif";
preload[1] = "/commonimages/website.png";
preload[2] = "/publicimages/greenbullet.png";

var loadedimages = new Array();
for(var i=0; i<preload.length; i++) {
loadedimages[i] = new Image();
loadedimages[i].src = preload[i];
}
</script>

<script type="text/javascript">
$(window).ready(function() {
  // When the page has loaded
  $(".loading").hide();
  $(".main").fadeTo( "slow", 1 );
});
</script>

<?php 
# Random Header text colors
$darkshad = "222";
$lightshad = "ddd";

$colors = array(
array("1","#003399", "#DDD"),
array("2","#CC0000", "#000"),
array("3","#009966", "#000"),
array("4","#FFCC33", "#000")
);
shuffle($colors);

#print_r($colors);
?>
<style type='text/css'>
body, a, a:hover {
	cursor: url(/commonimages/cursors/red.cur), progress;
}
.header h1 {
	margin: 0;
	padding: 2;
	text-shadow: 1px 1px 1px #000;
	color: #FFF;
}
.header h2 {
	margin: 0;
	padding: 4;
color: <?php echo $colors[1][1];
?>;
text-shadow: 1px 1px 1px <?php echo $colors[1][2];
?>;
}
.header h3 {
	margin: 0;
	padding: 4;
color: <?php echo $colors[2][1];
?>;
text-shadow: 1px 1px 1px <?php echo $colors[2][2];
?>;
}
.header h4 {
	margin: 0;
	padding: 4;
color: <?php echo $colors[3][1];
?>;
text-shadow: 1px 1px 1px <?php echo $colors[3][2];
?>;
}
</style>
<link href="{{ asset('css/site.css') }}" rel="stylesheet" type="text/css">