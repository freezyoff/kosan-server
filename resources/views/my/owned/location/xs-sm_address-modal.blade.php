<?php
/**
 *	@param $id (string) label id
 */

$js = "addressModal_";
$js_labelId = $js .uniqid();
$js_modalId = $js .uniqid();
$js_modalTitle = $js .uniqid();

// javascript function name
$js_scriptGroup = $js.uniqid();
$js_reinit = $js .uniqid();
$js_step = $js .uniqid();
$js_setTostep = $js.uniqid();
$js_back = $js.uniqid();
?>

@push("script.ready")
$("#{{$js_labelId}}").val( 
	$("#inp-address").val() && $("#inp-postcode").val() ?
	$("#inp-address").val() + " ("+ $("#inp-postcode").val() +")" : 
	""
);	
@endpush

@push("script")
<script>
var {{$js}}_step = ["st-province", "st-regency", "st-district", "st-village", "st-address"];
var {{$js}}_fields = ["inp-province", "inp-regency", "inp-district", "inp-village", "inp-address", "inp-postcode"];
var {{$js}}_cstep = 0;

function {{$js_reinit}}(){
	
	$.each( {{$js}}_step, function(index, item){
		$("."+item).addClass("d-none");
	});
	
	stepIndex = {{$js}}_step.length-1;
	for (var i=0; i<{{$js}}_step.length; i++){
		if ($("#"+{{$js}}_fields[i]).val() == ""){
			stepIndex = i;
			break;
		}
	}
	
	{{$js_setTostep}}( i<{{$js}}_step.length? i :  stepIndex );
	
	$("#inp-village, #inp-district, #inp-regency, #inp-province").each(function(index, item){
		if ($(item).val()){
			$(item).trigger('change');
		}
	})
	
}

function {{$js_step}}(step){
	max = {{$js}}_step.length - 1
	index =  {{$js}}_cstep + step;
	if ( index >= 0 && index <= max ){
		{{$js_setTostep}}(index);
	}
}

function {{$js_setTostep}}(index){
	hide = "." + {{$js}}_step[{{$js}}_cstep];
	$( hide ).addClass("d-none");
	
	{{$js}}_cstep = index;
	show = "." + {{$js}}_step[{{$js}}_cstep];
	$( show ).removeClass("d-none");
}

function {{$js_back}}(){
	if ( {{$js}}_cstep - 2 >= 0 ){
		$("#"+{{$js}}_fields[{{$js}}_cstep - 2]).trigger("change");
	}
}

</script>
@endpush

<!-- Begin: address-modal -->

@php
	$addressError = $errors->has('address_province') || $errors->has('address_regency') ||
				$errors->has('address_district') || $errors->has('address_village') || 
				$errors->has('address_address') || $errors->has('address_postcode');
@endphp

<input id="{{$js_labelId}}" 
	type="text" 
	placeholder="Alamat" 
	readonly="readonly" 
	style="cursor:pointer" 
	data-toggle="modal" 
	data-target="#{{$js_modalId}}" 
	
	value="
		@isset($address_address)
			{{$address_address}} 
		@endisset
		
		@isset($address_postcode) 
			{{$address_postcode}} 
		@endisset
	"
	
	@if($addressError) 
		class="form-control bg-white border-danger"
	@else 
		class="form-control bg-white"
	@endif
	
	/>
	
@if ($errors->has('address_province'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_province")[0]}}</small>
@elseif ($errors->has('address_regency'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_regency")[0]}}</small>
@elseif ($errors->has('address_district'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_district")[0]}}</small>
@elseif ($errors->has('address_village'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_village")[0]}}</small>
@elseif ($errors->has('address_address'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_address")[0]}}</small>
@elseif ($errors->has('address_postcode'))
	<small class="w-100 text-danger text-right">{{$errors->get("address_postcode")[0]}}</small>
@endif

<div id="{{$js_modalId}}" class="modal fade" tabindex="-1" role="dialog" onShow="{{$js_reinit}}()">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 id="{{$js_modalTitle}}" class="modal-title font-weight-bold">Alamat</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			
			@include("my.owned.location.xs-sm_address-modal_province")
			@include("my.owned.location.xs-sm_address-modal_regency")
			@include("my.owned.location.xs-sm_address-modal_district")
			@include("my.owned.location.xs-sm_address-modal_village")
			@include("my.owned.location.xs-sm_address-modal_address")
			
		</div>
	</div>
</div>
<!-- End: address-modal -->