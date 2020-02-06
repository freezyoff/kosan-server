<!DOCTYPE html>
<html lang="id">
	<head>
		
		<meta charset="UTF-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		@yield("meta")
		@stack("meta")
		<title class="brand">Kosan</title>
		
		<link rel="stylesheet" href="{{mix('/css/app.css')}}" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" crossorigin="anonymous" />
		@yield("styles")
		@stack("styles")
		@stack("style")
		
		<script src="{{url('js/app.js')}}"></script>
		@yield("script")
		@stack("script")
		
	</head>
	<body @yield("body.attr", "")>
		@yield("body")
		@stack("body")
		<script>
			$(document).ready(function(){
				$('body').css('min-height', $(window).height());
				@yield('script.ready')
				@stack('script.ready')
			});
		</script>
	</body>
</html>