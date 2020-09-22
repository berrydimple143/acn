<nav class="topnavbar navbar navbar-inverse">
  <div class="container-fluid">		  
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#arn-navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="arn-navbar">
      <ul class="nav navbar-nav">		        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Images <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('photos') }}" class="dropdown-item"><i class="fa fa-image"></i>&nbsp; Photos</a></li>            	
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('banners') }}" class="dropdown-item"><i class="fa fa-bookmark"></i>&nbsp; Banners</a></li>            
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('portraits') }}" class="dropdown-item"><i class="fa fa-users"></i>&nbsp; Portraits</a></li>                        
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('logos') }}" class="dropdown-item"><i class="fa fa-paw"></i>&nbsp; Logos</a></li>			
          </ul>
        </li>
        <li><a href="{{ route('articles') }}" class="nav-link">Articles</a></li>
        <li><a href="{{ route('advertisements') }}" class="nav-link">Advertisements</a></li>
        <li><a href="{{ route('events') }}" class="nav-link">Events</a></li>
        <li><a href="{{ route('move') }}" class="nav-link">Move</a></li>        
      </ul>		      
      <ul class="nav navbar-nav navbar-right">		        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Status <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a><i class="fa fa-signal"></i>&nbsp; Membership: {{ session('user')->customer_level }}</a></li>
            <li><a><i class="fa fa-user"></i></span>&nbsp; Member ID: {{ session('user')->customer_id }}</a></li>
            <li><a><i class="fa fa-map-marker"></i>&nbsp; Current Portal: {{ session('location') }}</a></li>
			<li><a><i class="fa fa-map-marker"></i>&nbsp; Home Portal: {{ session('user')->customer_homeportal }}</a></li>			
          </ul>
        </li>
		<?php 
			$username = session('user')->customer_name;
			if(session('user')->customer_nickname != null || session('user')->customer_nickname != '') {
				$username = session('user')->customer_nickname;
			}
		?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, <?php echo $username; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('profile') }}"><i class="fa fa-list"></i>&nbsp; Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('settings') }}"><i class="fa fa-wrench"></i>&nbsp; Account Settings</a></li>
            <li role="separator" class="divider"></li>
			<li><a href="{{ route('skippycoin') }}"><i class="fa fa-certificate"></i>&nbsp; Skippycoin</a></li>			
			@if(session('user')->customer_level == "Administrator")
				<li role="separator" class="divider"></li>				
				<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-paypal"></i>&nbsp; Manage Paypal</a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('manage.paypal.sandbox') }}" class="dropdown-item">Sandbox</a></li>            	
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('manage.paypal.live') }}" class="dropdown-item">Live</a></li>
					</ul>
				</li>				
            @endif
			<li role="separator" class="divider"></li>
            <li><a href="{{ route('logout') }}" id="logout"><i class="fa fa-power-off"></i>&nbsp; Sign Out</a></li>	           
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>	
<style>
	.topnavbar { max-width: 960px; margin: 0 auto; }
</style>
