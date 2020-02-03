<?php 

$pf = "inp-gender-";
$labelId = $pf.uniqid();
$modalId = $pf.uniqid();
$placeholder = "Pilih Gender";

?>

<!-- Begin: gender-modal -->
<select id="inp-gender" name="gender" role="modal" class="d-none">
	<option value="">{{$placeholder}}</option>
	@foreach(config("kosan.genders") as $key=>$label)
		<option value="{{$key}}"  
			
			@if (isset($gender) && substr($gender,0,1) === $key)
				selected="selected" 
			@elseif (old("gender","") === $key)
				selected="selected" 
			@endif
			
		>
			{{ucwords($label)}}
		</option>
	@endforeach
</select>

<input id="{{$labelId}}" 
	type="text" 
	@if (isset($gender) && substr($gender,0,1) === $key)
		value="{{config("kosan.genders")[$gender]}}" 
	@elseif (old("gender", false))
		value="{{config("kosan.genders")[old('gender')]}}"
	@endif
	
	@if($errors->has('gender')) 
		class="form-control bg-white border-danger"
	@else 
		class="form-control bg-white"
	@endif
	
	placeholder="Pilih Gender" 
	readonly="readonly" 
	style="cursor:pointer" 
	data-toggle="modal" 
	data-target="#{{$modalId}}" />

@if ($errors->has('gender'))
	<small class="w-100 text-danger text-right">{{$errors->get("gender")[0]}}</small>
@endif

<div id="{{$modalId}}" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 class="modal-title font-weight-bold">{{$placeholder}}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			<div class="" role="list">
				@foreach(config("kosan.genders") as $key=>$label)
				<a 	href="#{{$labelId}}" 
					class="list-group-item list-group-item-action border-0"
					data-dismiss="modal" 
					data-value="{{$key}}"
					data-label-target="#{{$labelId}}"
					data-value-target="#inp-gender">
					{{ucwords(strtolower($label))}}
				</a>
				@endforeach
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- End: gender-modal -->

@push("script")
<script>
$(document).ready(function(){
	$("a[href='#{{$labelId}}']").click(function(){
		$( $(this).attr("data-label-target") ).val( $(this).html().trim() );
		$( $(this).attr("data-value-target") ).val( $(this).attr("data-value").trim() );
	});
});
</script>
@endpush