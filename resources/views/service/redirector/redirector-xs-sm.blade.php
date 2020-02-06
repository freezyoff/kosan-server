<div class="h-100">
	<div class="container d-flex h-100 justify-content-center align-items-center">
		<div class="d-flex flex-column justify-content-center mb-5">
			
			<div class="col brand cursor-pointer text-center mx-auto" 
				style="font-size:2.2rem !important" 
				onclick="window.location='{{url("")}}'">Kos<span class="unique">a</span>n
			</div>
			
			<div class="brand-tag text-center mx-auto mb-4" style="margin-top:-.5rem">Manage with ease</div>
			@if (isset($message) && $message)
			<p class="text-center mb-4">{{$message}}</p>
			@endif
			<div class="text-center">
				<div class="spinner-border text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('body').css('height', $(window).height());
</script>