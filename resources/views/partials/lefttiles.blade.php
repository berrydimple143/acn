
<!-- Menu Button -->
<style type="text/css">
.menu-btn {
  background: #222222;
  color: #9D9D9D;
  font-size: 16px;
  padding: 3px;
  margin: 2px;
  border: solid #619eff 1px;
  text-decoration: none;
  min-width: 90%;
  -webkit-border-radius: 6;
  -moz-border-radius: 6;
  border-radius: 6px;
  text-align:center;
}
.menu-btn:hover {
  background: #619eff;
  text-decoration: none;
    color: #ffffff;
	border: solid #000000 1px;
}

.portal-btn {
  background: #222222;
  color: #9D9D9D;
  font-size: 16px;
  padding: 3px;
  margin: 2px;
  border: solid #619eff 1px;
  text-decoration: none;
  min-width: 90%;
  -webkit-border-radius: 6;
  -moz-border-radius: 6;
  border-radius: 6px;
  text-align:center;
}
.portal-btn:hover {
  background: #619eff;
  text-decoration: none;
    color: #ffffff;
	border: solid #000000 1px;
}
</style>

<div align="center">
<button class="menu-btn">&#9776;&nbsp;&nbsp;&nbsp;Network Menu</button>
</div>

<div align="center">
<a href="http://<?php $rl = session('server'); echo $rl; ?>"><button class="portal-btn">Current Portal</button></a>
</div>

<div class="tile-container">
<?php
# TILE MENU - By Gazz
# Put Images into /commonimages/tiles/ at 120x80px use 003399 Base
# Menu Format URL:MOUSEOVERIMAGE:MOUSEOUTIMAGE 
$rl = session('server');
$tiles = array (
array("https://login.ausreg.net/index.php","home-off.png","home-on.png"),
array("http://" . $rl . "/Directories.php","directories-off.png","directories-on.png"),
array("http://" . $rl . "/Events-and-Festivals.php","events-and-festivals-off.png","events-and-festivals-on.png"),
array("http://" . $rl . "/Articles.php","articles-off.png","articles-on.png"),
array("http://" . $rl . "/Trades-and-Services.php","trades-and-services-off.png","trades-and-services-on.png"),
array("http://" . $rl . "/Business.php","business-directory-off.png","business-directory-on.png"),
array("http://" . $rl . "/Community.php","community-directory-off.png","community-directory-on.png"),
array("http://" . $rl . "/Tourism.php","tourism-off.png","tourism-on.png"),
array("http://" . $rl . "/Food-and-Wine.php","food-and-wine-off.png","food-and-wine-on.png"),
array("http://" . $rl . "/Accommodation.php","accommodation-off.png","accommodation-on.png")
);

foreach($tiles as $tile){
echo '<div class="tile"><a href="' . $tile[0] . '"><div align="center"><img src="/commonimages/tiles/' . $tile[1] . '" onmouseover="this.src=\'/commonimages/tiles/' . $tile[2] . '\'" onmouseout="this.src=\'/commonimages/tiles/' . $tile[1] . '\'" /></div></a></div>';
}
?>
</div>
