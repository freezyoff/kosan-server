<?php
/**
 *	@param $id (string) label id
 */

$stepClass = "st-regency";
$js2 = $js."regency_";

$js_provinceLabel = $js2.uniqid();
$js_filterId 	= $js2.uniqid();
$js_listId 		= $js2.uniqid();

$js_pullData 	= $js2.uniqid();
$js_back 		= $js2.uniqid();
?>

@push("script")
<script>
function {{$js_back}}(){
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
	url = "{{ route("web.service.resource.region.regencies",[false]) }}/" + $("#inp-province").val();
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
				$("#inp-regency-label").val($(this).html().trim());
				$("#inp-regency").val( $(this).attr("data-value").trim() ).trigger("change");
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
	
	$("#inp-province").on("change paste keyup", function(){
		$("#{{$js_filterId}}").val("");
		$("#{{$js_provinceLabel}}").val( $("#inp-province-label").val() );
		{{$js_pullData}}();
	});
	
});
</script>
@endpush

<!-- Begin: st-regency -->
<input id="inp-regency" 
	name="address_regency" 
	type="hidden" 
	@if (isset($address_regency))
		value="{{$address_regency}}"
	@else
		value="{{old('address_regency')}}"
	@endif
	/>
<input id="inp-regency-label" 
	name="inp-regency-label" 
	type="hidden" 
	value="{{old('inp-regency-label')}}"
	/>
<div class="modal-footer {{$stepClass}}">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">
		<i class="fas fa-times"></i>
		Batal
	</button>
	<button type="button" class="btn btn-warning" onclick="{{$js_back}}()">
		<i class="fas fa-chevron-left"></i>
		Provinsi
	</button>
</div>
<div class="modal-body {{$stepClass}}">
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-map-marker-alt"></i></span>
		</div>
		<input id="{{$js_provinceLabel}}" 
			type="text" 
			class="form-control bg-transparent" 
			readonly="readonly" 
			value="{{old('inp-province-label')}}"
			/>
	</div>
	<div class="input-group mt-3">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-search"></i></span>
		</div>
		<input id="{{$js_filterId}}" type="text" class="form-control" autocomplete="off" placeholder="Kabupaten / Kota" />
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
	<button type="button" class="btn btn-warning" onclick="{{$js_back}}()">
		<i class="fas fa-chevron-left"></i>
		Provinsi
	</button>
</div>
<!-- End: st-province -->