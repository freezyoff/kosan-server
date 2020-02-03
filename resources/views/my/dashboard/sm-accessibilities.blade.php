@extends('my.dashboard')

@section('script')
<script src="{{ url("js/dashboard.js") }}" crossorigin="anonymous"></script>
<script>
	var _xmap = [
		"{{base64_encode($cipher_key)}}",
		{!! json_encode($topics) !!}
	];
	
	function topics(key){
		json = JSON.parse(atob(_xmap[1]));
		if (json[key] !== 'undefined'){
			return Kosan.Crypt.decrypt(_xmap[0],json[key]);
		}
		return "";
	}
	
	function onConnect(){ /*console.log("connected");*/ }
	
	function onMessage(topic, message){
		if (topic == topics("sub_auth")){
			//console.log(message.toString());
			Kosan.User = Kosan.Factory.makeUser(message.toString());
			subscribeAccessibilities();
		}
		
		for(var i=0; i<_subscribeAccessibilities.length; i++){
			if (topic == _subscribeAccessibilities[i] ){
				//console.log(message.toString());
				json = JSON.parse(message.toString());
				
				var access = Kosan.User.findAccessibility(json.user_accessibility_id);
				access.doorSignal(json.door_signal);
				access.doorTriggerSignal(json.door_trigger_signal);
				access.lockSignal(json.lock_signal);
				access.lockTriggerSignal(json.lock_trigger_signal);
				
				updateAccessibilityView();
			}
		}
	}
	
	function publishAuth(){
		if (Kosan.User == null || Kosan.User.isApiTokenExpired()){
			//console.log(topics("pub_auth"));
			Kosan.MQTT.publish(topics("pub_auth"), "");
		}
	}
	
	function subscribeAuth(){
		//console.log(topics("sub_auth"));
		Kosan.MQTT.subscribe(topics("sub_auth"));
	}
	
	var _subscribeAccessibilities = [];
	function subscribeAccessibilities(){
		if (_subscribeAccessibilities.length > 0){
			//console.log(_subscribeAccessibilities);
			Kosan.MQTT.unsubscribe(_subscribeAccessibilities);
		}
		
		_subscribeAccessibilities = [];
		var access = Kosan.User.accessibilities();
		if (access.length<=0) return;
		
		for(var i=0; i<access.length; i++){
			_subscribeAccessibilities.push(
				topics("sub_user_access_state")
					.replace("<api_token>", Kosan.User.apiToken())
					.replace("<md5_user_accessibility_id>", Kosan.MD5(access[i].id()))
			);
		}
		Kosan.MQTT.subscribe(_subscribeAccessibilities);
	}
	
	function publishAccessibilityCommand(button, userAccessibilityID){
		var icon = $($(button).children()[1]);
		var access = Kosan.User.findAccessibility(userAccessibilityID);	
		var signals = {low: 0, high: 1};
		
		var signal = inverseSignal(access.lockSignal());
		var topic = topics("pub_access_command")
				.replace("<api_token>", Kosan.User.apiToken())
				.replace("<md5_user_accessibility_id>", Kosan.MD5(userAccessibilityID))
				.replace("<unsigned_int_signal>", signal);
		//console.log(topic);
		Kosan.MQTT.publish(topic, "");
	}
	
	function inverseSignal(source){
		if (source == 0){
			return 1;
		}
		else if (source == 1){
			return 0;
		}
		return -1;
	}
	
	$(document).ready(function(){
		Kosan.MQTT.connect(onConnect, onMessage);
		subscribeAuth();
		publishAuth();
		setInterval(publishAuth, 3000);
	});
</script>
<script>
	function getAccessibilitiesByLocation(locationID){
		if (locationID){
			$.get("{{route('web.my.dashboard.accessibilities.location',['locationID'=>false])}}/" + locationID, function(data, status){
				$('#sm #sm-keys-container').html(data);
			});
		}
		else{
			$.get("{{route('web.my.dashboard.accessibilities.location')}}", function(data, status){
				$('#sm #sm-keys-container').html(data);
			});			
		}
	}
	
	function _updateAccessibilityView(view, tag, triggerSignal, signal){
		var signalSet = (triggerSignal >= 0 && signal >= 0);
		
		var bgTxtClass = "bg-primary bg-secondary bg-warning text-light text-dark " + 
						 "btn-primary btn-secondary btn-warning";
		var iconClass = "fa-door-closed fa-door-open fa-question-circle " + 
						"fa-lock-open fa-lock fa-question-circle ";
		
		var bgtxt = "";
		var icon = "";
		var label = "";
		
		if (view == "door"){
			if (!signalSet){
				bgtxt = "bg-secondary";
				icon = "fa-question-circle";
				label = "";
			}
			else if (signal==triggerSignal){
				bgtxt = "bg-primary";
				icon = "fa-door-closed";
				label = "Tertutup";
			}
			else{
				bgtxt = "bg-warning";
				icon = "fa-door-open";
				label = "Terbuka";
			}
		}
		else if (view == "lock"){
			if (!signalSet){
				bgtxt = "bg-secondary";
				icon = "fa-question-circle";
				label = "";
			}
			else if (signal==triggerSignal){
				bgtxt = "bg-warning";
				icon = "fa-lock-open";
				label = "Terbuka";
			}
			else{
				bgtxt = "bg-primary";
				icon = "fa-lock";
				label = "Tertutup";
			}
		}
		else if (view == "button"){
			if (!signalSet){
				bgtxt = "btn-secondary";
				icon = "fa-question-circle";
				label = "";
			}
			else if (signal==triggerSignal){
				bgtxt = "btn-primary";
				icon = "fa-lock";
				label = "Kunci Pintu";
			}
			else{
				bgtxt = "btn-warning";
				icon = "fa-lock-open";
				label = "Buka Pintu";
			}
		}
		
		if (view == "door" || view == "lock" ){
			var child = $(tag).children();
			$(tag).removeClass(bgTxtClass).addClass(bgtxt);
			$(child[0]).removeClass(iconClass).addClass(icon);
			$(child[1]).html(label);			
		}
		else if (view == "button"){
			$(tag).attr("disabled", signalSet? false : "disabled");
			$(tag).removeClass(bgTxtClass).addClass(bgtxt);
			var child = $(tag).children();
			$(child[0]).removeClass(iconClass).addClass(icon);
			$(child[1]).html(label);
		}
		
	}
	
	function updateAccessibilityView(){
		if (!Kosan.User) return;
		
		for(var i=0; i<Kosan.User.accessibilities().length;i++){
			var id = Kosan.MD5(Kosan.User.accessibility(i).id());
			
			$('.door-'+id).each(function(){
				_updateAccessibilityView(
					"door", 
					this, 
					Kosan.User.accessibility(i).doorTriggerSignal(),
					Kosan.User.accessibility(i).doorSignal()
				);
			});
			
			$('.lock-'+id).each(function(){
				_updateAccessibilityView(
					"lock", 
					this, 
					Kosan.User.accessibility(i).lockTriggerSignal(),
					Kosan.User.accessibility(i).lockSignal()
				);
			});
			
			$('.btn-'+id).each(function(){
				_updateAccessibilityView(
					"button", 
					this, 
					Kosan.User.accessibility(i).lockTriggerSignal(),
					Kosan.User.accessibility(i).lockSignal()
				);
			});
			
		}
		
		_latestUpdateAccessibilityView = now();
	}
	
	// update view to unconnected due to unrecieved messages
	var _latestUpdateAccessibilityView = null;
	function checkUpdateAccessibilityView(){
		if (!Kosan.User) return;
		if (_latestUpdateAccessibilityView + 3 > now()) return;
				
		var signal = -1
		for(var i=0; i<Kosan.User.accessibilities().length;i++){
			var access = Kosan.User.accessibility(i);
			access.doorSignal(signal);
			access.doorTriggerSignal(signal);
			access.lockSignal(signal);
			access.lockTriggerSignal(signal);
		}
		
		updateAccessibilityView();
	}
	
	$(document).ready(function(){
		setInterval(checkUpdateAccessibilityView, 3000);
	});
</script>
@endsection

@section('dashboard.page')
<!-- Begin: dashboard-xs-sm -->
<div id="sm" class="v-sm d-block d-sm-none">
	<div class="bg-light pr-3 pl-3 pt-3">
		
		<!-- Begin: locations -->
		<div class="input-group flex-nowrap" onclick="$('modal-location').show()">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<i class="fas fa-map-marker-alt"></i>
				</span>
			</div>
			<input 
				id="location"
				type="text" 
				class="location-access form-control" 
				placeholder="Location" 
				readonly="readonly" 
				value="Semua Lokasi"
				style="cursor:pointer"
				aria-label="location" 
				aria-describedby="location"
				data-toggle="modal" 
				data-target="#sm-modal-locations">
		</div>
		<!-- End: locations -->
		
		<div id="sm-keys-container" class="h-100">{!!$allKeys!!}<div>
		
	</div>
</div>
<div id="sm-modal-locations" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 class="modal-title">Pilih Lokasi</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			<div class="list-group">
				<a href="#" 
					class="list-group-item list-group-item-action rounded-0 border-top-0"
					data-dismiss="modal" 
					onclick="
						$('.v-sm .location-access').val($(this).html().trim());
						getAllAccessibilities()
					">
					Semua Lokasi
				</a>
				@foreach($locations as $item)
					<a href="#" class="list-group-item list-group-item-action rounded-0 border-bottom-0"
						data-dismiss="modal" 
						onclick="
							$('.v-sm .location-access').val($(this).html().trim());
							getAccessibilitiesByLocation({{$item->id}})
						">
						{{$item->name}}
					</a>
				@endforeach
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- End: dashboard-xs-sm -->
@endsection