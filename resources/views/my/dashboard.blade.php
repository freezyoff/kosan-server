@extends("layout-root")

@section('styles')
<!-- Begin: global style -->
<style>
.top-nav{ font-size:1.05rem; color:#FEFEFE;}
.top-nav:hover{ color:#FEFEFE;}
.top-nav.active { color:#007bff; }
.form-control:disabled, .form-control[readonly]{ background-color:#FEFEFE; }
</style>
<!-- End: global style -->
@endsection

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section('body')
	<div class="card pt-1 pb-1" 
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
				<div class="col brand" style="font-size:1.5rem !important">Kosan</div>
				<div class="col d-flex justify-content-end align-items-center">
					<a href="{{route('web.my.dashboard.accessibilities')}}" 
						class="top-nav 
								@if($page == 'accessibilities' || $page == '') 
									active 
								@endif">
						<i class="fas fa-key"></i>
					</a>
					<a href="{{route('web.my.dashboard.device-manager')}}" 
						@if($page == 'device-manager') 
						class="ml-4 top-nav active"
						@else
						class="ml-4 top-nav"
						@endif>
						<i class="fas fa-clipboard-list"></i>
					</a>
					<a href="#" 
						@if($page == 'setting') 
						class="ml-4 top-nav active"
						@else
						class="ml-4 top-nav"
						@endif>
						<i class="fas fa-cog"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
	
	@yield('dashboard.page')
	
@endsection