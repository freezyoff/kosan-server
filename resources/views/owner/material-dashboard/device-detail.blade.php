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

.ct-legend {display:inline-block; width:15px; height:15px; vertical-align:text-top; visibility:hidden; margin-left:2px;}
.ct-legend.ct-series-a {visibility:visible; background-color:orange}
.ct-legend.ct-series-b {visibility:visible; background-color:#26c6da}
.ct-legend.ct-series-c {visibility:visible; background-color:blue}
</style>
@endpush

@push('script')
<script src="{{mix('js/kosan/server-message-listener.js')}}"></script>
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
});
</script>
<script>
let Listener = {
	isConnected: function(){ return Time.now() - _lastRecievedMessage > 60; },
	init: function(){
		Kosan.ServerMessageListener.listen("{{route('web.owner.devices.listener')}}", this.onConnect, this.onMessageArrive);
		setInterval(this.updateTimestamp, 3000);
	},
	onConnect: function(client){
		client.subscribe("kosan/user/{{md5(Auth::user()->email)}}/device/{{md5($device->mac)}}/state/+");
	},
	onMessageArrive: function(client, topic, message){
		//console.log(message.toString());
		//topic: "kosan/user/<email-md5>/device/<mac-md5>/state/<os|io|config>"
		topic = topic.split("/");
		
		_lastRecievedMessage = Time.now();
		
		if (topic[6] == 'os'){
			let stateOS = new Kosan.StateMessageFactory.make(message.toString());
			Listener.updateProperties(stateOS);
		}
	},
	updateProperties: function(stateOS){
		SysUpdate.updateProperties(stateOS);
		SysRAM.updateProperties(stateOS);
		SysFirmware.updateProperties(stateOS);
		SysFS.updateProperties(stateOS);
	},
	updateTimestamp:function(){
		SysUpdate.updateTimestamp();
		SysRAM.updateTimestamp();
		SysFS.updateTimestamp();
		SysFirmware.updateTimestamp();
	}
};

$(document).ready(function(){
	Listener.init();
});
</script>
<script>
let  SysRAM = {
	theChart: null,
	updateTimer: Time.now(),
	data: {
		labels: ['-12s', '-9s', '-6s', '-3s', '0s'],
		series: [
			[0,0,0,0,0,],	//current free heap
			[0,0,0,0,0,],	//current free heap
		]
	},
	options:{
		lineSmooth: Chartist.Interpolation.cardinal({
			tension: 0
		}),
		fullWidth: true,
		low: 0,
		high: 0,
		chartPadding: {
			right: 40
		}
	},
	init: function(chartCollection){
		chartCollection['ram'] = new Chartist.Line('#system-health-chart', this.data, this.options);
		this.theChart = chartCollection['ram'];
	},
	updateProperties: function(osState){
		if (!this.theChart){
			this.init(Charts);
		}
		
		//used heap
		let info = osState.ramInfo();
		this.data.series[0].push(info.used/1000);
		this.data.series[0] = this.data.series[0].length > 5? this.data.series[0].slice(1) : this.data.series[0];
		
		this.data.series[1].push(info.fragments*info.size/100/1000);
		this.data.series[1] = this.data.series[1].length > 5? this.data.series[1].slice(1) : this.data.series[1];
		
		let iteration = 0;
		while (this.options.high < Math.round(info.size/1000)){
			this.options.high = 10^(iteration++);
		}
		//this.options.high = Math.round(info.size/1000);
		this.theChart.update(this.data, this.options, true);
		
		$('#sys-ram-size').html(numberSeparator(info.size) + " Bytes");
		$('#sys-ram-usage').html(numberSeparator(info.used) + " Bytes");
		$('#sys-ram-free').html(numberSeparator(info.free) + " Bytes");
		$('#sys-ram-fragments').html(info.fragments + "%");
		
		this.updateTimer = Time.now();
	},
	updateTimestamp: function(){
		$('#sys-ram-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
	}
};
</script>
<script>
let SysFirmware = {
	theChart: null,
	updateTimer: Time.now(),
	data: { series: [] },
	options:{ chartPadding: 0 },
	init: function(chartCollections){
		let chartKey = "firmware";
		let chartEL = '#sys-firmware-chart';
		
		chartCollections[chartKey] = new Chartist.Pie(chartEL, this.data, this.options);
		this.theChart = chartCollections[chartKey];
	},
	updateProperties: function(stateOS){
		let iUpdate = stateOS.updateInfo();
		let iFirmware = stateOS.firmwareInfo();
		let iType = iUpdate.available? 'update' : 'info'
		
		//init chart
		if (!this.theChart){
			this.init(Charts);
		}
		
		$('#sys-firmware-version-device').html(stateOS.hash());
		$('#sys-firmware-info-size').html(numberSeparator(iFirmware.size) + " Bytes");
		$('#sys-firmware-info-used').html(numberSeparator(iFirmware.used) + " Bytes");
		$('#sys-firmware-info-free').html(numberSeparator(iFirmware.free) + " Bytes");
		this.data.series[0] = (iFirmware.used/iFirmware.size*100).toFixed(2);
		this.data.series[1] = (iFirmware.free/iFirmware.size*100).toFixed(2);
			
		//update in progress
		if (iType == 'update'){
			
			//add data series
			this.data.series[2] = (iUpdate.progress/iFirmware.size*100).toFixed(2);
			
			//change the free
			$('#sys-firmware-info-free').html(numberSeparator(iFirmware.free - iUpdate.progress) + " Bytes");
			this.data.series[1] = ((iFirmware.free - iUpdate.progress)/iFirmware.size*100).toFixed(2);
			
			//set the update
			$('#sys-firmware-progress').html(numberSeparator(iUpdate.progress) + " Bytes");
		}
		
		this.theChart.update(this.data, this.options, true);
		this.updateTimer = Time.now();
	},
	updateTimestamp: function(){
		$('#sys-firmware-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
	}
}
</script>
<script>
let SysFS = {
	theChart: null,
	updateTimer: Time.now(),
	data: {series: []},
	options:{chartPadding: 0},
	init: function(chartCollections){
		chartCollections['storage'] = new Chartist.Pie('#sys-fs-chart', this.data, this.options);
		this.theChart = chartCollections['storage'];
	},
	updateProperties: function(stateOS){
		if (!this.theChart){
			this.init(Charts);
		}
		
		let info = stateOS.filesystemInfo();
		$('#sys-fs-size').html(numberSeparator(info.size) + " Bytes");
		$('#sys-fs-usage').html(numberSeparator(info.used) + " Bytes");
		$('#sys-fs-free').html(numberSeparator(info.free) + " Bytes");
		
		this.data.series[0] = (info.used/info.size*100).toFixed(2);
		this.data.series[1] = (info.free/info.size*100).toFixed(2);
		this.theChart.update(this.data, this.options, true);
		this.updateTimer = Time.now();
	},
	updateTimestamp: function(){
		$('#sys-fs-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
	}
}
</script>
<script>
let SysUpdate = {
	updateTimer: Time.now(),
	latestFirmware:{
		hash: '{{$update->hash}}',
		size: {{$update->size()}}
	},
	updateProperties:function(stateOS){
		//check if update available, if not do nothing
		let isAvailable = this.latestFirmware.hash != stateOS.hash();
		if (!isAvailable){
			return;
		}
		
		let iFirmware = stateOS.firmwareInfo();
		$("#sys-update").addClass(isAvailable? '' : 'd-none').removeClass(isAvailable? 'd-none' : '');
		$("#sys-update-device-hash").html(stateOS.hash());
		$("#sys-update-device-hash-tooltips").html(stateOS.hash()).attr('data-original-title', stateOS.hash());
		$("#sys-update-device-size").html(numberSeparator(iFirmware.used) + " Bytes");
		$("#sys-update-server-hash").html(this.latestFirmware.hash);
		$("#sys-update-server-hash-tooltips").html(this.latestFirmware.hash).attr('data-original-title', this.latestFirmware.hash);
		$("#sys-update-server-size").html(numberSeparator(this.latestFirmware.size) + " Bytes");
		
		//check if update in progress (download started), 
		let iUpdate = stateOS.updateInfo();
		
		//device will info no update yet, because device not check it yet
		let isUpdateInProgress = iUpdate.available;
		
		//if update in progress
		if (isUpdateInProgress){
			//show progress info
			$("#sys-update-download-btn").addClass('d-none');
			$("#sys-update-download-info").removeClass('d-none');
			
			//update percentage
			let percent = Math.round(iUpdate.progress/iUpdate.size*100);
			$("#sys-update-download-info-progressbar").attr('data-percentage', percent);
			$("#sys-update-download-info-label").html(`${percent}%`);
			$("#sys-update-download-info-progress").html(numberSeparator(iUpdate.progress) + " Bytes");
			$("#sys-update-download-info-remaining").html(numberSeparator(iUpdate.remaining) + " Bytes");
		}
		else{
			//show download button
			$("#sys-update-download-btn").removeClass('d-none');
			$("#sys-update-download-info").addClass('d-none');
		}
		
		this.updateTimer = Time.now();
	},
	updateTimestamp: function(){
		$('#sys-update-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
	}
}
</script>
@endpush

@push('content')
<!-- begin: Cards -->
<div class="row">
	@include('owner.material-dashboard.device-detail.update')
	@include('owner.material-dashboard.device-detail.ram')
	@include('owner.material-dashboard.device-detail.firmware')
	@include('owner.material-dashboard.device-detail.filesystem')
</div>
<!-- end: Cards -->
@endpush