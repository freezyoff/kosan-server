<div class="card pt-1 pb-1 position-fixed d-flex" 
	style="			
		background-color:#1e1e1e;
		border-radius:0;
		box-shadow: 0 0 5px 1px #717171;
		z-index:999;
		width: 100%;
		top: 0;
		left: 0;
		">
	<div class="container">
		<div class="row">
			<div class="col brand cursor-pointer" style="font-size:1.5rem !important" 
				onclick="window.location='{{url("")}}'">Kos<span class="unique">a</span>n
			</div>
			<div class="col d-flex justify-content-end align-items-center">
				@yield("body.topnav")
				@stack("body.topnav")
			</div>
		</div>
	</div>
</div>