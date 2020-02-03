<?php 
/*
@param $id 				(string) => element id
@param $name 			(string) => element id
@param $title 			(string) => modal title
@param $data 			(array)  => key and value
@param $btnCancelLabel 	(string) => label of close button
@param $btnBackLabel 	(string) => label of back button
@param $btnNextLabel 	(string) => label of next button
*/ 

if (!isset($id)){
	$id = $name;
}

$labelId = $id ."-". uniqid();
$valueId = $id;
$modalId = $id ."-". uniqid();
$filterId = $modalId ."-". uniqid();

if (!isset($btnCancelLabel)){
	$btnCancelLabel = ucwords(strtolower("batal"));
}
$btnBackEvent = "onBack_".uniqid();
$btnNextEvent = "onNext_".uniqid();
?>

<!-- Begin: select-modal -->
<select id="{{$id}}" name="{{$name}}" role="modal" class="d-none">
	<option selected="selected" value="">{{$title}}</option>
	@foreach($data as $key=>$label)
		<option value="{{$key}}">{{ucwords($label)}}</option>
	@endforeach
</select>

<input id="{{$labelId}}" 
	type="text" 
	class="form-control bg-white" 
	placeholder="{{$title}}" 
	readonly="readonly" 
	style="cursor:pointer" 
	data-toggle="modal" 
	data-target="#{{$modalId}}" />
	
<div id="{{$modalId}}" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 class="modal-title font-weight-bold">{{$title}}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text font-weight-bold"><i class="fas fa-search"></i></span>
					</div>
					<input 
						id="{{$filterId}}"
						type="text" 
						class="form-control" 
						autocomplete="off"
						aria-label="inp-phone-number" />
				</div>
			
				<div class="mt-3 border border-top-1 border-bottom-1" role="list">
					@foreach($data as $key=>$label)
					<a 	href="#" 
						class="list-group-item list-group-item-action border-0"
						data-dismiss="modal" 
						data-value="{{$key}}"
						data-label-target="#{{$labelId}}"
						data-value-target="#{{$valueId}}">
						{{ucwords(strtolower($label))}}
					</a>
					@endforeach
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{$btnCancelLabel}}</button>
				@if(isset($btnBackLabel))
				<button type="button" class="btn btn-secondary" onClick="{{$btnBackEvent}}">{{$btnCancelLabel}}</button>
				@endif
				@if(isset($btnNextLabel))
				<button type="button" class="btn btn-secondary" onClick="{{$btnNextEvent}}">{{$btnNextLabel}}</button>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- End: select-modal -->

@if (isset($btnBackLabel) || isset($btnNextEvent))
@push("script")
	<script>
	@if (isset($btnBackLabel))
		function {{$btnBackEvent}}(){
			$(this).prev("input[type='hidden']").trigger("click");
		}
	@endif

	@if (isset($btnNextLabel))
		function {{$btnNextEvent}}(){
			$(this).next("input[type='hidden']").trigger("click");
		}
	@endif
	</script>
@endif
@endpush

@push('script.ready')
	
	$("#{{$filterId}}").keyup(function(){
		$($(this).parents("div.modal")[0])
			.find("a")
			.each(function(index, item){
				src = $(item).html().toLowerCase();
				str = $("#{{$filterId}}").val().toLowerCase();
				if (src.indexOf(str) > -1){
					$(item).removeClass("d-none");
				}
				else{
					$(item).addClass("d-none");
				}
			})
	});
	
	$("#{{$modalId}}").find("a").each(function(index, item){
		$(item).click(function(){
			$($(item).attr("data-label-target")).val($(item).html().trim());
			$($(item).attr("data-value-target")).val($(item).attr("data-value"));
		});
	});
	
@endpush