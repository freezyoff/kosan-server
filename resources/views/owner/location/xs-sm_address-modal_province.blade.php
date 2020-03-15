<?php
/**
 *	@param $id (string) label id
 */

$stepClass = "st-province";
$js2 = $js."province_";

$js_filterId = $js2.uniqid();
$js_listId = $js2.uniqid();

$js_filter = $js2.uniqid();
$js_pullData = $js2.uniqid();
$js_next = $js2.uniqid();

?>

@push("script")
<script>
function {{$js_pullData}}(){
	$.get("{{ route("web.my.resource.region.provinces") }}", function(data){
		
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
				$("#{{$js_filterId}}").val("").trigger("change");
				$("#inp-province-label").val( $(this).html().trim() );
				$("#inp-province").val( $(this).attr("data-value").trim() ).trigger("change");	
				{{$js_step}}(1);
			});
		});
		
	});
}

function {{$js_next}}(){
	if ( !$(this).val() ){
		
	}
	else{
		{{$js_step}}(1);
	}
}

$(document).ready(function(){
	$("#{{$js_filterId}}").on("change paste keyup", function(){
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
	{{$js_pullData}}();
});
</script>
@endpush

<!-- Begin: st-province -->
<input id="inp-province" 
	name="address_province" 
	type="hidden" 
	@if (isset($address_province))
		value="{{$address_province}}"
	@else
		value="{{old('address_province')}}"
	@endif
	/>
<input 
	id="inp-province-label" 
	name="inp-province-label" 
	type="hidden" 
	value="{{old('inp-province-label')}}"
	/>
	
<div class="modal-body {{$stepClass}}">
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text font-weight-bold"><i class="fas fa-search"></i></span>
		</div>
		<input id="{{$js_filterId}}" type="text" class="form-control bg-transparent" autocomplete="off" placeholder="Provinsi" />
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
	<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
</div>
<!-- End: st-province -->