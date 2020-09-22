<?php

function hashToMD5($str) {
	return MD5($str);
}
function htmlEntityDecode($str, $const, $encoding) {
	return html_entity_decode($str, $const, $encoding);
}
function base64Encode($str) {
	return base64_encode($str);
}
function htmlSpecialCharsDecode($str) {
	return htmlspecialchars_decode($str);
}
function validYouTube($id) {
    if ((strlen($id) > 10) && (strlen($id) < 16)) {
        $file = @file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=status&id=' . $id . '&key=AIzaSyCWReLftuwvUx1l8etFj7OnBbQv-hlyESI');
		$uploadstatus = '/uploadStatus"\: "processed/';
		$privacystatus = '/privacyStatus"\: "public/';
		$embeddable = '/embeddable"\: true/';
		if(preg_match($uploadstatus, $file)) { $uploadstatus = 'good'; } else { $uploadstatus = 'bad'; }		
		if(preg_match($privacystatus, $file)) { $privacystatus = 'good'; } else { $privacystatus = 'bad'; }		
		if(preg_match($embeddable, $file)) { $embeddable = 'good'; } else { $embeddable = 'bad'; }			
		if(($uploadstatus == 'good') && ($privacystatus == 'good') && ($embeddable == 'good')) { return 'good'; }		
		if(($uploadstatus == 'bad') && (($privacystatus == 'good') or ($embeddable == 'good'))) { 
			return 'YouTube reports an Upload Status problem. Perhaps the video is not ready yet';
		}		
		if(($uploadstatus == 'good') && ($privacystatus == 'bad') && ($embeddable == 'good')) {
			return 'YouTube reports this video is not Public. To Fix it: Go to your Youtube Account, Use the Video Manager and change the Video Status to Public';
		}		
		if (($uploadstatus == 'good') && ($privacystatus == 'good') && ($embeddable == 'bad')) {
			return 'YouTube reports this video is not Embeddable. To Fix it: Go to your Youtube account, Use the Video Manager, under Advanced Settings, scroll down to Distribution Options and check the Allow Embedding option';
		}
		return 'Sorry, That dosent validate with YouTube, Check your Input'; 
	}
}
function getYoutubeVideoData($code, $URL, $embed) {
	if($code != "") {	
		$code = substr($code, 0, 14);
		$code = preg_replace('/[^A-Za-z0-9-_]/', '', $code);	
		if (strlen($code) < 11){ $error_code = "Code looks too short"; }
		if (strlen($code) > 11) { $error_code = "Code looks too long"; }	
	}
	if($URL != "") {		
		if(!preg_match('~^(http|ftp)(s)?\:\/\/((([a-z|0-9|\-]{1,25})(\.)?){2,7})($|/.*$)~i', $URL)) {
			$error_URL = "That dosent look like a valid URL";
			$URL = substr($URL, 0, 120);
		}else if (strlen($URL) < 25) { 
			$error_URL = "URL looks too short";
		}else if (strlen($URL) > 120) { 
			$URL = substr($URL, 0, 120);
		   	$error_URL = "URL looks too long";
		}else { 		
			$pattern = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';
			$URL = (preg_replace($pattern, '$1', $URL));		
			$URL = preg_replace('/[^A-Za-z0-9-_]/', '', $URL);
		}
	}
	if($embed != "") {
		$embed = substr($embed, 0, 500);
		if((strlen($embed) < 50) || (strlen($embed) > 400)) {
			if($embed){ $error_embed = "That dosent look like an Embed Code"; } 
		} else {
			preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $embed, $output);
			if(isset($output[2])){ $embed = $output[2]; }	  
			$embed = preg_replace('/[^A-Za-z0-9-_]/', '', $embed);
		}
	}
	$error = 'yes';
	$testvalidcode= validYouTube($code);
	if($testvalidcode == 'good') {
		$ad_videoid = $code;
		$error = 'no'; 
	} else {
		$testvalidURL = validYouTube($URL);
		if($testvalidURL == 'good'){
			$ad_videoid = $URL; 
			$error = 'no'; 
		} else { 
			$testvalidembed = validYouTube($embed);
			if($testvalidembed == 'good'){
				$ad_videoid = $embed; 
				$error = 'no'; 
			} 
		}
	}
	if(isset($ad_videoid)) {
		$data = $ad_videoid . "|@|";		
		$data .= '<iframe width="550" height="360" src="https://www.youtube.com/embed/'. $ad_videoid . '?autoplay=1&controls=0&color=white&autohide=1&loop=1&modestbranding=1&showinfo=0&rel=0&cc_load_policy=0&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>';
		return $data;			
	} else {
		return 'not set';
	}
}
