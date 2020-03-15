@php
	
	$js_map = [
		0=>							$js2.uniqid(),
		"map"=>						$js2.uniqid(),
		"geo"=>						$js2.uniqid(),
		"marker"=>					$js2.uniqid(),
		"info"=>					$js2.uniqid(),
		"default"=>					$js2.uniqid(),
		"default_zoom"=>			$js2.uniqid(),
		"default_latLng"=>			$js2.uniqid(),
		"init"=>					$js2.uniqid(),
		"mapEvent"=>				$js2.uniqid(),
		"mapEvent_click"=>			$js2.uniqid(),
		"mapEvent_drag"=>			$js2.uniqid(),
		"mapEvent_dragEnd"=>		$js2.uniqid(),
		"moveMarker"=>				$js2.uniqid(),
		"moveMarkerToAddress"=>		$js2.uniqid(),
		"resolveGeolocation"=>		$js2.uniqid(),
		"handleGeolocationError"=>	$js2.uniqid(),
		"getAddress"=>				$js2.uniqid(),
		"initAddressInputListener"=>$js2.uniqid(),
		"updateMarkerAddressInfo"=>	$js2.uniqid()
	];
	
@endphp

@push("script")
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}"></script>
<script>

var {{$js_map[0]}} = {
	{{$js_map["map"]}}: null,
	{{$js_map["geo"]}}: null,
	{{$js_map["marker"]}}: null, 
	{{$js_map["info"]}}:  new google.maps.InfoWindow,
	
	{{$js_map["default"]}}: {
		{{$js_map["default_zoom"]}}: 8,
		{{$js_map["default_latLng"]}}: new google.maps.LatLng( 0, 0 )
	},
	
	{{$js_map["init"]}}: function(){
		{{$js_map[0]}}.{{$js_map["map"]}} = new google.maps.Map( document.getElementById( 'map-canvas' ), {
			zoom: 15,
			center: {{$js_map[0]}}.{{$js_map["default"]}}.{{$js_map["default_latLng"]}},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}),
		
		{{$js_map[0]}}.{{$js_map["marker"]}} = new google.maps.Marker({
			position: {{$js_map[0]}}.{{$js_map["default"]}}.{{$js_map["default_latLng"]}}, 
			map: {{$js_map[0]}}.{{$js_map["map"]}}
		}),
		{{$js_map[0]}}.{{$js_map["geo"]}} = new google.maps.Geocoder(),
		
		{{$js_map[0]}}.{{$js_map["map"]}}.addListener('click', {{$js_map[0]}}.{{$js_map["mapEvent"]}}.{{$js_map["mapEvent_click"]}}),
		{{$js_map[0]}}.{{$js_map["map"]}}.addListener('drag', {{$js_map[0]}}.{{$js_map["mapEvent"]}}.{{$js_map["mapEvent_drag"]}}),
		{{$js_map[0]}}.{{$js_map["map"]}}.addListener('dragend', {{$js_map[0]}}.{{$js_map["mapEvent"]}}.{{$js_map["mapEvent_dragEnd"]}}),
		
		
		{{$js_map[0]}}.{{$js_map["marker"]}}.setMap( {{$js_map[0]}}.{{$js_map["map"]}} ),
		
		{{$js_map[0]}}.{{$js_map["moveMarker"]}}( {{$js_map[0]}}.{{$js_map["default"]}}.{{$js_map["default_latLng"]}} ),
		{{$js_map[0]}}.{{$js_map["resolveGeolocation"]}}();
	},
	
	{{$js_map["mapEvent"]}}: {
		{{$js_map["mapEvent_click"]}}: function(e){
			{{$js_map[0]}}.{{$js_map["moveMarker"]}}(e.latLng);
		},
		{{$js_map["mapEvent_drag"]}}: function(e){
			{{$js_map[0]}}.{{$js_map["marker"]}}.setPosition( this.center );
		},
		{{$js_map["mapEvent_dragEnd"]}}: function(){
			{{$js_map[0]}}.{{$js_map["moveMarker"]}}(this.center);
		}
	},
	
	{{$js_map["moveMarker"]}}: function(latLng, zoom){
		zoom = zoom? zoom : {{$js_map[0]}}.{{$js_map["map"]}}.getZoom();
		
		//center the map over the result
		{{$js_map[0]}}.{{$js_map["map"]}}.setCenter(latLng);
		{{$js_map[0]}}.{{$js_map["map"]}}.setZoom(zoom);
		
		//set marker
		{{$js_map[0]}}.{{$js_map["marker"]}}.setPosition( latLng );
		
		//show info
		{{$js_map[0]}}.{{$js_map["updateMarkerAddressInfo"]}}(latLng);
		
		//update input field for post submit
		$("#inp-map-center").val(latLng.lat +","+ latLng.lng);
	},
	
	{{$js_map["moveMarkerToAddress"]}}: function (address, zoom){
		{{$js_map[0]}}.{{$js_map["geo"]}}.geocode( 
			{address:address}, 
			function(results, status){
				if (status == google.maps.GeocoderStatus.OK) {
					{{$js_map[0]}}.{{$js_map["moveMarker"]}}(
						results[0].geometry.location, 
						zoom? zoom : {{$js_map[0]}}.{{$js_map["default"]}}.{{$js_map["default_zoom"]}}
					);
				} else {
					alert('Geocode was not successful for the following reason: ' + status);
				}
			}
		);
	},
	
	{{$js_map["updateMarkerAddressInfo"]}}: function(latLng){
		{{$js_map[0]}}.{{$js_map["geo"]}}.geocode(
			{latLng: latLng}, 
			function(responses) {
				if (responses && responses.length > 0) {
					{{$js_map[0]}}.{{$js_map["marker"]}}.formatted_address = responses[0].formatted_address;
				} else {
					{{$js_map[0]}}.{{$js_map["marker"]}}.formatted_address = 'Cannot determine address at this location.';
				}
				{{$js_map[0]}}.{{$js_map["info"]}}.setContent({{$js_map[0]}}.{{$js_map["marker"]}}.formatted_address);
				{{$js_map[0]}}.{{$js_map["info"]}}.open({{$js_map[0]}}.{{$js_map["map"]}}, {{$js_map[0]}}.{{$js_map["marker"]}});
				$("#inp-map-info").val({{$js_map[0]}}.{{$js_map["marker"]}}.formatted_address);
				//console.log($("#inp-map-info").val());
			}
		);
	},
	
	{{$js_map["resolveGeolocation"]}}: function (){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				function(position) {
					{{$js_map[0]}}.{{$js_map["moveMarker"]}}({
						lat: position.coords.latitude,
						lng: position.coords.longitude
					});
				}, 
				function() {
					{{$js_map[0]}}.{{$js_map["handleGeolocationError"]}}(true, {{$js_map[0]}}.{{$js_map["info"]}}, {{$js_map[0]}}.{{$js_map["map"]}}.getCenter());
				}
			);
		} else {
			// Browser doesn't support Geolocation
			{{$js_map[0]}}.{{$js_map["handleGeolocationError"]}}(false, {{$js_map[0]}}.{{$js_map["info"]}}, {{$js_map[0]}}.{{$js_map["map"]}}.getCenter());
		}
	},
	
	{{$js_map["handleGeolocationError"]}}: function(browserHasGeolocation, gmapInfo, pos){
		gmapInfo.setPosition(pos);
		gmapInfo.setContent(browserHasGeolocation ?
							  'Error: The Geolocation service failed.' :
							  'Error: Your browser doesn\'t support geolocation.');
		gmapInfo.open({{$js_map[0]}}.{{$js_map["map"]}});
	}

};

</script>
<script>

function {{$js_map["getAddress"]}}(){
	var addr = "";
	var keys = ["#inp-province-label", "#inp-regency-label", "#inp-district-label", "#inp-address", "#inp-postcode"];
	$.each(keys, function(index, item){
		var val = $(item).val();
		if (val){
			addr += (addr.length>0? "," : "") + $(item).val();			
		}
	});
	return addr;
}

function {{$js_map["initAddressInputListener"]}}(){
	var keys = ["#inp-province", "#inp-regency", "#inp-district"];	
	$.each(keys, function(index, item){
		$(item).change(function(){ 
			var zoom = 0;
			switch(index){
				case 4:
				case 3:		
				case 2:		zoom = 15; break;
				case 1:		zoom = 10; break;
				case 0: 	zoom = 6; break;
				default:	zoom = {{$js_map[0]}}.{{$js_map["default"]}}.{{$js_map["default_zoom"]}};
			}
			{{$js_map[0]}}.{{$js_map["moveMarkerToAddress"]}}({{$js_map["getAddress"]}}(), zoom);
		});
	});
	
	$.each(["#inp-address", "#inp-postcode"], function(index, item){
		$(item).keyup(
			debounce(
				function(){ 
					{{$js_map[0]}}.{{$js_map["moveMarkerToAddress"]}}({{$js_map["getAddress"]}}(), 15);
				}, 
				500
			)
		);
	});
};

</script>
@endpush

@push("script.ready")
{{$js_map[0]}}.{{$js_map["init"]}}();
{{$js_map["initAddressInputListener"]}}();
@endpush
