@php 
	$activeIndex = 1;
	$cardViewPath = "layout.material-dashboard.card-status";
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label") . " / " . $device->mac])

@push('styles')
<link rel="stylesheet" href="{{mix('css/circular-progressbar.css')}}" />
<style>
.ct-series.ct-series-a .ct-line,
.ct-series.ct-series-a .ct-point  { stroke: orange !important; stroke-width:1;}
.ct-series.ct-series-b .ct-line,
.ct-series.ct-series-b .ct-point  { stroke: #26c6da !important; stroke-width:1; }

.ct-chart .ct-chart-pie .ct-series.ct-series-a .ct-slice-pie{fill:orange; stroke:none;}
.ct-chart .ct-chart-pie .ct-series.ct-series-b .ct-slice-pie{fill:#26c6da; stroke:none;}
.ct-chart .ct-chart-pie .ct-series.ct-series-c .ct-slice-pie{fill:blue; stroke:none;}
.ct-chart .ct-label{fill:white;}

.ct-legend {display:inline-block; width:16px; height:16px; vertical-align:text-top; visibility:hidden; margin-left:2px;}
.ct-legend.ct-series-a {visibility:visible; background-color:orange}
.ct-legend.ct-series-b {visibility:visible; background-color:#26c6da}
.ct-legend.ct-series-c {visibility:visible; background-color:blue}

.action-icons { font-size:1rem !important; max-width:1rem; cursor:pointer;}

.bmd-form-group .form-control, 
.bmd-form-group input::placeholder, 
.bmd-form-group label{ line-height:2 !important;}
</style>
@endpush

@push('script')
<script src="{{mix('js/kosan/server-message-listener.js')}}"></script>
<script src="{{mix('js/http/owner/device-statistics.js')}}"></script>
<script>
let Charts = {};
let _lastRecievedMessage = 0;
let toHumanElapsedTime = function(timestamp){
	let t = Time.elapsed(timestamp);
	if (t.diff <=3) {
		return "1 detik yang lalu";
	}
	else{		
		let str= "";
		if (t.days) 	str	 = t.days + " hari ";
		if (t.hours) 	str += t.hours + " jam ";
		if (t.minutes) 	str += t.minutes + " menit ";
		if (t.seconds) 	str += t.seconds + " detik ";
		return str + " yang lalu";
	}
};
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	Kosan.Owner.deviceStatistics("{{route('web.owner.devices.listener',[md5($device->mac)])}}");
});
</script>
@endpush

@push('content')
<!-- begin: Cards -->
<div class="row">
	@include('owner.material-dashboard.device-detail.general')
	@include('owner.material-dashboard.device-detail.update')
</div>
<div class="row">
	@include('owner.material-dashboard.device-detail.ram')
	@include('owner.material-dashboard.device-detail.firmware')
	@include('owner.material-dashboard.device-detail.filesystem')
</div>
<div class="row">
	@include('owner.material-dashboard.device-detail.wifiap-ntp')
	@include('owner.material-dashboard.device-detail.wifi')
</div>
<!-- end: Cards -->
@endpush