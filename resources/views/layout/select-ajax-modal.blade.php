<?php 

/*
@param $id 				(string) => element id
@param $name 			(string) => element id
@param $title 			(string) => modal title
@param $data 			(array)  => [
	url					(string) => use url as source data
	reload				(string) => always reload data when modal show
	valueProp			(string) => data field name for value 
	labelProp			(string) => data field name for label 
]
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
$modalListId = $id ."-". uniqid();
$filterId = $modalId ."-". uniqid();

$modalOnShowEvent = "onShow_".uniqid();
$modalOnRequestEvent = "onLoad_".uniqid();
$modalListClickEvent = "onClick_".uniqid();

if (!isset($reload)){
	$reload = false;
}

if (!isset($btnCancelLabel)){
	$btnCancelLabel = ucwords("batal");
}

$btnBackEvent = "onBack_".uniqid();
$btnNextEvent = "onNext_".uniqid();
?>

<!-- Begin: select-modal -->
<select id="{{$id}}" name="{{$name}}" role="modal" class="d-none">
	<option selected="selected" value="">{{$title}}</option>
</select>

<input id="{{$labelId}}" 
	type="text" 
	class="form-control bg-white" 
	placeholder="{{$title}}" 
	readonly="readonly" 
	style="cursor:pointer" 
	data-toggle="modal" 
	data-target="#{{$modalId}}" />
	
<div id="{{$modalId}}" class="modal fade" tabindex="-1" role="dialog" onShow="{{$modalOnShowEvent}}({{$reload? true : false}})">
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
				<div id="{{$modalListId}}" class="mt-3 border border-top-1 border-bottom-1" role="list"></div>
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

<script>

function {{$modalOnRequestEvent}}(){
	$("#{{$modalListId}}").empty().append(
	`
		<div class="d-flex justify-content-center mt-3 mb-3">
			<div class="spinner-border text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>	
	`
	);
}

function {{$modalOnShowEvent}}(reload){
	if (reload || $("#{{$modalListId}}").find("a").length <= 0){
		
		{{$modalOnRequestEvent}}();
		
		url = "{!! $data['url'] !!}";
		url = typeof window[url] == "function"? window[url]() : "{!!$data['url']!!}";
		
		$.get( url, function( data ) {
			
			$("#{{$modalListId}}").empty();
			
			$.each(data, function(index, item){
				
				$("#{{$id}}").append(
					$("<option></option>").attr("value", ucwords(item.{{$data["valueProp"]}}, true))
						.html( ucwords(item.{{$data["labelProp"]}}, true) )
				);
				
				$("<a></a>").attr({
					href:"#",
					class:"list-group-item list-group-item-action border-0",
					"data-dismiss":"modal" ,
					"data-value":ucwords(item.{{$data["valueProp"]}}, true),
					"data-label-target":"#{{$labelId}}",
					"data-value-target":"#{{$valueId}}"
				})
				.html( ucwords(item.{{$data["labelProp"]}}, true) )
				.appendTo( $("#{{$modalListId}}") )
				.click({{$modalListClickEvent}});
			});
			
		});
		
	}
}

function {{$modalListClickEvent}}(){
	$($(this).attr("data-label-target")).val($(this).html().trim());
	$($(this).attr("data-value-target")).val($(this).attr("data-value"));
}

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

@push('script.ready')
	$("#{{$labelId}}").val("");
	$("#{{$filterId}}").keyup(function(){
		$("#{{$modalListId}}")
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
@endpush