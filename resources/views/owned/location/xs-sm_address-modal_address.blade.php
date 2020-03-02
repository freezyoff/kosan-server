<?php
/**
 *	@param $id (string) label id
 */

$stepClass 	= "st-address";
$js2 		= $js."address_";

$js_provinceLabel	= $js2.uniqid();
$js_regencyLabel 	= $js2.uniqid();
$js_districtLabel 	= $js2.uniqid();
$js_villageLabel 	= $js2.uniqid();

$js_back			= $js2.uniqid();
$js_validate 		= $js2.uniqid();
$js_save			= $js2.uniqid();
?>

@push("script")
<script>
function {{$js_validate}}(){
	$("#{{$js_labelId}}").val(
		$("#inp-address").val() +" ("+ $("#inp-postcode").val() +")"
	);
}

function {{$js_back}}(){
	$("#inp-district").trigger("change");
	{{$js_step}}(-1);
}

$(document).ready(function(){
	$("#inp-village").on("change paste keyup", function(){
		$("#{{$js_provinceLabel}}").val( $("#inp-province-label").val() );
		$("#{{$js_regencyLabel}}").val( $("#inp-regency-label").val() );
		$("#{{$js_districtLabel}}").val( $("#inp-district-label").val() );
		$("#{{$js_villageLabel}}").val( $("#inp-village-label").val() );
	});
	
	$("#inp-postcode").inputFilter(function(value){
		return value.length > 0? /^([0-9]){1,}$/.test(value) : true;
	});
	
	$("#inp-address, #inp-postcode").on("change paste keyup", function(){
		$("#{{$js_save}}").prop(
			"disabled", 
			$("#inp-address").val() == "" || $("#inp-postcode").val() == "" 
		);
	});
});
</script>
@endpush

@include("my.owned.location.xs-sm_address-modal_address-map-js")

<!-- Begin: st-address -->
<div class="modal-body {{$stepClass}}">

	@php
		$collect = [
			'inp-province-label'=> $js_provinceLabel, 
			'inp-regency-label'=>  $js_regencyLabel, 
			'inp-district-label'=> $js_districtLabel, 
			'inp-village-label'=>  $js_villageLabel
		];
	@endphp
	@foreach($collect as $key=>$item)
		<div class="input-group @if(!$loop->first) mt-3 @endif">
			<div class="input-group-prepend">
				<span class="input-group-text font-weight-bold"><i class="fas fa-map-marker-alt"></i></span>
			</div>
			<input id="{{$item}}" 
				type="text" 
				class="form-control bg-transparent" 
				readonly="readonly" 
				value="{{old($key)}}"/>
		</div>
	@endforeach
	
	<div class="input-group mt-3">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-map-marker-alt"></i></span>
		</div>
		<input id="inp-address" 
			name="address_address" 
			type="text" 
			class="form-control" 
			autocomplete="off" 
			placeholder="Alamat" 
			@if (isset($address_address))
				value="{{$address_address}}"
			@else
				value="{{old('address_address')}}"
			@endif
			/>
	</div>
	
	<div class="input-group mt-3">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-envelope"></i></span>
		</div>
		<input id="inp-postcode" 
			name="address_postcode" 
			type="text" 
			class="form-control" 
			autocomplete="off" 
			placeholder="Kode Pos" 
			@if (isset($address_postcode))
				value="{{$address_address}}"
			@else
				value="{{old('address_postcode')}}"
			@endif
			/>
	</div>
	
	<div class="mt-3">Lokasi kost</div>
	<input id="inp-map-center" name="inp-map-center" type="hidden" />
	<input id="inp-map-info" name="inp-map-info" type="hidden" />
	<div id="map-canvas" class="border d-block" style="height:400px;"></div>
	
</div>
<div class="modal-footer {{$stepClass}}">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">
		<i class="fas fa-times"></i>
		Batal
	</button>
	<button type="button" class="btn btn-secondary btn-warning" onclick="{{$js_back}}()">
		<i class="fas fa-chevron-left"></i>
		Kelurahan / Desa
	</button>
	<button id="{{$js_save}}" type="button" class="btn btn-primary" data-dismiss="modal" onclick="{{$js_validate}}()" disabled="disabled">
		<i class="fas fa-chevron-right"></i>
		Simpan
	</button>
</div>
<!-- End: st-province -->