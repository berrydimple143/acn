<?php 
$sk = App\Skippycoin::where('status', '!=', '')->first();
$skippycoin = $sk->status;
?>

@extends('layouts.admin')
@section('title', $title)
@section('content')
<?php	
	date_default_timezone_set('Australia/Darwin');	
	$paypal_mode = "LIVE";
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	$paypal_email = "accounts@australianregionalnetwork.com";
	$paypal_sandbox_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	$paypal_sandbox_email = "customerservice-facilitator@4ustralia.com";
	if ($paypal_mode == "SANDBOX") {
		$paypal_url = $paypal_sandbox_url;
		$paypal_email = $paypal_sandbox_email;
	}
?>
<div class="panel panel-default">
  <div class="panel-heading"> <img src="{{ asset('images/Australian-Regional-Network-Trans.png') }}" style="WIDTH: 100%" alt="Australian Regional Network Memberships"> </div>
  <div class="panel-body"> @if($level == "Local Resident" or $level == "Community Leader") 
    <script type="text/jscript">    
$(function() {
    $('#showdiv1').click(function() {
        $('div[id^=div]').hide();
        $('#div1').show();
    });
    $('#showdiv2').click(function() {
        $('div[id^=div]').hide();
        $('#div2').show();
    });

    $('#showdiv3').click(function() {
        $('div[id^=div]').hide();
        $('#div3').show();
    });

    $('#showdiv4').click(function() {
        $('div[id^=div]').hide();
        $('#div4').show();
    });

})   
  </script> 
    <a name="top"></a>
    <h2 align="center"><strong>Local Business Membership</strong></h2>
    <br/>
    Local Business level unleashes essential features such as weblinks and allows you to publish extra quota of Smart Ads and Business Events into the Commercial Directories and post Commercial Articles such as Press Releases into the Commercial Article Categories through any of the 1000+ Australian town and city websites of the ARN.<br >
    <br>
    You can sponsor Community Leader Accounts under your wing automatically embedding visible "Sponsored By" Rel&nbsp;Follow backlinks into your community groups Ads to mutual benefit.<br>
    <br>
    <strong>Local Business Ads position higher than National Ads</strong><br>
    And Subscribed Ads position higher than Trial Ads, win directory /category page one top position long term depending on your Ad Age i.e. The most early supporter can secure top of page one in your town. We dont make you bid per click against each other for position, this is an Australian family owned service your Advertising dollar stays in country and it works in hand with hundreds of popular foreign owned Social Media and Backchannel web services giving your customers and employees an easy mechanism to share and promote your business<br>
    ( * Business Events rank by date of the event and most recent updated article wins top of Article Category )<br>
    </br>
    <div id="div1" class="buttons" align="center">
      <h3>Cost?</h3>
      <br>
      $5 per month (Via Paypal Subscription) or<br>
      $50 per year (Best Value) or<br>
      Manually Invoiced at $1 per day<br>
      <?php if ($skippycoin == 'on'){echo '<br>
      <font color="cc0000">Until future notice.. i.e while the network has ample supply</font><br>
      All Local Business Memberships can accumulate emerging Australian <a href="https://skippycoin.com" target="_blank">Skippycoin</a><br>
      Currently at 13698.64 Joey per day or 5 SKC per year<br>';}?>
      <br>
      <h3 align="center">What Membership might interest you?</h3>
      <br>
      <table align="center" border="0">
        <tr>
          <td><div align="center"><a class="button" id="showdiv2">
              <button type="button" class="btn btn-primary btn-sm" >$5 Monthly</button>
              </a><br>
              <br>
            </div></td>
          <td><img src="{{ $img1 }}" width="96" height="24" align="left" /><br>
            <br></td>
        </tr>
        <tr>
          <td><div align="center"><a class="button" id="showdiv3">
              <button type="button" class="btn btn-primary btn-sm" >$50 Annual</button>
              </a><br>
              <br>
            </div></td>
          <td><img src="{{ $img1 }}" width="96" height="24" align="left" /><br>
            <br></td>
        </tr>
        <tr>
          <td><div align="center"><a class="button" id="showdiv4">
              <button type="button" class="btn btn-primary btn-sm" >Non Paypal Options</button>
              </a><br>
              <br>
            </div></td>
          <td><img src="{{ $img1 }}" width="96" height="24" align="left" /><br>
            <br></td>
        </tr>
      </table>
    </div>
    <div id="div2" style="display:none;" align="center">
      <h2>Monthly Subscription</h2>
      <br>
      <strong>Local Business Subscription $5 per month for up to 5 flexible <a href="http://{{ $homeurl }}/Example-Ads.php" rel="nofollow" target="_blank">Smart Ads</a> + Access to Local Business Features such as All Directories, Business Events, Article Marketing and Sponsorship Marketing</strong><br>
      <h4><font color="#009966">You can cancel any time via your Paypal Account</font></h4>
      {!! Form::open(['route' => 'process.pay', 'method' => 'POST']) !!}
      <input type="hidden" name="cmd" value="_xclick-subscriptions" />
      <input type="hidden" name="business" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="item_name" value="Local Business Membership" />
      <input type="hidden" name="item_number" value="Local Business" />
      <input type="hidden" name="on0" value="Member">
      <input type="hidden" name="os0" value="{{ $cid }}">
      <input type="hidden" name="image_url" value="https://australianregionalnetwork.com/commonimages/logos/Australian-Regional-Network.png">
      <input type="hidden" name="currency_code" value="AUD" />
	  <input type="hidden" name="a1" value="5" />
      <input type="hidden" name="p1" value="1" />
      <input type="hidden" name="t1" value="M" />
      <input type="hidden" name="a2" value="" />
      <input type="hidden" name="p2" value="" />
      <input type="hidden" name="t2" value="" />
      <input type="hidden" name="a3" value="5" />
      <input type="hidden" name="p3" value="1" />
      <input type="hidden" name="t3" value="M" />
      <input type="hidden" name="return" value="http://{{ $homeurl }}/Subscriber-Thankyou.php" />
      <input type="hidden" name="cancel_return" value="http://{{ $homeurl }}/Subscriber-Cancel.php" />
      <input type="hidden" name="src" value="1" />
      <input type="hidden" name="sra" value="1" />
      <input type="hidden" name="receiver_email" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="no_shipping" value="1" />
      <input type="hidden" name="no_note" value="1" />
      <input type="hidden" name="subscription" value="monthly" />
      <input type="hidden" name="price" value="5" />
      <br>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="40%">&nbsp;</td>
          <td width="10%"><input type="image" name="submit" src="https://www.paypalobjects.com/en_AU/i/btn/btn_subscribeCC_LG.gif" border="0" alt="Make payments with PayPal, it's fast, free, and secure!" /></td>
          <td width="40%"><img src="{{ $img1 }}" width="96" height="24" align="left" /></td>
        </tr>
      </table>
      <br>
      <img alt="" border="0" src="http://www.paypal.com/images/verification_seal.gif"> {!! Form::close() !!} <br>
      <div class="application" align="center"> <a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Show other Local Business Options</button>
        </a> </div>
      Or<br>
      All the above plus switch on the broadcast power of 1000+ United Australian Town and City websites promoting your Ads, Articles and Events for under $1 per website per year
      <div class="application" align="center"><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">View National Business membership</button>
        </a></div>
    </div>
    <div id="div3" style="display:none;" align="center">
      <h2>Annual Subscription</h2>
      <br>
      <strong>Local Business Subscription $50 per year for up to 5 flexible <a href="http://{{ $homeurl }}/Example-Ads.php" rel="nofollow" target="_blank">Smart Ads</a> + Access to Local Business Features such as All Directories, Business Events, Article Marketing and Sponsorship Marketing
      <?php if ($skippycoin == 'on'){echo ' + Receive Skippycoin';} ?>
      </br>
      <font color="#009966">You can cancel any time via your Paypal Account</font><br>
      <br>
      <h4><font color="#003399">This is the Best Value Local Business Option</font></h4>
      {!! Form::open(['route' => 'process.pay', 'method' => 'POST']) !!}
      <input type="hidden" name="cmd" value="_xclick-subscriptions" />
      <input type="hidden" name="business" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="item_name" value="Local Business Membership" />
      <input type="hidden" name="item_number" value="Local Business" />
      <input type="hidden" name="on0" value="Member">
      <input type="hidden" name="os0" value="{{ $cid }}">
      <input type="hidden" name="image_url" value="https://australianregionalnetwork.com/commonimages/logos/Australian-Regional-Network.png">
      <input type="hidden" name="currency_code" value="AUD" />
	  <input type="hidden" name="a1" value="50" />
      <input type="hidden" name="p1" value="1" />
      <input type="hidden" name="t1" value="Y" />
      <input type="hidden" name="a2" value="" />
      <input type="hidden" name="p2" value="" />
      <input type="hidden" name="t2" value="" />
      <input type="hidden" name="a3" value="50" />
      <input type="hidden" name="p3" value="1" />
      <input type="hidden" name="t3" value="Y" />
      <input type="hidden" name="return" value="http://{{ $homeurl }}/Subscriber-Thankyou.php" />
      <input type="hidden" name="cancel_return" value="http://{{ $homeurl }}/Subscriber-Cancel.php" />
      <input type="hidden" name="src" value="1" />
      <input type="hidden" name="sra" value="1" />
      <input type="hidden" name="receiver_email" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="no_shipping" value="1" />
      <input type="hidden" name="no_note" value="1" />
      <input type="hidden" name="subscription" value="annual" />
      <input type="hidden" name="price" value="50" />
      <br>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="40%">&nbsp;</td>
          <td width="10%"><input type="image" name="submit" src="https://www.paypalobjects.com/en_AU/i/btn/btn_subscribeCC_LG.gif" border="0" alt="Make payments with PayPal, it's fast, free, and secure!" /></td>
          <td width="40%"><img src="{{ $img1 }}" width="96" height="24" align="left" /></td>
        </tr>
      </table>
      <br>
      <img alt="" border="0" src="http://www.paypal.com/images/verification_seal.gif"> {!! Form::close() !!} <br>
      <div class="application" align="center"> <a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Show other Local Business Options</button>
        </a> </div>
      Or<br>
      All the above plus switch on the broadcast power of 1000+ United Australian Town and City websites promoting your Ads, Articles and Events for under $1 per website per year
      <div class="application" align="center"><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">View National Business membership</button>
        </a></div>
    </div>
    <div id="div4" style="display:none;">
      <h2 align="center">Manual Invoicing</h2>
      <br>
      <p align="center"> <strong>Cost? $1 per day / $365 P/A</strong></p>
      <br>
      If Paypal memberships is a problem for your Accounts Department we can set up a Manual Account and mail you an invoice or we will try to work with whatever suits you. Simply complete your <a href="{{ route('settings') }}">Account Settings</a> with your Business Details then request a Local Business account via <a href="mailto:admin@australianregionalnetwork.com?subject=Customer%20ID%20{{ $cid }}%20requesting%20Local%20Business%20Membership">admin@australianregionalnetwork.com</a><br>
      Please include your Customer ID which is <strong>{{ $cid }}</strong><br>
      <br>
      <div align="center"><img alt="" border="0" width="25%" src="{{ asset('commonimages/badges/Keep-calm-and-carry-on.jpg') }}"></div>
      <br>
      <div class="application" align="center"> <a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Other Local Business Membership</button>
        </a> </div>
      <div align="center">Or Show Me</div>
      <div class="application" align="center"><a href="{{ route('communityleader') }}">
        <button type="button" class="btn btn-primary">Community Leader Membership</button>
        </a><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">National Business membership</button>
        </a></div>
    </div>
    <br>
    <br>
    @elseif ($level == "Local Business")
    <center>
      <h1><strong>Local Business Membership Guide and Rules</strong></h1>
    </center>
    <br/>
    <strong>The Community Portals are assembled from the individual article and image galleries of it's members.</strong> <br>
    With more control over your contributed content than some other Social Media Services you decide what is published and where and when it will appear, likewise you can remove your content at any time <br>
    <br>
    <strong>Under your membership You publish instantly and with that agree to take responsibility for what you publish</strong> <br>
    We reserve the right to remove content that causes complaints, problems or is outside the spirit of the network.<br>
    Please do good and play fair. Most new content and updates are followed by our admin team. Putting forward your point of view is welcome though if you are mean or do bad things or break the law we may lock out your account and cancel your membership<br>
    <br>
    <strong>Removing your images, articles, ads and events etc. means flagging it for removal from our online service. </strong><br>
    It is our intent that you have utmost control over your contributed content, however be aware that your contributions may remain cached or with backups until these are purged, internet crawlers and services outside our control such as Search Engines or likes of the Way Back Machine may keep permanent copies you will need to talk to those scrapy providers if you have a removal issue. <br>
    <br>
    <strong>Before we use your outstanding articles or images to promote the network we will seek your permission.</strong><br>
    However: Some ARN self promotion is automatic for example your Ads may appear as <a href="http://{{ $homeurl }}/Example-Ads.php" rel="nofollow" target="_blank">examples</a> to others, we hope this can be to your benefit if there is any issues with that let us know<br>
    <br>
    <strong>Content Quotas</strong> <br>
    To give all Local Business Members a fair go we set some limits
    </p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Create and maintain up to 50 articles</p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Upload up to 200 images</p>
    As we can fund the project we may raise these limits.<br>
    Your Subscription is helping us develop the ARN, Thankyou <a href="http://{{ $homeurl }}/Donations.php" target="_blank">Donations</a> to help us with resources are rare and profoundly appreciated <br>
    <br>
    If you hit your article and image limit please recycle. Both the public and search engines like new or updated articles. You can re-use your article and image quota by deleting or editing your old articles<br>
    <br>
    <strong>Broadcast Publishing</strong><br>
    Where in select categories you can publish into STATE or AUSTRALIA  locations. Content published to these location tags appears through ALL 1000 + Australian Regional Network websites throughout the entire country. This power is available with National Business Memberships in select commercial categories<br>
    This instant web broadcast power is a unique Australian Regional Network facility!<br>
    If you want to tell the country about your issue great, however Please don't use it to Spam or be Naughty<br>
    <br>
    <strong>Smart Ad Quotas</strong>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Create and maintain up to 5 Business Smart Ads</p>
    Use the Ads menu above to publish Smart Ads into the Commercial and Community Advertising Categories through all 1000+ Websites, you might find other relevant portals to publish Ads into by using the MOVE menu above.<br>
    Generally One Ad in an appropriate directory/category is enough to attract Search Engine attention to your organisation, If you do create multiple Ads keep in mind unique content is better search engine food<br>
    Ads will publish by default to you Home portal through it's location tag which you may find in the bottom left corner of all ARN Websites, Your Google Maps will home here too. Use the MOVE menu to set your Home and default to other geographies in the network<br>
    <br>
    The Community Portals are about sharing your ideas, point of view and valuable community knowledge with the thousands of Australian and International visitors that come through the network each day, therefore contribute Quality not Quantity, Stunning Images to showcase your region, and Articles that are important and worth reading, please show us your best!<br>
    <font color="CC0000">THANKYOU FOR SUPPORTING THE AUSTRALIAN REGIONAL NETWORK</font> <br>
    <br>
    <strong>Local Business members can upgrade to <a href="{{ route('nationalbusiness') }}">National Business</a> Membership at any time</strong><br>
    <br>
    The rules of all membership programs also includes our site <a href="http://{{ $homeurl }}/Terms-of-use.php">Terms of use</a><br>
    @elseif($level == "Emergency Services") <br>
    ## Emergency Services Member Identified <br>
    <br>
    Content TBA<br>
    @else <br>
    ## Member Level Unidentified - Please Notify Support <br>
    @endif </div>
</div>
@endsection