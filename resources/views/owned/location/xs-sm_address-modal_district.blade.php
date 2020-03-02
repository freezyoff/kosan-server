<?php
/**
 *	@param $id (string) label id
 */

$stepClass = "st-district";
$js2 = $js."district_";

$js_provinceLabel 	= $js2.uniqid();
$js_regencyLabel 	= $js2.uniqid();
$js_filterId 		= $js2.uniqid();
$js_listId 			= $js2.uniqid();

$js_filter 			= $js2.uniqid();
$js_pullData 		= $js2.uniqid();
$js_back			= $js2.uniqid();
?>

@push("script")
<script>
function {{$js_back}}(){
	$("#inp-province").trigger("change");
	{{$js_step}}(-1);
}

function {{$js_pullData}}(){
	$("#{{$js_listId}}").empty().append(
		`<div class="d-flex justify-content-center mt-3 mb-3">
			<div class="spinner-border text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>`
	);
	url = "{{ route("web.my.resource.region.districts",[false]) }}/" + $("#inp-regency").val();
	$.get(url, function(data){
		
		$("#{{$js_listId}}").empty();
		
		$.each(data, function(index, item){			
			$("<a />").attr({
				href:"#{{$js_labelId}}",
				class:"list-group-item list-group-item-action border-0",
				"data-dismiss":"modal" ,
				"data-value":ucwords(item.code, true),
			})
			.html( ucwords(item.name, true) )
			.appendTo( $("#{{$js_listId}}") )
			.click(function(event){
				event.stopPropagation();
				$("#inp-district-label").val( $(this).html().trim() );
				$("#inp-district").val( $(this).attr("data-value").trim() ).trigger("change");
				{{$js_step}}(1);
			});
		});
		
	});
}

$(document).ready(function(){
	$("#{{$js_filterId}}").keyup(function(){		
		$("#{{$js_listId}}")
			.find("a")
			.each(function(index, item){
				src = $(item).html().toLowerCase();
				str = $("#{{$js_filterId}}").val().toLowerCase();
				if (src.indexOf(str) > -1){
					$(item).removeClass("d-none");
				}
				else{
					$(item).addClass("d-none");
				}
			});
	});
	
	$("#inp-regency").on("change paste keyup", function(){
		$("#{{$js_filterId}}").val("");
		$("#{{$js_provinceLabel}}").val( $("#inp-province-label").val() );
		$("#{{$js_regencyLabel}}").val( $("#inp-regency-label").val() );
		{{$js_pullData}}();
	});
});
</script>
@endpush

<!-- Begin: st-regency -->
<input id="inp-district" 
	name="address_district" 
	type="hidden" 
	@if (isset($address_district))
		value="{{$address_district}}"
	@else 
		value="{{old('address_district')}}"
	@endif
	/>
<input id="inp-district-label" 
	name="inp-district-label" 
	type="hidden" 
	value="{{old('inp-district-label')}}"
	/>
<div class="modal-body {{$stepClass}}">
	@php
		$collect = [
			'inp-province-label'=>	$js_provinceLabel, 
			'inp-regency-label'=>	$js_regencyLabel
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
				value="{{old($key)}}"
				/>
		</div>
	@endforeach
	<div class="input-group mt-3">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-search"></i></span>
		</div>
		<input id="{{$js_filterId}}" type="text" class="form-control" autocomplete="off" placeholder="Kecamatan" />
	</div>
	<div id="{{$js_listId}}" class="mt-3 border border-top-1 border-bottom-1" role="list">
		<div class="d-flex justify-content-center mt-3 mb-3">
			<div class="spinner-border text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer {{$stepClass}}">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">
		<i class="fas fa-times"></i>
		Batal
	</button>
	<button type="button" class="btn btn-secondary btn-warning" onclick="{{$js_back}}()">
		<i class="fas fa-chevron-left"></i>
		Kabupaten / Kota
	</button>
</div>
<!-- End: st-province -->