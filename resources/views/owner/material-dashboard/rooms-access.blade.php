@php 
	$activeIndex = 4;
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

@push('style')
<style>
	td div i {font-size:1rem !important; cursor:pointer;}
	.dropdown-toggle::after {margin-right:.5rem;}
	ul.nav>li.nav-item:last-child{border-bottom:1px solid #dee2e6 !important;}
	
	.card-icon>a:hover>span,
	.card-icon>div:hover>* {opacity:90%}
	
	.card-icon i {width:auto !important;}
</style>
@endpush

@push('script')
<script src="{{mix('js/http/owner/rooms-access.js')}}"></script>
@endpush

@push('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-text card-header-primary">
				<div class="card-icon d-flex align-items-center">
				
					@php 
						$modalID = "_".\Str::random();
					@endphp
					<div class="d-flex align-items-center">						
						<i class="material-icons" style="font-size:22px">location_on</i>
						<a id="btn-location" class="dropdown-toggle text-white" href="#{{$modalID}}" data-toggle="modal"></a>
						@include('owner.material-dashboard.rooms-access.modal-filter-location')
					</div>
					
					<div class="border-left ml-2 mr-2" style="height:1rem;opacity:50%">&nbsp;</div>
					
					@php 
						$modalID = "_".\Str::random();
					@endphp
					<div class="d-flex align-items-center" 
						style="cursor:pointer"
						data-target="#{{$modalID}}"
						data-toggle="modal">
						<i class="material-icons">add</i>
						<span class="ml-2 mr-1">Tambah Hak Akses</span>
						@include('owner.material-dashboard.rooms-access.modal-create')
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<div class="d-flex align-items-center">
							<i class="material-icons mr-2">search</i>
							<input type="text" class="form-control" placeholder="Kamar">
						</div>
					</div>
					<div class="col-sm-12 col-lg-6">
						<div class="d-flex align-items-center">
							<i class="material-icons mr-2">search</i>
							<input type="text" class="form-control d-block" placeholder="Email Penyewa">
						</div>
					</div>
				</div>
				{{-- @include('owner.material-dashboard.rooms-access.table') --}}
			</div>
		</div>
	</div>
</div>
@endpush