<?php 
$sk = App\Skippycoin::where('status', '!=', '')->first();
$skippycoin = $sk->status;
?>

@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
<div class="panel-heading"> <img src="{{ asset('images/Australian-Regional-Network-Trans.png') }}" style="WIDTH: 100%" alt="Australian Regional Network Memberships"> </div>
<div class="panel-body">
  <div align="center"> @if($level == "Local Resident")
    <h1><font color="003399">Your Membership Level is: Local Resident</font></h1>
    <?php if ($skippycoin == 'on')
		{
		echo '<h1>ON</h1>';
		}
	?>
    <font color="009966"><strong>THIS MEMBERSHIP LEVEL IS FREE</strong></font><br>
    <br>
    <strong>You can create Articles with optional video in the Local Resident categories<br>
    You can publish limited free Ads and Events</strong><br />
    <div class="application"><a href="{{ route('localresident') }}">
      <button type="button" class="btn btn-success">Membership Guide & Rules</button>
      </a></div>
    <hr>
    <strong><font color="CC0000">Make your Ads and Events Full Service, Broadcast publish to 1000+ Australian Town and City websites
    <?php if ($skippycoin == 'on')
		{
		echo 'and qualify to receive daily Skippycoin ';
		}
	?>
    through a higher membership (Choose Below)</font></strong><br>
    <hr>
    <h2 align="center"><font color="003399">UPGRADE YOUR MEMBERSHIP</font></h2>
    <font color="009966"><strong>THANKYOU FOR SUPPORTING US</strong></font>
    <hr>
    <font color="009966"><strong>COMMUNITY LEADER
    <?php if ($skippycoin == 'on')
		{
		echo ' + Get daily <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a>';
		}
	?>
    </strong></font>
    <h3><font color="cc0000">Value Membership</font></h3>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application" align="center"><a href="{{ route('communityleader') }}">
            <button type="button" class="btn btn-primary">List a Community Group</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    Or Enter a<br>
    <div class="membershipkey"><a href="{{ route('sponsorship') }}">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="See Sponsorship Menu">Sponsorship Key</button>
      </a></div>
    <hr>
    <font color="009966"><strong>LOCAL BUSINESS MEMBER
    <?php if ($skippycoin == 'on')
		{
		echo ' + Get more <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a>';
		}
	?>
    </strong></font><br>
    <h3><font color="ffcc33">Gold Level Membership</font></h3>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application" align="center"><a href="{{ route('localbusiness') }}">
            <button type="button" class="btn btn-primary">Advertise a Local Business</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    <hr>
    <font color="009966"><strong>NATIONAL BUSINESS MEMBER - List on 1000+ Websites
    <?php if ($skippycoin == 'on')
		{
		echo ' + Get a lot more <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a>';
		}
	?>
    </strong></font><br>
    <h3><font color="A0A0A0">Platinum Level</font></h3>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application"><a href="{{ route('nationalbusiness') }}">
            <button type="button" class="btn btn-primary">Promote a National Business</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    @elseif($level == "Community Leader")
    <h1><font color="003399">Your Membership Level is Community Leader</font></h1>
    <strong>Your Ads and Events in Community Categories are full service</strong> <br>
    <strong>Share/Like your Ads, Events and Articles to Social Media this may boost your Search Traffic</strong><font color="009966"><br>
    <strong>THANKYOU FOR SUPPORTING US</strong></font><br>
    <p> <br>
      Friends and neighbors can read your articles, view your Ads and join as a Local Resident on <a href="https://australianregionalnetwork.com/" rel="nofollow" target="_blank">any node through Australia</a><br>
      <a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=<?php echo $location . '&cid=' . $cid; ?>" target="page" rel="nofollow" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes')">Click Here <img src="{{ $emlicon }}" width="44" height="51" /></a> To create a quick invitation to your Home Portal </p>
    <hr>
    <div class="application"><a href="{{ route('communityleader') }}">
      <button type="button" class="btn btn-success">Membership Guide & Rules</button>
      </a></div>
    <hr>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><img src="{{ $img2 }}" /></td>
        <td align="left"><h2><font color="009966">Upgrade to Business Membership</font></h2></td>
      </tr>
    </table>
    <strong><font color="cc0000">If you want to publish full service Commercial Ads, Events and Articles</font></strong><br>
    <hr>
    <h1>Choose Local Business Membership</h1>
    <strong>$5 per month or $50 per year</strong>
    <h3><font color="ffcc33">Gold Level</font></h3>
    <?php if ($skippycoin == 'on')
		{
		echo '<font color="009966"><strong>Local Business Members get more <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a></strong></font><br>';
		}
	?>
    <br>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application" align="center"><a href="{{ route('localbusiness') }}">
            <button type="button" class="btn btn-primary">Advertise a Local Business</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    <hr>
    <h1>Choose National Business Membership</h1>
    <strong>National Advertising rates at under $1 per website per year</strong><br>
    <h3><font color="A0A0A0">Platinum Level</font></h3>
    <p>Unlock all features and unleash the 1000+ Australian Town and City websites to engage your potential clients<br>
    </p>
    <?php if ($skippycoin == 'on')
		{
		echo '<font color="009966"><strong>National Business Members get lots more <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a></strong></font><br>';
		}
	?>
    <br>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application"><a href="{{ route('nationalbusiness') }}">
            <button type="button" class="btn btn-primary">Promote a National Business</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    @elseif($level == "Local Business")
    <h2><font color="CC0000">Promote your Ads and Content - Invite Local Residents!</font></h2>
    <p> <font color="009966"><strong>FOR THE COMMUNITY - FIRST LEVEL MEMBERSHIP IS FREE</strong></font><br>
      Invite your Neighbors to read your articles, view your Ads or join as a Local Resident on any<a href="https://australianregionalnetwork.com/" target="blank" rel="nofollow"> ARN </a>node through Australia<br>
      Ask your Friends and Employees to LIKE and TWEET your Smart Ads this may boost your Ad SEO<br>
      <a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=<?php echo $location . '&cid=' . $cid; ?>" target="page" rel="nofollow" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes')">Click Here <img src="{{ $emlicon }}" width="44" height="51" /></a> To create a quick invitation</p>
    <hr>
    <h2>Sponsor Community Leaders!</h2>
    <strong><font color="003399">Community Leaders can join with a "Gold Coin" account or FREE if sponsored under your Local Business</font></strong><br>
    <br>
    <style type="text/css">
			.mybox { width:100%;}
			</style>
    <script type="text/javascript" >
			function HideDIV(obj,hide,show) {
			 var divs=obj.getElementsByTagName('DIV');
			 divs[show].style.display='block';
			 divs[hide].style.display='none';
			}
			</script>
    <div id="initDiv" class="mybox"onmouseover="HideDIV(this,0,1);" onmouseout="HideDIV(this,1,0);">
      <div>
        <table width="100%" class="ad">
          <tr>
            <td align="center"><button type=button style="color: white; background-color: red; font-weight:bold">Important Tip for Local Business Members</button>
          </tr>
            </td>
          
        </table>
      </div>
      <div style="display:none;">
        <table width="100%" class="ad">
          <tr>
            <td align="center"><button type=button style="color: white; background-color: red; font-weight:bold">Important Tip for Local Business Members</button>
              <br>
              <br>
              <strong>Connecting Community to Business for mutual benefit is what the ARN is all about</strong><br>
              Sponsoring Community Leader accounts is a strategy to acheive rel="follow" backlinks to your business website that we beleive is in line with Google webmaster guidelines (Non paid for links / Genuine community relationship) and may boost your business SEO<br>
              <strong>How?</strong><br>
              Invite Community Leaders to join through the 1000+ websites of the ARN under your wing and Advertise their club or cause to automatically display "Sponsored&nbsp;by&nbspYour&nbspBusiness" Weblinks in their Smart Ad Footers. The Sponsorship Agreement also exchanges Contact Details with your CL, enabling you to further develop the community relationship<br>
              <font color="cc0000">Visit Status/Sponsorship to retrieve your Keys, Create Invitations and Learn More</font>
          </tr>
            </td>
          
        </table>
      </div>
    </div>
    <hr>
    <h1><font color="003399">Your Membership Level is: Local Business</font></h1>
    <p>
    <h3><font color="ffcc33">You have Gold Level Membership</font></h3>
    (Includes Local Resident + Community Leader privileges *)<br>
    You can create and maintain up to 5 business Smart Ads within the commercial directories<br>
    Publish articles to the commercial categories<br>
    Publish business events in the commercial categories<br>
    <div class="application"><a href="{{ route('localbusiness') }}">
      <button type="button" class="btn btn-success">Membership Guide & Rules</button>
      </a></div>
    </p>
    <hr>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><img src="{{ $img2 }}" /></td>
        <td align="left"><h1><font color="009966">Upgrade to National Business</font></h1></td>
      </tr>
    </table>
    <p>
    <h3><font color="A0A0A0">Platinum Level</font></h3>
    </p>
    Unlock all features and unleash the Australian Regional Network Superportal to engage your potential clients * <br>
    Support the community portals with your subscription of $100 per month or less p/a <br>
    Game changing National Advertising rates at under $1 per website per year <br>
    <?php if ($skippycoin == 'on')
		{
		echo '<font color="009966"><strong>National Business Members get lots more <a href="http://skippycoin.com" target="_blank" rel="nofollow">Skippycoin</a></strong></font><br>';
		}
	?>
    <br>
    <table border="0" cellpadding="0">
      <tr>
        <td align="right"><div class="application"><a href="{{ route('nationalbusiness') }}">
            <button type="button" class="btn btn-primary">Promote a National Business</button>
            </a></div></td>
        <td align="left"><img src="{{ $img1 }}" /></td>
      </tr>
    </table>
    @elseif($level == "National Business")
    <h1><font color="003399">Your Membership Level is: National Business</font></h1>
    <h3>Promote your Ads and Content - Invite Local Residents</h3>
    <p> <font color="009966"><strong>FOR THE COMMUNITY - FIRST LEVEL MEMBERSHIP IS FREE</strong></font><br>
      Invite your Peers to read your articles, view your Ads or join as a Local Resident on any<a href="https://australianregionalnetwork.com/" target="blank" rel="nofollow"> ARN </a>node through Australia<br>
      Ask your Contacts and Employees to LIKE and TWEET your Smart Ads this may boost your Ad SEO<br>
      <a href="/commonincludes/tellafriend/member-invite-member-form.php?homeportal=<?php echo $location . '&cid=' . $cid; ?>" target="page" rel="nofollow" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=580,height=500,left=50,top=50,titlebar=yes')">Click Here <img src="{{ $emlicon }}" width="44" height="51" /></a> To create a quick invitation</p>
    <hr>
    <h2>Sponsor Community Leaders!</h2>
    <strong><font color="003399">Community Leaders can join with a "Gold Coin" account or FREE if sponsored under your Local Business</font></strong><br>
    <br>
    <style type="text/css">
			.mybox { width:100%;}
			</style>
    <script type="text/javascript" >
			function HideDIV(obj,hide,show) {
			 var divs=obj.getElementsByTagName('DIV');
			 divs[show].style.display='block';
			 divs[hide].style.display='none';
			}
			</script>
    <div id="initDiv" class="mybox"onmouseover="HideDIV(this,0,1);" onmouseout="HideDIV(this,1,0);">
      <div>
        <table width="100%" class="ad">
          <tr>
            <td align="center"><button type=button style="color: white; background-color: red; font-weight:bold; text-align:center">Important Tip for National Business Members</button>
          </tr>
            </td>
          
        </table>
      </div>
      <div style="display:none;">
        <table width="100%" class="ad">
          <tr>
            <td align="center"><button type=button style="color: white; background-color: red; font-weight:bold">Important Tip for National Business Members</button>
              <p align="left"> <strong>Connecting Community to Business for mutual benefit is what the ARN is all about</strong><br>
                Sponsoring Community Leader accounts is a strategy to acheive rel="follow" backlinks to your business website that are in line with Google webmaster guidelines (Non paid for links / Genuine community relationship) and may boost your business SEO<br>
                <strong>How?</strong><br>
                Invite Community Leaders to join through the 1000+ websites of the ARN under your wing and Advertise their club or cause to automatically display "Sponsored&nbsp;by&nbspYour&nbspBusiness" Weblinks in their Smart Ad Footers. The Sponsorship Agreement also exchanges Contact Details with your CL, enabling you to further develop the community relationship!<br>
                <font color="cc0000">Visit the Sponsorship Page to retrieve your Keys and Create Invitations</font></p>
          </tr>
            </td>
          
        </table>
      </div>
    </div>
    <hr>
    <h3><font color="A0A0A0">You have Platinum Level Membership</font></h3>
    (Includes Local Resident + Community Leader + Local Business privileges)<br>
    <br>
    <div class="application"><a href="{{ route('nationalbusiness') }}">
      <button type="button" class="btn btn-success">Membership Guide & Rules</button>
      </a></div>
    <br>
    <h3><font color="#009966">Thank you for supporting the Australian Regional Network!</font></h3>
    <h3><font color="#009966">Over 1000 Town and City websites are at your service</font></h3>
    <br>
    <div align="center"><!-- Star Map Image Rollover --><a href="https://australianregionalnetwork.com/networkmap.php"
			       rel="nofollow"
			       target="_blank"><img title="ARN Websites"
			         style="WIDTH: 80%"
			         border="0"
			         alt="Websites Map"
			         src="{{ asset('images/TheStarMap1.png') }}"
			         onmouseout="this.src='{{ asset('images/TheStarMap1.png') }}'"
			         onmouseover="this.src='{{ asset('images/TheStarMap2.png') }}'"></a> </div>
    <div align="center"> <strong><font color="#CC0000">Over 1000 Australian Community Websites</font></strong>&nbsp; </div>
    @elseif($level == "Emergency Services") <br>
    ## Emergency Services Member Identified <br>
    <br>
    Content TBA<br>
    @else <br>
    ## Member Level Unidentified - Please Notify Support <br>
    @endif </div>
</div>
@endsection 