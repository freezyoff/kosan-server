@php 
	$pageTitle = ucwords($pageTitle?? config("kosan.sidebar.user.left.0.label"));
	$href = isset($href)? $href : "javascript:;";
	
	$locationList = $user->subscribedLocations();
	
	$indicatorIds = [
		"_".\Str::random(),	//lock
		"_".\Str::random()	//door
	];
	
	$buttonId = "_".\Str::random();
@endphp

@extends('layout-material-dashboard')

@prepend("navbar-bread")
	@include('layout.material-dashboard.nav-breadcrumb', ['label'=> $pageTitle, 'href'=>$href])
@endprepend

@section("nav-item")
	@include ("my.material-dashboard.sidebar")
@endsection

@push('style')
<link rel="stylesheet" href="{{mix('css/spinner.css')}}">
<style>
.clickable{cursor:pointer}
.dropdown-toggle:after{display:none !important;}
.clickable > .dropdown-menu{left:0 !important; top:54px !important;}
.indicator-icon{width:70px; height:70px; min-width:70px; min-height:70px;}
</style>
@endpush

@push('content')
<div class="row">
	<div class="col-sm-12">
		@include('my.material-dashboard.dashboard.location-info')
		@foreach($locationList->get() as $item)
			@if (!$selectedRoomId)
				@php
					$selectedRoom = $user->subscribedRooms($item->id)->first();
					$selectedRoomId = $selectedRoom->id;
				@endphp
			@endif
			@include('my.material-dashboard.dashboard.room-info', ['rooms'=>Auth::user()->subscribedRooms($item->id)])
		@endforeach
		@include('my.material-dashboard.dashboard.subscription-info', ['room'=>$selectedRoom])
	</div>
</div>
<div class="row">
	<div class="col-sm-12" style="display:flex; justify-content:center; align-items:center">
		<div class="card rounded-circle indicator-icon mt-3 mb-0">
			<div id="{{$indicatorIds[0]}}" class="card-body" style="text-align:center"></div>
		</div>
		<div class="ml-3 mr-3" style="flex-grow:1"></div>
		<div class="card rounded-circle indicator-icon mt-3 mb-0">
			<div id="{{$indicatorIds[1]}}" class="card-body" style="text-align:center"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12" style="margin:auto; max-width:180px; max-height:180px;">
		<div id="{{$buttonId}}">
			@include('my.material-dashboard.dashboard.btn-disabled')
		</div>
	</div>
</div>
@endpush

@push('script')
<script src="{{mix('js/http/my/dashboard.js')}}"></script>
@php
$Props = [
	0 => "_".\Str::random(),
	'spinner' => "_".\Str::random(),
	'lock' => "_".\Str::random(),
	'door' => "_".\Str::random(),
	'button' => "_".\Str::random(),
];
$SignalListener = [
	0 => "_".\Str::random()
];
$SubscriptionProgress = "_".\Str::random();
@endphp
<script>
let {{$Props[0]}} = {
	{{$Props['spinner']}}:`<div class="text-center" style="position:absolute; top:19px; left:20px"><div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div></div>`,
	{{$Props['lock']}}:{
		tag: $('#{{$indicatorIds[0]}}'),
		colors: {
			unlocked: "bg-success",
			locked: "bg-warning",
		},
		icons: {
			unlocked: `@include('my.material-dashboard.dashboard.lock-unlocked')`,
			locked: `@include('my.material-dashboard.dashboard.lock-locked')`
		}
	},
	door:{
		tag: $('#{{$indicatorIds[1]}}'),
		colors:{
			unlocked: "bg-success",
			locked: "bg-warning",
		},
		icons: {
			unlocked: `@include('my.material-dashboard.dashboard.door-unlocked')`,
			locked: `@include('my.material-dashboard.dashboard.door-locked')`
		}
	},
	button:{
		tag: $('#{{$buttonId}}'),
		icons:{
			default: `@include('my.material-dashboard.dashboard.btn-unpressed')`,
			disabled: `@include('my.material-dashboard.dashboard.btn-disabled')`,
			pressed: `@include('my.material-dashboard.dashboard.btn-pressed')`,
		},
		sendCommand: function(){
			let target = $($(this).html());
			if (target.attr('type') != 'btn-unpressed') return;
			
			APP.sendCommand();
			$(this).html({{$Props[0]}}.button.icons.pressed);
			setTimeout(function(){
				$(this).html({{$Props[0]}}.button.icons.unpressed);
			}.bind(this), 250);
		}
	}
};

let {{$SignalListener[0]}} = {
	init: function(){
		{{$Props[0]}}.{{$Props['lock']}}.tag.html({{$Props[0]}}.{{$Props['spinner']}});
		{{$Props[0]}}.door.tag.html({{$Props[0]}}.{{$Props['spinner']}});
		{{$Props[0]}}.button.tag.click({{$Props[0]}}.button.sendCommand);
	},
	main: function(lockSignal, doorSignal){
		if (lockSignal >= 0) {
			{{$SignalListener[0]}}.lockHandler(lockSignal);
		}
		
		if (doorSignal >= 0) {
			{{$SignalListener[0]}}.doorHandler(doorSignal);
		}
	},
	lockHandler: function(signal){
		//locked
		if (signal == 1){	
			{{$Props[0]}}.{{$Props['lock']}}.tag.html({{$Props[0]}}.{{$Props['lock']}}.icons.locked)
				.parent()
				.addClass({{$Props[0]}}.{{$Props['lock']}}.colors.locked)
				.removeClass({{$Props[0]}}.{{$Props['lock']}}.colors.unlocked);
			{{$Props[0]}}.button.tag.html({{$Props[0]}}.button.icons.default);
		}
		
		//unlocked
		else{	
			{{$Props[0]}}.{{$Props['lock']}}.tag.html({{$Props[0]}}.{{$Props['lock']}}.icons.unlocked)
				.parent()
				.addClass({{$Props[0]}}.{{$Props['lock']}}.colors.unlocked)
				.removeClass({{$Props[0]}}.{{$Props['lock']}}.colors.locked);
			{{$Props[0]}}.button.tag.html({{$Props[0]}}.button.icons.disabled);
		}
	},
	doorHandler: function(signal){
		//locked
		if (signal == 1){
			{{$Props[0]}}.door.tag.html({{$Props[0]}}.door.icons.unlocked)
				.parent()
				.addClass({{$Props[0]}}.door.colors.unlocked)
				.removeClass({{$Props[0]}}.door.colors.locked);
		}
		
		//unlocked
		else{	
			{{$Props[0]}}.door.tag.html({{$Props[0]}}.door.icons.locked)
				.parent()
				.addClass({{$Props[0]}}.door.colors.locked)
				.removeClass({{$Props[0]}}.door.colors.unlocked);
		}
	}
};

let {{$SubscriptionProgress}} = function(){
	let start = {{$selectedRoom->pivot->valid_after->timestamp}};
	let end = {{$selectedRoom->pivot->valid_before->timestamp}};
	let grace = {{$selectedRoom->pivot->grace_periode}};
	let result = APP.subscriptionProgress(start, end, grace);
	
	$('#subscription-info-progress').attr('aria-valuenow', result.progress).css('width', result.progress + "%");
	if (result.isGracePeriode){
		$('#subscription-info-icon').addClass('text-danger');
		$('#subscription-info-title').addClass('text-danger').html("Masa Tenggang:");
		$('#subscription-info-progress').addClass('bg-danger');
	}
	else{
		$('#subscription-info-icon').removeClass('text-danger');
		$('#subscription-info-title').removeClass('text-danger').html("Masa Sewa:");
		$('#subscription-info-progress').addClass('bg-info');
	}
	
	let str = "";
	if (result.days){
		str = 	result.days? result.days + " Hari " : "";
		str += 	result.hours? result.hours + " Jam" : "";
		$('#subscription-info-countdown').html(str);
	}
	else{
		str = 	result.hours? result.hours + " Jam " : "";
		str += 	result.minutes? result.minutes + " Menit" : "";
		$('#subscription-info-countdown').html(str);
	}
};

$(document).ready(function(){
	APP.init(
		"{{route('web.my.dashboard.listener',[md5($selectedRoomId)])}}",
		{{$SignalListener[0]}}.main
	);
	{{$SignalListener[0]}}.init();
	setInterval({{$SubscriptionProgress}}, 1000);
});
</script>
@endpush