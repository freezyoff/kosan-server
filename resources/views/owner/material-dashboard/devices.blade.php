@php 
	$activeIndex = 2;
	$pageTitle = config("kosan.sidebar.owner.left.$activeIndex.label");
	$href = config("kosan.sidebar.owner.left.$activeIndex.href");
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>$pageTitle, 'href'=>$href])

@push('styles')
<style>
	div.btn:hover{ box-shadow:none !important;}
	button#filter{ text-transform:none; }
</style>
@endpush 

@push('script')
<script src="{{mix('js/kosan/server-message-listener.js')}}"></script>
<script src="{{mix('js/http/owner/devices.js')}}"></script>
<script>
@foreach($devices->get() as $device)
	APP.add('{{md5($device->mac)}}');
@endforeach

	APP.init("{{route('web.owner.devices.listener')}}");
</script>
@endpush

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

{{-- Begin: filter  --}}
@push('content')
<div class="row">
	<div class="col">	
		<div class="btn-group p-0 mt-0" role="group">
			<div class="btn btn-primary">
				<i class="material-icons">place</i>&nbsp;
			</div>
			<button id="filter" 
				class="btn btn-white d-block" 
				type="button"
				data-toggle="modal" 
				data-target="#filterByLocation">
				
				@isset ($location)
					{{$location}}
				@else
					Semua Lokasi
				@endif
				
			</button>
		</div>
	</div>
</div>
@endpush
@include('owner.material-dashboard.devices.filter-locations-modal') 
{{-- End: filter  --}}

{{-- Begin: items  --}}
@push('content')
<div class="row">
	@foreach($devices->get() as $dev)
	<div class="col-sm-12 col-md-12 col-lg-6">
		<div class="card card-stats">
			<div class="card-header card-header-secondary card-header-icon">
				<div class="card-icon text-white">
					<i id="{{md5($dev->mac)}}-icon" class="material-icons">sync</i>
				</div>
				@if ($dev->alias)
					<p class="card-category">Nama Perangkat</p>
					<h4 class="card-title">{{$dev->alias}}</h4>
				@else
					<p class="card-category">Mac Address</p>
					<h4 class="card-title">{{$dev->mac}}</h4>
				@endif
			</div>
			<div class="card-body text-left">
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Mode Komunikasi :</div>
					<div id="{{md5($dev->mac)}}-con-mode" class="col-sm-8 p-0"></div>
				</div>
				<div class="row pb-2 mb-2 m-0 border-bottom">
					<div class="col-sm-4 p-0">Komunikasi Terakhir:</div>
					<div id="{{md5($dev->mac)}}-con-last" class="col-sm-8 p-0"></div>
				</div>
			</div>
			<div class="card-footer p-0 d-none d-md-block">
				<div class="btn-group p-0 mt-0" role="group">
					<button class="btn btn-info"
						type="button"
						onclick="document.location='{{route('web.owner.device',['macHash'=>md5($dev->mac)])}}'">
						<i class="material-icons">show_chart</i>&nbsp;
						<span>Info</span>
					</button>
					<button class="btn btn-warning"
						type="button"
						onclick="document.location='{{route('web.owner.access-control',["macHash"=>md5($dev->mac)])}}'">
						<i class="material-icons">gamepad</i>&nbsp;
						<span>Kontrol Akses</span>
					</button>				
					<button class="btn btn-danger d-block"
						type="button"
						onclick="APP.restart('{{md5(Auth::user()->email)}}', '{{md5($dev->mac)}}')">
						<i class="material-icons">autorenew</i>&nbsp;
						<span>Restart</span>
					</button>
				</div>
			</div>
			<div class="card-footer p-0 d-block d-md-none">
				<button class="btn btn-info w-100"
					type="button"
					onclick="document.location='{{route('web.owner.device',['macHash'=>md5($dev->mac)])}}'">
					<i class="material-icons">show_chart</i>&nbsp;
					<span>Info</span>
				</button>
				<button class="btn btn-warning w-100"
					type="button"
					onclick="document.location='{{route('web.owner.access-control',["macHash"=>md5($dev->mac)])}}'">
					<i class="material-icons">gamepad</i>&nbsp;
					<span>Kontrol Akses</span>
				</button>				
				<button class="btn btn-danger w-100"
					type="button"
					onclick="APP.restart('{{md5(Auth::user()->email)}}', '{{md5($dev->mac)}}')">
					<i class="material-icons">autorenew</i>&nbsp;
					<span>Restart</span>
				</button>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endpush
{{-- End: items  --}}