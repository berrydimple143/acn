<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>SMS Test</title>
</head>
<body>

<?php
$debug = 'on';
$smskey = '12345';
$mobile = '0423450493';
$SMS_gateway_account = '4ustralia';
$SMS_gateway_password = 'Morris#Perry#0870';
$SMS_leader = 'Use ';
$SMS_trailer = ' for SMS validation';
$SMS_message = $SMS_leader . $smskey . $SMS_trailer;
$SMS_channel_count = '4';
$SMS_gateway = '101.167.174.131';
$SMS_port = '1025';
$SMS_destination = 61 . substr($mobile, -9);
// Starting Assumptions
$SMS_success = 'NO';
// Produce an array with unique random SMS ports in the channel count range starting at 1
$random_port_array = range(1, $SMS_channel_count);
shuffle($random_port_array);
foreach($random_port_array as $channel)
	{
;
	$ch = curl_init();
	$SMS_gateway_password_encoded = curl_escape($ch, $SMS_gateway_password);
	$SMS_message_encoded = curl_escape($ch, $SMS_message);
	$transmission = "http://" . $SMS_gateway . ":" . $SMS_port . "/cgi/WebCGI?1500101=account=" . $SMS_gateway_account . "&password=" . $SMS_gateway_password_encoded . "&port=" . $channel . "&destination=" . $SMS_destination . "&content=" . $SMS_message_encoded;
	curl_setopt($ch, CURLOPT_URL, $transmission);
	if ($debug == 'on') { echo '<hr>' . $transmission . '<hr>'; }
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$SMS_result = curl_exec($ch);
if ($debug == 'on') { echo $SMS_result . '<hr>'; }
	if ((strpos($SMS_result, 'Response: Success') !== false) && ((strpos($SMS_result, 'Message: Commit successfully!') !== false)))
		{
		$SMS_success = 'YES';
		}
	  else
		{
		$SMS_success = 'NO';
		}
	curl_close($ch);
	if ($SMS_success == 'YES')
		{
		echo '<h1 align="center">SMS SENT</h1>';
		break;
		}
	  else
		{
		echo '<h1 align="center">SMS FAIL</h1>';
		}
	}
?>
</body>
</html>