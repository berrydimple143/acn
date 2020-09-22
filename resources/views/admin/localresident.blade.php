@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading"> <img src="{{ asset('images/Australian-Regional-Network-Trans.png') }}" style="WIDTH: 100%" alt="Australian Regional Network Memberships"> </div>
  <div class="panel-body">
    <h1 align="center">Local Resident Membership Guide and Rules</h1>
    <strong>The Community Portals are assembled from the individual article and image galleries of it's members.</strong> <br>
    With more control over your contributed content you decide what is published and where and when it will appear, likewise you can remove your content at any time <br>
    <br>
    <strong>Under your membership You publish instantly and with that agree to take responsibility for what you publish</strong> <br>
    We reserve the right to remove content that causes complaints, problems or is outside the spirit of the community network.<br>
    <br>
    <strong>Local Resident level membership is FREE</strong><br>
    That also means your membership is probationary. Please do good and play fair. Most new content and updates are followed by our admin team. Putting forward your point of view is welcome though if you are mean or do bad things or break the law we may lock out your account and reserve the right to ban you in future and we do not like to do that. Please behave.<br>
    <br>
    <strong>Removing your images, articles, ads and events etc. means flagging it for removal from our online service. </strong><br>
    It is our intent that you have utmost control over your contributed content, however be aware that your contributions may remain cached or with backups until these are purged, internet crawlers and services outside our control such as Search Engines or likes of the Way Back Machine may keep permanent copies you will need to talk to those scrapy providers if you have a removal issue. As a general rule of thumb we advise never publish anything anywhere to the internet you may regret later<br>
    <br>
    <strong>Content Quotas</strong> <br>
    To give all Local Resident members a fair go we set some limits
    </p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $img1 }}" /> Create and maintain up to 10 articles</p>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $img1 }}" /> Upload up to 20 images</p>
    <br>
    As we can fund the project we may raise these limits. If you hit your article and image limit please recycle. Both the public and search engines like new or updated articles. You can re-use your article and image quota by deleting or editing your old articles. Fresh content may improve your traffic<br>
    <br>
    <strong>Broadcast Publishing</strong><br>
    Where in select categories you can publish into STATE or AUSTRALIA  locations. Content published to these location tags appears through ALL 1000 + Australian Regional Network websites throughout the entire country. This power is also available with Business Memberships in select commercial categories<br>
    This web broadcast feature is a unique Australian Regional Network facility! to our knowledge nobody else does this<br>
    If you want to tell the country about your issue great, however Please don't use it to Spam or be Naughty<br>
    <br>
    <strong>Smart Ad Quotas</strong>
    <p>&nbsp;&nbsp;&nbsp;<img src="{{ $img1 }}" /> Create and maintain up to 1 TRIAL Smart Ad and Event</p>
    Use the Ads menu above to publish Smart Ads into the enabled Advertising Categories through all 1000+ Websites, you might find other relevant portals to publish your Ads into by using the MOVE menu above.<br>
    Use the Events menu above to post to the Community Category, to post Business or National Events upgrade to a higher membership
    Ads will publish by default to you Home portal through it's location tag which you may find in the bottom left corner of all ARN Websites, Your Google Maps will home here too. Use the MOVE menu to set your Home and default to other geographies in the network<br>
    <br>
    <strong>Contribute for your benefit</strong><br>
    The Community Portals across all significant towns and cities in country are about sharing your ideas, point of view and valuable community knowledge with the thousands of Australian and International visitors that come through the network each day, therefore contribute Quality not Quantity, Good Images to showcase your region, and Articles that are important and worth reading, please show us your best<br>
    <a href="{{ route('communityleader') }}">Community Leader</a> and <a href="{{ route('localbusiness') }}">Local Business</a> and <a href="{{ route('nationalbusiness') }}">National Business</a> Memberships are allocated more Articles, Ads and Events quota <br>
    <br>
    <strong>If you write great articles we may invite you to become a Community Leader</strong> <br>
    Where in select categories you can publish into STATE or AUSTRALIA  locations. Content published to these location tags appears through ALL 1000 + Australian Regional Network web portals throughout the entire country. This power is also available with Business Memberships and Business Members can sponsor Community Leader members under their wing<br>
    We will be  strict on abuse of this unique facility. Please don't use it to Spam.<br>
    <br>
    <strong> Local Resident members can upgrade to a higher membership at any time.<br>Put the power of 1000+ Australian websites to work on your cause</strong> <br>
    <br>
    The rules of all membership programs also includes our site <a href="http://{{ $homeurl }}/Terms-of-use.php" target="_blank">Terms of use</a> <br>
    <br>
    <div class="application" align="center"> <a href="{{ route('membership') }}"><button type="button" class="btn btn-primary">Back to Membership</button></a> </div>
  </div>
</div>
@endsection