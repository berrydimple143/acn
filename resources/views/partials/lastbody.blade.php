<script src="/js/pushy.min.js"></script>

<!--
Virgil I think these are duplicate and the Pushy Menu is now /css/networkmenu.css so I will disable these 
<link rel="stylesheet" href="/css/normalize.css">
<link rel="stylesheet" href="/css/site.css?v=1.1.0">
        <!-- Pushy CSS 
<link rel="stylesheet" href="/css/pushy.css?v=1.1.0">
-->
<?php $rl = session('server');?>
<nav class="pushy pushy-right" data-focus="#first-link">
  <div class="pushy-content">
    <ul>
      <li class="pushy-submenu">
        <h2 class="">Network Menu</h2>
        <ul>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/index.php">HOME</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Login.php">LOGIN</a></li>
          <li class="pushy-link"><a href="https://australianregionalnetwork.com" rel="nofollow">Network Map</a></li>
        </ul>
      </li>
      <li class="pushy-submenu">
      <hr>
        <h2 class="">Advertiser Info</h2>
        <ul>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/LIST-YOUR-BUSINESS.php"><strong>LIST YOUR BUSINESS</strong></a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/LIST-YOUR-EVENT.php"><strong>LIST YOUR EVENT</strong></a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/FREE-Community-Ads">FREE Community Ads</a></li>
          <ul>
            <li class="pushy-link"><a href="http://<?php echo $rl; ?>/How-to-create-a-Smart-Ad.php">How to create a Smart Ad</a></li>
            <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Example-Ads.php">Example Ads</a></li>
            <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Advertising-Code-Regulations.php">Advertising Code & Regulations</a></li>
            <li class="pushy-link"><a href="http://<?php echo $rl; ?>/LIST-YOUR-BUSINESS.php">Advertise Here</a></li>
          </ul>
        </ul>
      </li>
      <li class="pushy-submenu">
      <hr>
        <h2 class="">Site Info</h2>
        <ul>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/About-this-Site.php">About This Website</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/About-us.php">About us</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Help-us.php">Help us</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Contact-us.php">Contact us</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/Suggestions.php">Suggestion Box</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/FAQ.php">Frequently Asked Questions</a></li>
          <li class="pushy-link"><a href="http://<?php echo $rl; ?>/View-Background.php">View Background</a></li>
        </ul>
      </li>
      <li class="pushy-submenu">
        <hr>
        <ul>
          <li class="pushy-link"><a href="<?php echo $_SERVER['REQUEST_URI']; ?>">EXIT MENU</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <div align="center">
<img src="https://login.ausreg.net/commonimages/logos/AustralianMade.png"/></div>
<div align="center"><strong>Australia's Town and City Network</strong></div>
</nav>

<?php
$bgcreditstring = session('bgcreditstring');
$bgcrediturl = session('bgcrediturl');
if (!empty($bgcreditstring))
{

echo '<div class = "credit" >';

if (!empty($bgcrediturl)){

# Is is a http link?

if(substr($bgcrediturl, 0, 4) == "http") {
echo '<a href="' . $bgcrediturl . '" target="_blank">' . $bgcreditstring . '</a>';	
}
# Deposit Photo Source - Refer to Affiliate Program
if(substr($bgcrediturl, 0, 2) == "DP") {
echo $bgcreditstring . '<br>';
echo '<!--googleoff: index-->';	
echo '<a href="https://depositphotos.com?ref=5698274" target="_blank" rel="nofollow">Download This Photo</a>';	
echo '<!--googleon: index-->';	
}

# For Public Domain Photos
if(substr($bgcrediturl, 0, 2) == "PD") {
echo $bgcreditstring . '<br>';
echo '<!--googleoff: index-->';	
echo '<a href="https://creativecommons.org/publicdomain/zero/1.0" target="_blank" rel="nofollow">Public Domain</a>';	
echo '<!--googleon: index-->';	
}

} else {
echo $bgcreditstring;
}


echo '</div>';

}
?>

<?php
# Disabled the Stat Counter in Login
# Stat Counter
# $path = "/var/www/html/44/common/Counter.php";
# if (file_exists($path)){
# include($path);
# }else{
# $errormessage = "WARNING I cannot find the Stats Counter I was expecting " . $path;
# $errorstamp = "SITE " . $_SERVER['HTTP_HOST'] . " FILE " . $_SERVER['SCRIPT_FILENAME'] . " " . date ("D M j G:i:s T Y",time());
# $error = $errormessage . "<br>" . $errorstamp . "<br>" . "<hr>" . "\r\n";

/*$logfile = "/var/www/html/australianregionalnetwork.com/control/errors/errors.htm";
$handle = fopen($logfile, 'a+');
fwrite ($handle, $error);
fclose($handle);*/
# }
?>

<!-- ============= Outdated Browser ============= -->
<div id="outdated"></div>

<!-- javascript includes --> 
<script src="/outdatedbrowser/outdatedbrowser.min.js"></script> 

<!-- plugin call --> 
<script>
        //event listener form DOM ready
        function addLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = func;
            } else {
                window.onload = function() {
                    if (oldonload) {
                        oldonload();
                    }
                    func();
                }
            }
        }
        //call function after DOM ready
        addLoadEvent(function(){
            outdatedBrowser({
                bgColor: '#f25648',
                color: '#ffffff',
                lowerThan: 'transform',
                languagePath: '../outdatedbrowser/lang/en.html'
            })
        });
</script>