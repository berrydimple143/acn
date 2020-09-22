@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <img src="{{ asset('images/Australian-Regional-Network.png') }}" style="WIDTH: 100%" alt="Australian Regional Network Memberships">   
  </div>
  <div class="panel-body">	
	<center><h1><strong>Sponsorship</strong></h1></center><br/>
			@if($level == "Local Resident")							 
					@if($sponsor != "Not Found")
						<table align="center" border="2">
							<tr>
								<td style="padding: 4px;">Registered Agreement (Pending): {{ $agreement }}<br/>
								Sponsors key: {{ $key }}
								</td>
						  	</tr>	
						</table>
						<br>Do you know a Community Leader or Local Business friend who may benefit from the Australian Regional Network?<br> 
						<a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=<?php echo $homeportal . '&cid=' . $cid; ?>" target="page" rel="nofollow" onClick="window.open(\'\',\'page\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes\')">Click Here <img src="{{ $emailimg }}" width="44" height="51" /></a>
						To send a quick invitation
						<br>
						<br>
						<br>
						Direct your friends living outside {{ $homeportal }} to <a href="https://australianregionalnetwork.com" rel="nofollow" target="_blank">https://australianregionalnetwork.com</a>
						<br>
					@else
						<p align="center">
						<strong>Advertising for your Community Group through the ARN is 100% FREE
						<br>If you have one or more Business Sponsors</strong>
						</p>
						(Optionally Community Leaders may choose a "<a href="{{ route('communityleader') }}">Gold Coin</a>" Membership to access similar benefits)
						<br><br>

						Responsible Local Residents can upgrade to a Community Leader account to gain higher level access to SEO enabled Smart Ads in the community categorys. These are are more than just Ads, they are like mini web pages with features that can direct new members to your community group or assist with your fund raising and you can change or update them with current information anytime
						<br><br>

						Business like to sponsor community organizations. It is beneficial to both parties. Sponsored accounts display  "Sponsored By" links in the content footers, This is a great way of initiating a connection between Business and the Community Organisation that is inexpensive and the relationships you forge may lead to more benefits
						<br><br>

						Also Community Leader (Free Access) level is restricted to validated persons to help arrest Spammers and Fakers.<br>
						Sponsorship helps us pay for the service and expensive things like Servers and Google maps over use charges<br>
						To gain the 100% FREE service you can invite a trusted business in your region to sponsor your account or accept an invitation from a current Local or National Business member. 
						<br><br>

						<strong>How?</strong><br><br>

						1, A Community Leader joins as a Local Resident, (Your current membership level)
						<br>
						2, The Business member will give you a Sponsorship Key that is obtained from their account (Sponsorship Page)
						<br>
						3, Enter the key here which initiates your sponsored upgrade
						<br><br>
						The Business member will see your key entry and contact details in their account which assures us that a deal has been made and the business accepts you under their wing. You can use the cross sharing of contact details to develop the Business to Community relationship (For Maximum benefit fully complete your profile! these details become visible to your business sponsor)
						<br><br>
						4, We upgrade your account and you will receive a notification email 
						<br><br>
						{!! Form::open(['route' => 'sponsorshipkey', 'method' => 'GET']) !!}						
							Enter your Sponsorship Key: <input type="text" name="key" value="" maxlength="20">
							<input type="hidden" name="cid" value="{{ $cid }}">
							<input type="submit" value="Submit">						
						{!! Form::close() !!}
						<br>
						Q: Is it ok to have both a Community Leader and a Business Account? i.e Sponsor myself<br>
						A: Yes, though you will need to have seperate email addresses, Business Leaders are often involved in leading Community Organisations and Business Members do also have the Community Leader priviledge (Under site guidelines commercial advertising is generally not allowed in community categories)<br>
						Business members can use your spare allocation to advertise your Community Group, though this will not display the "Sponsored By" links    

						<br><br>
						If your club is not listed and you not a Group Leader? You can help your club find their home in the Australian Regional Network<br> 

						<a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=<?php echo $homeportal . '&cid=' . $cid; ?>" target="page" rel="nofollow" onClick="window.open(\'\',\'page\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes\')">Click Here <img src="{{ $emailimg }}" width="44" height="51" /></a>
						To send a quick invitation
						<br><br>
						Direct your community leader friends living outside {{ $homeportal }} to <a href="https://australianregionalnetwork.com" rel="nofollow" target="_blank">https://australianregionalnetwork.com</a>
					@endif
			@endif
			@if($level == "Community Leader")
				<strong>Advertising for your Community Group through the ARN is 100% FREE if you have one or more Business Sponsors</strong><br>
				<?php					
					$unencrypted = '';
					$encrypted = '';
					$shortcustid = '';
					$numagreements = '';
					date_default_timezone_set('Australia/Darwin');					
					$epoch = time('U');					
					$epoch = $epoch - 34200;					
					$epochday = round($epoch/86400);					
					$smallepochday=$epochday-16314;
					$epochtimein =(($smallepochday+16314)*86400);
					$shortcustid = substr($cid, 2);
					$unencrypted = $smallepochday . $shortcustid;				
					$base23num = strtoupper(base_convert($unencrypted, 10, 23));
					$array = str_split($base23num);
					foreach($array as $char) {						
					$exchange = '';
					if ($char === "0"){ $exchange = "3";}
					if ($char === "1"){ $exchange = "4";}
					if ($char === "2"){ $exchange = "6";}
					if ($char === "3"){ $exchange = "7";}
					if ($char === "4"){ $exchange = "8";}
					if ($char === "5"){ $exchange = "9";}
					if ($char === "6"){ $exchange = "A";}
					if ($char === "7"){ $exchange = "C";}
					if ($char === "8"){ $exchange = "E";}
					if ($char === "9"){ $exchange = "F";}
					if ($char === "A"){ $exchange = "G";}
					if ($char === "B"){ $exchange = "H";}
					if ($char === "C"){ $exchange = "J";}
					if ($char === "D"){ $exchange = "K";}
					if ($char === "E"){ $exchange = "L";}
					if ($char === "F"){ $exchange = "M";}
					if ($char === "G"){ $exchange = "N";}
					if ($char === "H"){ $exchange = "P";}
					if ($char === "I"){ $exchange = "R";}
					if ($char === "J"){ $exchange = "T";}
					if ($char === "K"){ $exchange = "W";}
					if ($char === "L"){ $exchange = "X";}
					if ($char === "M"){ $exchange = "Y";}
					$encrypted = $encrypted . $exchange;
					}
					?>
					@if($sponsor == "Not Found")						
							<table  border="0" align="left">
							  <tr>
							    <td ><img src="{{ route('commonimages/redsidewinderleft.gif') }}" width="96" height="24" align="right" /></td>
							    <td >You have no existing Sponsorship Agreements</td>
							  </tr>
							</table>
					@else
						<h2>Sponsorship Agreements</h2>
					<?php						
						$sponsor_name = $sponsor_data->customer_name;
						$sponsor_surname = $sponsor_data->customer_surname;
						$sponsor_middlename = $sponsor_data->customer_middlename;
						$sponsor_title = $sponsor_data->customer_title;
						$sponsor_businessname = $sponsor_data->customer_businessname;
						$sponsor_position = $sponsor_data->customer_position;
						$sponsor_email = $sponsor_data->customer_email;
						$sponsor_phone = $sponsor_data->customer_phone;
						$sponsor_mobile = $sponsor_data->customer_mobile;
						$sponsor_address_1 = $sponsor_data->customer_address_1;
						$sponsor_address_2 = $sponsor_data->customer_address_2;
						$sponsor_city = $sponsor_data->customer_city;
						$sponsor_state = $sponsor_data->customer_state;
						$sponsor_postcode = $sponsor_data->customer_postcode;
						$sponsor_country = $sponsor_data->customer_country;
						$sponsor_nickname = $sponsor_data->customer_nickname;
						$sponsor_displaynickname = $sponsor_data->customer_displaynickname;
						$sponsor_level = $sponsor_data->customer_level;
						$sponsor_homeportal = $sponsor_data->customer_homeportal;
						$sponsor_currentportal = $sponsor_data->customer_currentportal;
						$sponsor_facebook = $sponsor_data->customer_facebook;
						$sponsor_linkedin = $sponsor_data->customer_linkedin;
						$sponsor_twitter = $sponsor_data->customer_twitter;
						$sponsor_pwebsite = $sponsor_data->customer_pwebsite;
						$sponsor_cwebsite = $sponsor_data->customer_cwebsite;
						$sponsor_bwebsite = $sponsor_data->customer_bwebsite;
						$sponsor_skcwallet = $sponsor_data->customer_skcwallet;
						if($status == 'NEW') {
							?>
								<strong><font color = "red">PENDING AGREEMENT</font></strong> Number: {{ $agreement }}<br>
								<table  border="2">
								  <tr>
								    <td style="padding: 4px;">Name: <?php echo $sponsor_businessname; ?>, Key Used: {{ $key }}
							<?php
						} else {
							?>
							<strong><font color = "green">ACTIVE AGREEMENT</font></strong> Number: {{ $agreement }}<br>
							<table  border="2">
							  <tr>
							    <td style="padding: 4px;">Name: <?php echo $sponsor_businessname; ?>
							<?php
						}
						?>
						</td>
							<tr><td style="padding: 4px;">Sponsor Contact Details: 
						<?php
						if (!empty($sponsor_title)) { echo $sponsor_title . ' '; }
						if (!empty($sponsor_name)) { echo $sponsor_name . ' '; }
						if (!empty($sponsor_surname)) { echo $sponsor_surname . ' '; }
						if (!empty($sponsor_position)) { echo '(' . $sponsor_position . ')'; }
						echo '<br>Email: <a href="mailto:' . $sponsor_email . '">' . $sponsor_email . '</a> ';

						if (!empty($sponsor_phone)) { echo 'Phone:' . $sponsor_phone . ' '; }
						if (!empty($sponsor_mobile)) { echo 'Mobile:' . $sponsor_mobile . ' '; }
						if (!empty($sponsor_address_1)) { echo '<br>' . $sponsor_address_1 . '<br>'; }
						if (!empty($sponsor_address_2)) { echo $sponsor_address_2 . '<br>'; }
						if (!empty($sponsor_city)) { echo $sponsor_city . ' '; }
						if (!empty($sponsor_state)) { echo $sponsor_state . ' '; }
						if (!empty($sponsor_postcode)) { echo $sponsor_postcode . ' '; }
						if (!empty($sponsor_country)) { echo $sponsor_country . ' '; }
						echo '<br>ARN Home Portal: ' . $sponsor_homeportal . ' ';

						if ($sponsor_displaynickname == "1") { if (!empty($sponsor_nickname)) { echo ' Nickname: ' . $sponsor_nickname . ' '; }}
						if (!empty($sponsor_facebook) or !empty($sponsor_linkedin) or !empty($sponsor_twitter)) { echo '<br>'; }
						if (!empty($sponsor_facebook)) { echo ' <a href="' . $sponsor_facebook . '" target="_blank">FACEBOOK</a> '; }
						if (!empty($sponsor_linkedin)) { echo ' <a href="' . $sponsor_linkedin . '" target="_blank">LINKEDIN</a> '; }
						if (!empty($sponsor_twitter)) { echo ' <a href="https://twitter.com/' . $sponsor_twitter . '" target="_blank">TWITTER</a> '; }
						if (!empty($sponsor_cwebsite)) { echo '<br>Community Website: <a href="' . $sponsor_cwebsite . '" target="_blank">' . $sponsor_cwebsite . '</a> '; }
						if (!empty($sponsor_bwebsite)) { echo '<br>Business Website: <a href="' . $sponsor_bwebsite . '" target="_blank">' . $sponsor_bwebsite . '</a> '; }
						if (!empty($sponsor_pwebsite)) { echo '<br>Personal Website: <a href="' . $sponsor_pwebsite . '" target="_blank">' . $sponsor_pwebsite . '</a> '; }
						?>
						</td>
						  </tr>
						</table><br>
						<strong>Use the Contact Details to build a relationship with your business sponsor!</strong><br><br>
						If you would like to terminate an agreement <a href="mailto:admin@australianregionalnetwork.com?subject=ARN Member: {{ $cid }} - Terminate Sponsorship Agreement Request">Email us</a> and advise the Agreement Number<br>(Please include a brief reason as this may downgrade your Community Leader account)<br><br>
						<strong>To add another Business Sponsor</strong>
						{!! Form::open(['route' => 'sponsorshipkey', 'method' => 'GET']) !!}						
							Enter your Sponsorship Key: <input type="text" name="key" value="" maxlength="20">
							<input type="hidden" name="cid" value="{{ $cid }}">
							<input type="submit" value="Submit">
						{!! Form::close() !!}
					@endif
			@endif	
			@if($level == "Local Business" or $level == "National Business" or $level == "Administrator")
				<?php
					$contenthead = '
					<strong>Sponsor Community Leader accounts and gain elevation and exposure for your Business</strong>
					<br><br>

					Sponsored accounts allow a Community Leader FREE access to the ARN Smart Ads system and Article Directories within the Community Category\'s and display  "Sponsored by your Business" links in the Community Leaders footers.<br> 
					This is a great way of initiating a connection between Business and a Community Organisation that is inexpensive, beneficial to both parties and the relationships you forge may lead to further gain and good
					<br><br>

					<strong>IMPORTANTLY:</strong><br>
					Community Leader level accounts are restricted to validated persons to help arrest Spammers and Fakers.<br>
					When Sponsoring, you are authenticating this person and they should be a personally trusted individual or group<br>
					Please don\'t advertise your Sponsorship keys publically (This is against ARN terms)

					<br><br>

					<strong>How?</strong><br><br>

					1, Your prospective Community Leader joins as a Local Resident (you can invite them to join)
					<br>
					2, The Business Member delivers his current Sponsorship Key (obtained from this page)
					<br>
					3, Your Sponsoree enters your key into their account which inform us your deal has been made
					<br>
					5, The agreement flags the sponsored Community Leader account under your wing
					<br>
					6, Your agreement(s) will appear here with the Community Leaders contact details, that you can use to extend the relationship  
					<br>
					<br>
					<strong>Important Points to understand for your Business</strong></br>
					Smart Ads created by the Community Leader will display your sponsorship credit with <u>Web Backlink</u> to your business website<br><strong>Therefore be sure to keep your Profile and Business Website link up to date!</strong><br> As this is not a "Paid For" link, Genuine relationships should comply with Google Webmaster Guidelines which may allow for the credited backlink to boost the pagerank of your business website.
					<br>
					Keep in mind that irrelevant backlinks could work Google etc against you therefore don\'t plan to use this as Blackhat SEO through fake accounts!<br />
					<br>
					Through this mechanism the ARN may deliver you extra traffic and customers from outside the system 
					<br><font color = "red">
					The ARN does not endorse seeking out sponsor relationships with Community Leaders simply for gaining backlinks and boosting your Business Website Search Engine Pagerank!
					This should be a genuine community relationship, and you might use the "foot in the door" opportunity to evolve your sponsoree support which is in the spirit of the ARN. Therefore look for extra ways to assist your Community Leaders with Cash, Goods or Working Bee\'s etc. By doing a good deed in the community the benefits to your business could be felt in unusual and wholistic ways    
					</font>
					<br><br>
					<strong>We hope the ARN can develop many good Business Sponsor to Community Group relationships within Australia</strong> 
					<br>';

					$contentFAQ= '
					<strong>Q:</strong> Is it ok to have both a Business and Community Leader Account? i.e Sponsor myself<br>
					<strong>A:</strong> Yes, though you will need to have seperate email addresses.<br>
					Business Leaders are often involved in leading seperate Community Organisations and you do also have the Community Leader priviledge (Under site guidelines commercial advertising is generally not allowed in community categories)<br>
					Business members can use your spare allocation to advertise your Community Group, though as this does not clearly show a genuine business to community relationship this will not display "Sponsored by" (SEO follow) Backlinks
					<br><br>
					If your Community Group is not listed, you can help your club find their home in the Australian Regional Network
					<br> 
					<a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=' . $homeportal . '&cid=' . $cid . '" target="page" rel="nofollow" onClick="window.open(\'\',\'page\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes\')">Click Here <img src="'.$emailimg.'" width="44" height="51" /></a>
					To send a quick invitation
					<br><br>
					Direct your community leader friends living outside ' .$homeportal . ' to <a href="https://australianregionalnetwork.com" rel="nofollow" target="_blank">https://australianregionalnetwork.com</a>
					';

					$unencrypted = '';
					$encrypted = '';
					$shortcustid = '';
					$numagreements = '';
					date_default_timezone_set('Australia/Darwin');
					$epoch = time('U');					
					$epoch = $epoch - 34200;			
					$epochday = round($epoch/86400);			
					$smallepochday=$epochday-16314;
					$epochtimein =(($smallepochday+16314)*86400);
					$shortcustid = substr($cid, 2);
					$unencrypted = $smallepochday . $shortcustid;					
					$base23num = strtoupper(base_convert($unencrypted, 10, 23));
					$array = str_split($base23num);
					foreach($array as $char) {						
						$exchange = '';
						if ($char === "0"){ $exchange = "3";}
						if ($char === "1"){ $exchange = "4";}
						if ($char === "2"){ $exchange = "6";}
						if ($char === "3"){ $exchange = "7";}
						if ($char === "4"){ $exchange = "8";}
						if ($char === "5"){ $exchange = "9";}
						if ($char === "6"){ $exchange = "A";}
						if ($char === "7"){ $exchange = "C";}
						if ($char === "8"){ $exchange = "E";}
						if ($char === "9"){ $exchange = "F";}
						if ($char === "A"){ $exchange = "G";}
						if ($char === "B"){ $exchange = "H";}
						if ($char === "C"){ $exchange = "J";}
						if ($char === "D"){ $exchange = "K";}
						if ($char === "E"){ $exchange = "L";}
						if ($char === "F"){ $exchange = "M";}
						if ($char === "G"){ $exchange = "N";}
						if ($char === "H"){ $exchange = "P";}
						if ($char === "I"){ $exchange = "R";}
						if ($char === "J"){ $exchange = "T";}
						if ($char === "K"){ $exchange = "W";}
						if ($char === "L"){ $exchange = "X";}
						if ($char === "M"){ $exchange = "Y";}
						$encrypted = $encrypted . $exchange;
					}
					if($sponsor3 == "Not Found") {
						echo $contenthead;	
						echo '<br>Here is your current Sponsorship Key: ';
						echo '<strong><font color="#0000FF">' . $encrypted . '</font></strong><br>';
						echo 'The Issue Date is ' . date('Y-m-d', $epochtimein) . '. Please inform your Sponsoree that this key is valid for 30 days<br>';

						echo '
						<table  border="0" align="center">
						  <tr>
						    
						    <td ><h3>We found no active Sponsorship Agreements</h3></td>
							<td ><img src="'.$img2.'" width="96" height="24" align="right" /></td>
						  </tr>
						</table>';

						echo '<h3>FAQ</h3>';
						echo $contentFAQ;	
					} else {
						echo '<br>Here is your current Sponsorship Key: ';
						echo '<strong><font color="#0000FF">' . $encrypted . '</font></strong><br>';
						echo 'The Issue Date is ' . date('Y-m-d', $epochtimein) . '. Please inform your Sponsoree that this key is valid for 30 days<br>';	
						echo '<h2>Sponsorship Agreements</h2>';
						$agreement = $agreement3;
					    $sponsoree = $sponsoree3;
						$key = $key3;
						$status = $status3;								
						$sponsoree_name = $sponsoree_data->customer_name;
						$sponsoree_surname = $sponsoree_data->customer_surname;
						$sponsoree_middlename = $sponsoree_data->customer_middlename;
						$sponsoree_title = $sponsoree_data->customer_title;
						$sponsoree_businessname = $sponsoree_data->customer_businessname;
						$sponsoree_position = $sponsoree_data->customer_position;
						$sponsoree_email = $sponsoree_data->customer_email;
						$sponsoree_phone = $sponsoree_data->customer_phone;
						$sponsoree_mobile = $sponsoree_data->customer_mobile;
						$sponsoree_address_1 = $sponsoree_data->customer_address_1;
						$sponsoree_address_2 = $sponsoree_data->customer_address_2;
						$sponsoree_city = $sponsoree_data->customer_city;
						$sponsoree_state = $sponsoree_data->customer_state;
						$sponsoree_postcode = $sponsoree_data->customer_postcode;
						$sponsoree_country = $sponsoree_data->customer_country;
						$sponsoree_nickname = $sponsoree_data->customer_nickname;
						$sponsoree_displaynickname = $sponsoree_data->customer_displaynickname;
						$sponsoree_level = $sponsoree_data->customer_level;
						$sponsoree_homeportal = $sponsoree_data->customer_homeportal;
						$sponsoree_currentportal = $sponsoree_data->customer_currentportal;
						$sponsoree_facebook = $sponsoree_data->customer_facebook;
						$sponsoree_linkedin = $sponsoree_data->customer_linkedin;
						$sponsoree_twitter = $sponsoree_data->customer_twitter;
						$sponsoree_pwebsite = $sponsoree_data->customer_pwebsite;
						$sponsoree_cwebsite = $sponsoree_data->customer_cwebsite;
						$sponsoree_bwebsite = $sponsoree_data->customer_bwebsite;
						$sponsoree_skcwallet = $sponsoree_data->customer_skcwallet;

						if($status == 'NEW') {
						echo '<strong><font color = "red">PENDING AGREEMENT</font></strong> Number: ' . $agreement . '<br>';
						echo '
						<table  border="2">
						  <tr>
						    <td style="padding: 4px;">';
						echo 'Name: ' . $sponsoree_businessname . ', Key Used:  ' . $key;	

						} else { 

						echo '<strong><font color = "green">ACTIVE AGREEMENT</font></strong> Number: ' . $agreement . '<br>';
						echo '
						<table  border="2">
						  <tr>
						    <td style="padding: 4px;">';
						echo 'Name: ' . $sponsoree_businessname;	
						}

						echo '</td>
						<tr><td style="padding: 4px;">';
							
						echo 'Sponsoree Contact Details: ';
						if (!empty($sponsoree_title)) { echo $sponsoree_title . ' '; }
						if (!empty($sponsoree_name)) { echo $sponsoree_name . ' '; }
						if (!empty($sponsoree_surname)) { echo $sponsoree_surname . ' '; }
						if (!empty($sponsoree_position)) { echo '(' . $sponsoree_position . ')'; }
						echo '<br>Email: <a href="mailto:' . $sponsoree_email . '">' . $sponsoree_email . '</a> ';

						if (!empty($sponsoree_phone)) { echo 'Phone:' . $sponsoree_phone . ' '; }
						if (!empty($sponsoree_mobile)) { echo 'Mobile:' . $sponsoree_mobile . ' '; }
						if (!empty($sponsoree_address_1)) { echo '<br>' . $sponsoree_address_1 . '<br>'; }
						if (!empty($sponsoree_address_2)) { echo $sponsoree_address_2 . '<br>'; }
						if (!empty($sponsoree_city)) { echo $sponsoree_city . ' '; }
						if (!empty($sponsoree_state)) { echo $sponsoree_state . ' '; }
						if (!empty($sponsoree_postcode)) { echo $sponsoree_postcode . ' '; }
						if (!empty($sponsoree_country)) { echo $sponsoree_country . ' '; }
						echo '<br>ARN Home Portal: ' . $sponsoree_homeportal . ' ';

						if ($sponsoree_displaynickname == "1") { if (!empty($sponsoree_nickname)) { echo ' Nickname: ' . $sponsoree_nickname . ' '; }}
						if (!empty($sponsoree_facebook) or !empty($sponsoree_linkedin) or !empty($sponsoree_twitter)) { echo '<br>'; }
						if (!empty($sponsoree_facebook)) { echo ' <a href="' . $sponsoree_facebook . '" target="_blank">FACEBOOK</a> '; }
						if (!empty($sponsoree_linkedin)) { echo ' <a href="' . $sponsoree_linkedin . '" target="_blank">LINKEDIN</a> '; }
						if (!empty($sponsoree_twitter)) { echo ' <a href="https://twitter.com/' . $sponsoree_twitter . '" target="_blank">TWITTER</a> '; }
						if (!empty($sponsoree_cwebsite)) { echo '<br>Community Website: <a href="' . $sponsoree_cwebsite . '" target="_blank">' . $sponsoree_cwebsite . '</a> '; }
						if (!empty($sponsoree_bwebsite)) { echo '<br>Business Website: <a href="' . $sponsoree_bwebsite . '" target="_blank">' . $sponsoree_bwebsite . '</a> '; }
						if (!empty($sponsoree_pwebsite)) { echo '<br>Personal Website: <a href="' . $sponsoree_pwebsite . '" target="_blank">' . $sponsoree_pwebsite . '</a> '; }

						echo '</td>
						  </tr>
						</table><br>';
						echo '<strong>Use the Contact Details to build relationships with your Community Organisations!</strong><br><br>';

						echo 'If you would like to terminate an agreement <a href="mailto:admin@australianregionalnetwork.com?subject=ARN Member: ' . $cid . ' - Terminate Sponsorship Agreement Request">Email us</a> and advise the Agreement Number<br>(You might include a brief reason for us as your Sponsoree may be downgraded)';

						echo '<h3>FAQ</h3>';
						echo $contentFAQ;	
						echo '<h3>ABOUT</h3>';
						echo $contenthead;	
					}
				?>
			@endif
			@if($level == "Local Government" or $level == "State Government" or $level == "Federal Government" or $level == "Emergency Services")
				Sponsorship is not available for your account
			@endif			
  </div> 
</div>
@endsection