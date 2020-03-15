<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	@yield("meta")
	@stack("meta")
	
	<title>Kosan</title>
	
	<!-- Begin: Fonts and icons -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{url('img/apple-icon.png')}}">
	<link rel="icon" type="image/png" href="{{url('img/favicon.png')}}">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{url('vendor/material-dashboard/css/material-dashboard.min.css?v=2.1.0')}}" />
	<link rel="stylesheet" href="{{url('css/brand.css')}}" />
	<!-- End: Fonts and icons -->
	
	<!-- Begin: styles -->
	@yield("styles")
	@stack("styles")
	@yield("style")
	@stack("style")
	<!-- End: styles -->
	
</head>
<body class="">
	<div class="wrapper ">
		<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{url('vendor/material-dashboard/img/sidebar-2.jpg')}}">
			<div class="logo">
				<a href="{{url("")}}" class="simple-text logo-normal brand" style="font-size:1.7rem">
					Kos<span class="unique cursor-pointer">a</span>n
				</a>
			</div>
			<div class="sidebar-wrapper">
				<ul class="nav">
					@yield("nav-item")
					@stack("nav-item")
				</ul>
			</div>
		</div>
    
		<div class="main-panel">
		
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
				<div class="container-fluid">
					<div class="navbar-wrapper">
						@stack('navbar-brand')
						@yield('navbar-brand')
					</div>
					<button class="navbar-toggler" 
						type="button" 
						data-toggle="collapse" 
						aria-controls="navigation-index" 
						aria-expanded="false" 
						aria-label="Toggle navigation">
						<span class="sr-only">Toggle navigation</span>
						<span class="navbar-toggler-icon icon-bar"></span>
						<span class="navbar-toggler-icon icon-bar"></span>
						<span class="navbar-toggler-icon icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end"></div>
				</div>
			</nav>
			<!-- End Navbar -->
		
			<!-- Begin Content -->
			<div class="content">
				<div class="container-fluid">
					@stack('content')
					@yield('content')
				</div>
			</div>
			<!-- End Content -->
		
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright float-right">
						&copy; 
						<a href="https://www.creative-tim.com" target="_blank">Kosan.co.id</a> 
						{{date("Y")}}
					</div>
				</div>
			</footer>
			
		</div>
	</div>
  
	<!-- Begin: scripts -->
	<script src="{{url('vendor/material-dashboard/js/core/jquery.min.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/core/popper.min.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/core/bootstrap-material-design.min.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/plugins/chartist.min.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/plugins/bootstrap-notify.js')}}"></script>
	<script src="{{url('vendor/material-dashboard/js/material-dashboard.js?v=2.1.0')}}"></script>
	@yield("script")
	@stack("script")
	@yield("scripts")
	@stack("scripts")
	<!-- End: scripts -->
</body>

</html>