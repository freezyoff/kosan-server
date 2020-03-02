<div class="row">
	<div class="col-sm-3 d-flex align-items-center"  onclick="window.location='{{url("")}}'">
		<div class="d-inline-block text-light" style="font-size:1rem !important"><i class="fas fa-bars"></i></div>
		<div class="d-inline-block brand" style="font-size:1.5rem !important">
			<span class="cursor-pointer">Kos</span><span class="unique cursor-pointer">a</span><span class="cursor-pointer">n</span>
		</div>
	</div>
	<div class="col d-flex justify-content-end align-items-center">
		@yield("body.topnav")
		@stack("body.topnav")
	</div>
</div>