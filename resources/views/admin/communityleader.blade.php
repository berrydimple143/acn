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
  <div class="panel-body"> @if($level == "Local Resident") 
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
    <h1 align="center"><font color="003399">Community Leader Accounts</font></h1>
    <br>
    Community Leader accounts unleashes weblinks and allows you to publish quota of full service Articles, Ads and Events into the Community Leader categories through any of the 1000+ Australian Town and City websites in the ARN. This level is best for promoting a Community Group or Public Service organisation. Cheapest Gold coin level subscription or this level is FREE if you are sponsored by an active Business member <br>
    <br>
    <div id="div1" class="buttons" align="center">
      <h3>Cost?</h3>
      <br>
      $12 per year or $2 per month<br>
      Or 100% FREE account - Please explore the options below<br>
      <?php if ($skippycoin == 'on')
		{
		echo '<br><font color="cc0000">Until further notice..</font> Paid CL Memberships can accumulate emerging Australian <a href="https://skippycoin.com" target="_blank">Skippycoin</a><br>Currently 273,973 Bean per day or 1 SKC per year<br>';
		}
	?>
      <br>
      <h3 align="center">What Membership might interest you?</h3>
      <br>
      <table align="center" border="0">
        <tr>
          <td><div align="center"><a class="button" id="showdiv2">
              <button type="button" class="btn btn-primary btn-sm" >$2 Monthly</button>
              </a><br>
              <br>
            </div></td>
          <td><img src="{{ $img1 }}" width="96" height="24" align="left" /><br>
            <br></td>
        </tr>
        <tr>
          <td><div align="center"><a class="button" id="showdiv3">
              <button type="button" class="btn btn-primary btn-sm" >$12 Annual</button>
              </a><br>
              <br>
            </div></td>
          <td><img src="{{ $img1 }}" width="96" height="24" align="left" /><br>
            <br></td>
        </tr>
        <tr>
          <td><div align="center"><a class="button" id="showdiv4">
              <button type="button" class="btn btn-primary btn-sm" >Free Options</button>
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
      <strong>Community Leader Subscription $2 per month</strong> {!! Form::open(['route' => 'process.pay', 'method' => 'POST']) !!}
      <input type="hidden" name="cmd" value="_xclick-subscriptions" />
      <input type="hidden" name="business" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="item_name" value="Community Leader Membership" />
      <input type="hidden" name="item_number" value="Community Leader" />
      <input type="hidden" name="on0" value="Member">
      <input type="hidden" name="os0" value="{{ $cid }}">
      <input type="hidden" name="image_url" value="https://australianregionalnetwork.com/commonimages/logos/Australian-Regional-Network.png">
      <input type="hidden" name="currency_code" value="AUD" />
	  <input type="hidden" name="a1" value="2.00" />
      <input type="hidden" name="p1" value="1" />
      <input type="hidden" name="t1" value="M" />
      <input type="hidden" name="a2" value="" />
      <input type="hidden" name="p2" value="" />
      <input type="hidden" name="t2" value="" />
      <input type="hidden" name="a3" value="2.00" />
      <input type="hidden" name="p3" value="1" />
      <input type="hidden" name="t3" value="M" />
      <input type="hidden" name="return" value="http://{{ $homeurl }}/Subscriber-Thankyou.php" />
      <input type="hidden" name="cancel_return" value="http://{{ $homeurl }}/Subscriber-Cancel.php" />
      <input type="hidden" name="src" value="1" />
      <input type="hidden" name="sra" value="1" />
      <input type="hidden" name="receiver_email" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="mrb" value="R-3WH47588B4505740X" />
      <input type="hidden" name="pal" value="ANNSXSLJLYR2A" />
      <input type="hidden" name="no_shipping" value="1" />
      <input type="hidden" name="no_note" value="1" />
      <input type="hidden" name="on1" value="Qualification">
      <input type="hidden" name="subscription" value="monthly" />
      <input type="hidden" name="price" value="2" />
      <br>
      Why do you Qualify?<br />
      <select name="os1">
        <option value="Organisation Official">Community Organisation Official
        <option value="Public Official">Public Official
        <option value="Australian over 55 years">Australian over 55 years
        <option value="Local Historian">Local Historian
        <option value="Journalist or Editor">Journalist or Editor
        <option value="Amateur Journalist or Writer">Amateur Journalist or Writer
        <option value="Photographer">Photographer
        <option value="Other">Other
      </select>
      <br>
      <input type="hidden" name="on2" value="Comments">
      <textarea type="hidden" name="os2" maxlength1="200"  id="comments1"cols="40" rows="5"  onkeyup="calculateDiscussCommentsRemainingChars1(); return ismaxlength_discussComments1(this);" onclick="clearComments1(); ">Please Elaborate...</textarea>
      <br />
      <span id="discussCommentsRemainingChars1" style="font-size: 9px; margin: 3px 0px 0px 20px; text-align:center;"> 200 characters remaining </span><br>
      <br>
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
      <br>
      <div class="application" align="center"> <a href="{{ route('communityleader') }}">
        <button type="button" class="btn btn-primary">Other Community Leader Membership</button>
        </a> </div>
      Or Show Me<br>
      <div class="application" align="center"><a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Local Business Membership</button>
        </a><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">National Business membership</button>
        </a></div>
    </div>
    <div id="div3" style="display:none;" align="center">
      <h2>Annual Subscription</h2>
      <strong>Community Leader Subscription $12 per Year</strong> {!! Form::open(['route' => 'process.pay', 'method' => 'POST']) !!}
      <input type="hidden" name="cmd" value="_xclick-subscriptions" />
      <input type="hidden" name="business" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="item_name" value="Community Leader Membership" />
      <input type="hidden" name="item_number" value="Community Leader" />
      <input type="hidden" name="on0" value="Member">
      <input type="hidden" name="os0" value="{{ $cid }}">
      <input type="hidden" name="image_url" value="https://australianregionalnetwork.com/commonimages/logos/Australian-Regional-Network.png">
      <input type="hidden" name="currency_code" value="AUD" />
      <input type="hidden" name="a1" value="12.00" />
      <input type="hidden" name="p1" value="1" />
      <input type="hidden" name="t1" value="Y" />
      <input type="hidden" name="a2" value="" />
      <input type="hidden" name="p2" value="" />
      <input type="hidden" name="t2" value="" />    
      <input type="hidden" name="a3" value="12.00" />
      <input type="hidden" name="p3" value="1" />
      <input type="hidden" name="t3" value="Y" />
      <input type="hidden" name="return" value="http://{{ $homeurl }}/Subscriber-Thankyou.php" />
      <input type="hidden" name="cancel_return" value="http://{{ $homeurl }}/Subscriber-Cancel.php" />
      <input type="hidden" name="src" value="1" />
      <input type="hidden" name="sra" value="1" />
      <input type="hidden" name="receiver_email" value="<?php echo $paypal_email; ?>" />
      <input type="hidden" name="mrb" value="R-3WH47588B4505740X" />
      <input type="hidden" name="pal" value="ANNSXSLJLYR2A" />
      <input type="hidden" name="no_shipping" value="1" />
      <input type="hidden" name="no_note" value="1" />
      <input type="hidden" name="on1" value="Qualification">
      <input type="hidden" name="subscription" value="annual" />
      <input type="hidden" name="price" value="12" />
      <br>
      Why do you Qualify?<br />
      <select name="os1">
        <option value="Organisation Official">Community Organisation Official
        <option value="Public Official">Public Official
        <option value="Australian over 55 years">Australian over 55 years
        <option value="Local Historian">Local Historian
        <option value="Journalist or Editor">Journalist or Editor
        <option value="Amateur Journalist or Writer">Amateur Journalist or Writer
        <option value="Photographer">Photographer
        <option value="Other">Other
      </select>
      <br>
      <input type="hidden" name="on2" value="Comments">
      <textarea type="hidden" name="os2" maxlength="200"  id="comments2"cols="40" rows="5"  onkeyup="calculateDiscussCommentsRemainingChars2(); return ismaxlength_discussComments2(this);" onclick="clearComments2(); ">Please Elaborate...</textarea>
      <br />
      <span id="discussCommentsRemainingChars2" style="font-size: 9px; margin: 3px 0px 0px 20px; text-align:center;"> 200 characters remaining </span><br>
      <br>
      <br>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="40%">&nbsp;</td>
          <td width="10%"><input type="image" name="submit" src="https://www.paypalobjects.com/en_AU/i/btn/btn_subscribeCC_LG.gif" border="0" alt="Make payments with PayPal, it's fast, free, and secure!" /></td>
          <td width="40%"><img src="{{ $img1 }}" width="96" height="24" align="left" /></td>
        </tr>
      </table>
      <br>
      <img alt="" border="0" src="http://www.paypal.com/images/verification_seal.gif"> {!! Form::close() !!}
      </p>
      <br>
      <br>
      <div class="application" align="center"> <a href="{{ route('communityleader') }}">
        <button type="button" class="btn btn-primary">Other Community Leader Membership</button>
        </a> </div>
      Or Show Me<br>
      <div class="application" align="center"><a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Local Business Membership</button>
        </a><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">National Business membership</button>
        </a></div>
    </div>
    <div id="div4" style="display:none;">
      <h2 align="center">Sponsorship Options </h2>
      <br>
      <strong>100% Free is a great idea for Community Advertising</strong><br>
      <div align="left"> Sponsorship is where the ARN can help. That is connecting Commuity Groups with Local and National Business, sharing contact information and helping each other. When a Local Business sponsors you a "Sponsored By" link appears at the base of your published content, the Sponsorship Key Shares contact details, Gives you a free membership and links you under the Business wing. The business owner is subsidising your account and whatever private donations you negotiate with the business is up you, the ARN helps you set up a base relationship. <br>
        <br>
        <strong> HOW?</strong> Visit the Sponsorship pages and enter the Key given to you by your sponsoring Local Business or National Business Member <br>
        <br>
        <strong>TIP:</strong> If you would like to be sponsored, you might contact a Business member who is displaying Smart Ads through the commercial directories on this web site e.g. the Trades and Services or Automotive or Diretories, ask them to sponsor you as they can generate Community Leader Membership Keys within their upgraded account, this is a Win Win<br>
        <br>
        <strong>100% FREE:</strong> If you can't find a Sponsor and really want the FREE account the Network will Sponsor you. Complete your <a href="{{ route('settings') }}">Account Settings</a> with your Organisation Details then request a Community Leader account via <a href="mailto:admin@australianregionalnetwork.com?subject=Customer%20ID%20{{ $cid }}%20requesting%20Local%20Business%20Membership">admin@australianregionalnetwork.com</a> Please include your Member ID which is <strong>{{ $cid }}</strong><br>
        <br>
        <font color="003399">Subscription at gold coin level is a way to get started if you just want to get your Community Ad in. You can change to Sponsorship later by entering the Key received from your local business sponsor and we will move you under their wing with a free account.</font> <br>
        <br>
        <strong>CONSIDER:</strong> Business members are often involved leading community organisations and can publish into the community directories (Within the rules) if you also want access to the commercial directories <a href="{{ route('localbusiness') }}">Local&nbsp;Business</a> and <a href="{{ route('nationalbusiness') }}">National&nbsp;Business</a> Memberships may be an account option. If a genuine not for profit relationship between your business and community group exists as a marketing strategy you might sponsor your seperate community account under your business account for backlink and kudos advantage - Then "Sponsored By" REL=FOLLOW backlinks will automatically appear in your Community content, this is a SEO strategy we beleive is within Google Webmaster Guidelines<br>
      </div>
      <br>
      <br>
      <div class="application" align="center"> <a href="{{ route('communityleader') }}">
        <button type="button" class="btn btn-primary">Other Community Leader Membership</button>
        </a> </div>
      <div align="center">Or Show Me</div>
      <div class="application" align="center"><a href="{{ route('localbusiness') }}">
        <button type="button" class="btn btn-primary">Local Business Membership</button>
        </a><a href="{{ route('nationalbusiness') }}">
        <button type="button" class="btn btn-primary">National Business membership</button>
        </a></div>
    </div>
    @elseif($level == "Community Leader")
    <center>
      <h2><strong>Community Leader Membership Guide and Rules</strong></h2>
    </center>
    <br/>
    <strong>The Community Portals are assembled from the individual article and image galleries of it's members.</strong> <br>
    With more control over your contributed content you decide what is published and where and when it will appear, likewise you can remove your content at any time <br>
    <br>
    <strong>Under your membership You publish instantly and with that agree to take responsibility for what you publish</strong> <br>
    We reserve the right to remove content that causes complaints, problems or is outside the spirit of the network.<br>
    Please do good and play fair. Most new content and updates are followed by our admin team. Putting forward your point of view is welcome though if you are mean or do bad things or break the law we may lock out your account and cancel your membership<br>
    <br>
    <strong>Removing your images, articles, ads and events etc. means flagging it for removal from our online service. </strong><br>
    It is our intent that you have utmost control over your contributed content, however be aware that your contributions may remain cached or with backups until these are purged, internet crawlers and services outside our control such as Search Engines or likes of the Way Back Machine may keep permanent copies you will need to talk to those scraping providers if you have a removal issue. If you published it, you flagged it for removal, we removed it, then if someone else saw it or copied it that is not our fault. We advise this is just the same with other social media providers ss a general rule of thumb never publish anything to the internet you may regret later. Go with good and helpful content and all will surely be fine<br>
    <br>
    <strong>Before we use your outstanding articles or images to promote the network we will seek your permission.</strong><br>
    However: Some ARN self promotion is automatic for example your Ads may appear in "Latest Items", Front page or as <a href="http://{{ $homeurl }}/Example-Ads.php" rel="nofollow" target="_blank">examples</a> to others, we hope this can be to your benefit if there is any issues with that we would like to hear your feedback<br>
    <br>
    <strong>Content Quotas</strong> <br>
    <p>To give all Community Leader members a fair go we set some limits </p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Create and maintain up to 50 articles</p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Upload up to 100 images</p>
    As we can fund the project we may raise these limits.<br>
    <br>
    If you hit your article and image limit please recycle. Both the public and search engines like new or updated articles. You can re-use your article and image quota by deleting or editing your old articles, Fresh content may improve your traffic<br>
    <br>
    <strong>Broadcast Publishing</strong><br>
    Where in select categories you can publish into STATE or AUSTRALIA  locations. Content published to these location tags appears through ALL 1000 + Australian Regional Network websites throughout the entire country. This power is also available with Business Memberships in select commercial categories<br>
    This web broadcast feature is a unique Australian Regional Network facility! to our knowledge nobody else does this<br>
    If you want to tell the country about your issue great, however Please don't use it to Spam or be Naughty<br>
    <br>
    <strong>Smart Ads and Events</strong>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $bullet }}" /> Quotas: Create and maintain up to 5 Ads and 5 Events</p>
    Use the Ads and Events menu above to publish into the Community Advertising Categories through all 1000+ Websites, you might find other relevant portals to publish Ads into by using the MOVE menu above.<br>
    Generally One Ad or Event in an appropriate directory/category is enough to attract Search Engine attention to your organisation, If you do create multiple Ads keep in mind unique content with relevant key words and phrases is better search engine food<br>
    Create your Events well in advance (at least 1 month) the site will automatically generate metadata inviting Search Engines to Index your content, you can put content in years in advance, you can create Articles with release and expire date control, events will move towards the top event directories as your event aproches<br>
    <br />
    <strong>Static Links</strong><br>
    Your Content has static links that allows it to be found through Backlinks and Search Engines even if it automatically moves within the site structure. Organic Relevant Linking to your Ad, Article or Event from your Business Website or Social Media is a way to imrove traffic, Search Engines become aware of and follow these paths. Dont abuse this as Search Engines may also penalise too many or irrelevant backlinks as a rule of thumb never put a backlink in a Broadcast Ad the WEBSITE button in Broadcast Ads is flagged "rel=nofollow" for this reason. The reverse is a better strategy, to draw organic search engine attention link "to" your Ad, Event or Article from your website, one easy example of this is backlinks through Likes of your content to Social Media, Telling some friends about your content can trigger the Win Win<br>
    <br>
    <strong>Home portal and Current Portal</strong><br>
    Take some time to understand this simple menu your Ads will publish by default to you Home Portal through it's location tag which you can find in the bottom left corner of all ARN Websites or in your STATUS dropdown menu, Your Google Maps will home to the region where you are publishing. If you have moved to a new town or city in the network content published will default to your Current Portal. Once logged in you are logged in to the Entire Network, you can traverse the network and publish wherever you like or publish into other towns from your Home location. Use the MOVE menu to Move to other geographies in the network, your Home default is best set to your Home town even if you are creating content in another region. Please only publish content that is relevant to the citizens of the region<br>
    <br>
    The Community Portals are about sharing your ideas, point of view and valuable community knowledge with the thousands of Australian and International visitors that come through the network each day, therefore contribute Quality not Quantity, Good Images to showcase your region, and Articles that are important and worth reading, please show us your best<br>
    <br>
    <font color="CC0000">THANKYOU FOR SUPPORTING THE AUSTRALIAN REGIONAL NETWORK</font> <br>
    <br>
    <br>
    </a> <strong>Community Leader's can upgrade to <a href="{{ route('localbusiness') }}">
    <button type="button" class="btn btn-primary btn-sm" >Local Business</button>
    </a> or <a href="{{ route('nationalbusiness') }}">
    <button type="button" class="btn btn-primary btn-sm" >National Business</button>
    </a> Membership at any time</strong><br>
    <br>
    The rules of all membership programs also includes our site <a href="http://{{ $homeurl }}/Terms-of-use.php">Terms of use</a> <br>
    @elseif($level == "Emergency Services") <br>
    ## Emergency Services Member Identified <br>
    <br>
    Content TBA<br>
    @else <br>
    ## Member Level Unidentified - Please Notify Support <br>
    @endif <br>
    <div class="application" align="center"> <a href="{{ route('membership') }}">
      <button type="button" class="btn btn-primary">Go Back to Membership</button>
      </a> </div>
  </div>
</div>
@endsection