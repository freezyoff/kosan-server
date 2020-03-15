@php 
	$activeIndex = 1;
	$cardViewPath = "layout.material-dashboard.card-status";
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@push('script')
<script src="{{mix('js/kosan/server-message-listener.js')}}"></script>
<script>
let devices = [
	@foreach($devices->get() as $device)
		'{{md5($device->mac)}}'{{($loop->last?"":",")}}
	@endforeach
];
let devices_touch_timer = {};
let device_state_mode = {};

let _onConnect = function(client){
	@foreach($devices->get() as $device)
	client.subscribe("kosan/user/{{md5(Auth::user()->email)}}/device/{{md5($device->mac)}}/state/+")
	@endforeach
};

let _onMessageArrive = function(client, topic, message){
	//topic: "kosan/user/<email-md5>/device/<mac-md5>/state/<os|io|config>"
	topic = topic.split("/");
	devices_touch_timer[topic[4]] = now();
	if (topic[6] == 'os'){
		let find = "~m=";
		let sdx = message.indexOf("~m=") + find.length;
		device_state_mode[topic[4]] = 0|message.toString().substring(sdx, sdx+1);
	}
};

let updateLastConnected = function(idx, isConnected){
	let timestamp = devices_touch_timer[devices[idx]];
	let span = $("<span></span>").addClass('badge ' + (isConnected? 'badge-success' : "badge-secondary"));
	let div = $('#'+devices[idx]+'-con-last').empty();
	
	let t = Time.elapsed(timestamp);
	if (t.diff <=3) {
		div.append( span.html("baru saja") );
	}
	else if (!isConnected){
		div.append( span.html("tidak terkoneksi") );
	}
	else{		
		let str= "";
		if (t.days) 	str	 = t.days + " hari ";
		if (t.hours) 	str += t.hours + " jam ";
		if (t.minutes) 	str += t.minutes + " menit ";
		if (t.seconds) 	str += t.seconds + " detik ";
		div.append( span.html(str + " yang lalu") );
	}
	
}

let updateStateMode = function(idx, isConnected){
	let mode = ["tidak diketahui", "melayani", "melayani & download update"];
	let modeIdx = isConnected? device_state_mode[devices[idx]] : 0;
	$('#'+devices[idx]+'-con-mode').empty().append(
		$("<span></span>").html(mode[modeIdx])
			.addClass('badge ' + (isConnected? 'badge-success' : 'badge-secondary'))
	);
}

$(document).ready(function(){
	Kosan.ServerMessageListener.listen("{{route('web.owner.devices.listener')}}", _onConnect, _onMessageArrive);
	setInterval(function(){ 
		for (let i=0; i<devices.length; i++){
			let cdevice = devices[i];
			let isConnected = now() - devices_touch_timer[cdevice] < 3;
			$('#'+devices[i]+'-icon').html( isConnected? 'router' : 'sync_problem')
				.parents('div')
				.removeClass( isConnected? 'card-header-secondary' : 'card-header-success')
				.addClass( isConnected? 'card-header-success' : 'card-header-secondary');
			
			updateLastConnected(i, isConnected);
			updateStateMode(i, isConnected);
		}
	}, 3000);
});
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