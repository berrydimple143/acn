<button class="menu-btn">&#9776;&nbsp;&nbsp;Network&nbsp;Menu</button>
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
array("http://" . $rl . "/Tourism.php.php","tourism-off.png","tourism-on.png"),
array("http://" . $rl . "/Food-and-Wine.php","food-and-wine-off.png","food-and-wine-on.png"),
array("http://" . $rl . "/Accommodation.php","accommodation-off.png","accommodation-on.png")
);

foreach($tiles as $tile){
echo '<div class="tile"><a href="' . $tile[0] . '"><div align="center"><img src="/commonimages/tiles/' . $tile[1] . '" onmouseover="this.src=\'/commonimages/tiles/' . $tile[2] . '\'" onmouseout="this.src=\'/commonimages/tiles/' . $tile[1] . '\'" /></div></a></div>';
}
?>
</div>