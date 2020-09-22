<!DOCTYPE html>
<html lang="en">
	<head>		
	    @include('partials.head')
	</head>
	<body>
		@include('partials.firstbody')
		<header class="header">
			@include('partials.header')
		</header>
		@include('partials.front.navbar')
		<div class="main">
      		<article class="article">   
          		<div class="container-fluid">
                    <div class="row">
                    	@yield('content')
                    </div>
                </div>  
		    </article>
		    <nav class="lefttiles">
		    	@include('partials.lefttiles')
		    </nav>
		</div> 
		<footer class="footer"> 
			@include('partials.footer')
		</footer>
		@include('partials.lastbody')
	</body>
</html>
