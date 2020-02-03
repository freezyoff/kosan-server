@extends('my.dashboard')

@push('script')
<script src="{{ url("js/dashboard.js") }}" crossorigin="anonymous"></script>
<script>
	var _xmap = [
		"{{base64_encode($cipher_key)}}",
		{!! json_encode($topics) !!}
	];
	
	function topics(key){
		list = JSON.parse(atob(_xmap[1]));
		if (list[key] !== 'undefined'){
			return Kosan.Crypt.decrypt(_xmap[0],list[key]);
		}
		return "";
	}
	
	function onConnect(){}
	
	function onMessage(topic, message){
		if (topic == topics("sub_auth")){
			//console.log(message.toString());
			Kosan.User = Kosan.Factory.makeUser(message.toString());
			subscribeOwnedDevice();
			return;
		}
		
		_subscribeOwnedDevice.forEach(function(item, index){
			if (topic == item){
				//"kosan/user/<api_token>/owner/<md5_device_uuid>/<md5_device_accessibility_id>/<os|io|config>"
				var segments = topic.split("\/");
				if (segments.length < 7) return;
				
				$('#card-title-'+segments[4]).find('span.badge').removeClass('d-none');
			}
		});
	}
	
	function publishAuth(){
		if (Kosan.User == null || Kosan.User.isApiTokenExpired()){
			//console.log(topics("pub_auth"));
			Kosan.MQTT.publish(topics("pub_auth"), "");
		}
	}
	
	function subscribeAuth(){
		Kosan.MQTT.subscribe(topics("sub_auth"));
	}
	
	var _subscribeOwnedDevice = [];
	function subscribeOwnedDevice(){
		
		//unsubscribe previous topic
		_subscribeOwnedDevice.forEach(function(item, index){
			Kosan.MQTT.unsubscribe(item);
		});
		
		//subscribe user owner device
		//"kosan/user/<api_token>/owner/<md5_device_uuid>/<md5_device_accessibility_id>/<os|io|config>"
		_subscribeOwnedDevice = []
		Kosan.User.ownedLocations().forEach(function(location, index){
			location.devices().forEach(function(device, index){
				device.deviceAccessibilities().forEach(function(access, index){
					var topic = topics("sub_state")
						.replace("<api_token>", Kosan.User.apiToken())
						.replace("<md5_device_uuid>", Kosan.MD5(device.uuid()))
						.replace("<md5_device_accessibility_id>", Kosan.MD5(access.id()));
						
					["os","io","config"].forEach(function(item, index){
						
						var str = topic.replace("<os|io|config>", item);
						Kosan.MQTT.subscribe(
						str, 1);
						_subscribeOwnedDevice.push(str);
						
					});
				});
			});
		});
		
	}
	
	$(document).ready(function(){
		Kosan.MQTT.connect(onConnect, onMessage);
		subscribeAuth()
		publishAuth();
		setInterval(publishAuth, 3000);
	});
</script>
<script>
	function locationSelect(el, locationID){
		$('#sm .inp-location-select').val($(el).html().trim());
		getDeviceByLocation(locationID);
	}
	
	function getDeviceByLocation(locationID){
		var href = "{{route('web.my.dashboard.device-manager.location',['locationID'=>false])}}/";
		if (locationID){
			href += locationID;
		}
		$.get( href, function(data, status){
			$('#sm .cnt-devices').html(data);
		});
	}
	
	function sendPicInvitation(modal, locationID){
		var name = $(modal).find('input[name="name"]');
		var email = $(modal).find('input[name="email"]');
		
		var url = "{{route('web.my.dashboard.device-manager.invite.pic',['locationID', 'name', 'email'])}}";
		url = url.replace("locationID", locationID)
					.replace("name", name.val())
					.replace("email", email.val());
		$.post( url, { 
			locationID: locationID, 
			name: name.val(), 
			email:email.val(),
			_token: "{{csrf_token()}}"
		});
	}
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endpush

@push('styles')
<!-- Begin: global style -->
<style>
.table>tbody>tr>td:first-child { padding-left:1.25rem }
.table>tbody>tr>td:last-child { padding-right:1.25rem }
</style>
<!-- End: global style -->
@endpush

@section('dashboard.page')
<!-- Begin: dashboard-xs-sm -->
<div id="sm" class="d-block d-sm-none">

	<!-- Begin: locations -->
	<div class="bg-light pr-3 pl-3 pt-3">
		
		<div class="input-group flex-nowrap">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<i class="fas fa-map-marker-alt"></i>
				</span>
			</div>
			<input 
				type="text" 
				class="inp-location-select form-control" 
				placeholder="Location" 
				readonly="readonly" 
				value="Semua Lokasi"
				style="cursor:pointer"
				aria-label="location" 
				aria-describedby="location"
				data-toggle="modal" 
				data-target="#mdl-locations">
		</div>
		
		<!-- Begin: device manager -->
		<div class="cnt-devices h-100">{!!$items!!}<div>
		<!-- End: device manager -->
		
	</div>
	<!-- End: locations -->
	
</div>

@include('my.dashboard.device-manager.sm-locations-modal')

<!-- End: dashboard-xs-sm -->
@endsection
