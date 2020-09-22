<div class="primary-header-container">
  <div class="left-header-container"> 
    <!-- Rorate Header -->
    
    <?php

    # Gazzcode - uses images in /commonimages/header

    # find out which image should be shown

    $number_of_images = 1;  // change it as you wish...

    date_default_timezone_set('Australia/Sydney');
    $jd=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
    $day = (jddayofweek($jd,1)); 

    # Kangaroo has balls only on a Sunday (For Competitions)
    if ($day == 'Sunday'){
    $number_of_images = $number_of_images + 1;
    }

    $imagefilename = 'Australia' . (((time()/30)%$number_of_images)+1).'.png';

    echo '<a href="http://skippycoin.com" rel="nofollow" target="_blank"><img src="/commonimages/header/'. $imagefilename . '" alt="' . session('localname') . ' Skippycoin ICG" title="' . session('localname') . ' Skippycoin ICG" align="left"/></a>';

    # For Fixing the Image
    #echo '<img src="/commonimages/header/Australia3.png" alt="Australia"  align="left"/>';

    ?>
  </div>
  <div class ="center-header-container">
    <div class="header-title">
      <?php
	# Study some of the Long Strings to get a good number here
	if (strlen(session('localname')) < 25){
	echo '<h1 class="wild-white"><!-- Localname -->' . session('localname') . '</h1>';
	} else {
	echo '<h2 class="wild-white"><!-- Localname -->' . session('localname') . '</h2>';
	}
	?>
    </div>
    <div class="header-state">
      <h2 class="wild-white"><!-- Longstate -->{{ session('longstate') }}</h2>
    </div>
    <div class="header-domain">
      <h3 class="wild-red"><!-- server -->
        <?php $flashdomainname = strtoupper(session('url')); echo $flashdomainname; ?>
      </h3>
    </div>
    <div class="header-info">
      <h4 class="wild-white"><!-- info.txt -->
        <?php
      $printinfoline = "Community, Business and Visitor Information Portal"; 
      if (strpos($flashdomainname, 'GUIDE') !== false) { $printinfoline = "Community, Business and Visitor Guide"; }
      if (strpos($flashdomainname, 'CITY') !== false) { $printinfoline = "Community, Business and Visitor City Information"; }
      if (strpos($flashdomainname, 'TOWN') !== false) { $printinfoline = "Community, Business and Visitor Town Portal"; }
	  if (strpos($flashdomainname, 'LINK') !== false) { $printinfoline = "Linking Community, Business and Visitors"; }
      echo $printinfoline;
      ?>
      </h4>
    </div>
  </div>
  <div class ="right-header-container">
    <div class="flag-group-container">
      <div class="header-leftofflag">
        <?php $currentpage = $_SERVER['REQUEST_URI'];
		if($currentpage !== "/Login.php") {
		echo '<img title="Australia"
                 border="0"
                 alt="Australia"
                 src="/commonimages/icons/leftofflag.png">';}
			?>
      </div>
      <div class="header-flag"> <img title="Australia"
                 border="0"
                 alt="Australia"
                 src="/images/flag.gif"> </div>
    </div>
    <div class="login-group-container">
      <div class="header-login"> <br>
        <div class="login-group-container">
          <div class="header-arrow"> @if(session('loggedin') == "yes") <img src="/commonimages/arrows/redsidewinderleftdark.gif" title="Get Skippycoin Here" alt="" align="right" /> @else 
            &nbsp;
            @endif 
          </div>
          <div class="header-login"> 
            <!-- Login Rollover --> 
            <a href="https://skippybook.com"
         rel="nofollow"><img title="Login (Create an acount)"
         target="blank"
         border="0"
         alt="Login Here"
         src="/commonimages/header/login-button-skippycoin.png"
         onmouseout="this.src='/commonimages/header/login-button-skippycoin.png'"
         onmouseover="this.src='/commonimages/header/login-button-skippycoin-selected.png'"> </a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
