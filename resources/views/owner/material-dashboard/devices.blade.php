@php 
	$activeIndex = 1;
	$cardViewPath = "layout.material-dashboard.card-status";
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@push('script')
<script src="{{mix('js/kosan/server-message-listener.js')}}"></script>
<script src="{{mix('js/http/owner/devices.js')}}"></script>
<script>
@foreach($devices->get() as $device)
	APP.add('{{md5($device->mac)}}');//{{$device->mac}}
@endforeach

	APP.init("{{route('web.owner.devices.listener')}}");
</script>
@endpush

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

@push('content')
<div class="row">
	@foreach($devices->get() as $dev)
	<div class="col-lg-6 col-md-12 col-sm-12">
		<div class="card card-stats">
			<div class="card-header card-header-secondary card-header-icon">
				<a href="{{route('web.owner.device',['macHash'=>md5($dev->mac)])}}" class="card-icon text-white">
					<i id="{{md5($dev->mac)}}-icon" class="material-icons">sync</i>
				</a>
				<p class="card-category">Mac Address</p>
				<h4 class="card-title">{{$dev->mac}}</h4>
			</div>
			<div class="card-body text-left">
				<h4 class="border-bottom pb-2">Chipset Perangkat</h4>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Chipset :</div>
					<div class="col-sm-8 p-0">{{$dev->chipset->name}}</div>
				</div>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Nomor Serial :</div>
					<div class="col-sm-8 p-0">{{$dev->uuid}}</div>
				</div>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Kanal Terminal Pintu : </div>
					<div class="col-sm-8 p-0">{{$dev->chipset->used_io/2}} terminal</div>
				</div>
				<h4 class="border-bottom pb-2 mt-4">Konektifitas</h4>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Mode Komunikasi :</div>
					<div id="{{md5($dev->mac)}}-con-mode" class="col-sm-8 p-0"></div>
				</div>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Komunikasi Terakhir:</div>
					<div id="{{md5($dev->mac)}}-con-last" class="col-sm-8 p-0"></div>
				</div>
			</div>
			<div class="card-footer">
				<div class="stats"></div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endpush