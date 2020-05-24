<?php 
	$formID = "_".\Str::random();
	$buttonID = "_".\Str::random();
	$nameID = "_".\Str::random();
	$saveBtnID = "_".\Str::random();
	
	$formChangeFunc = "_".\Str::random();
	$formFocusFunc = "_".\Str::random();
	$buttonClickFunc = "_".\Str::random();
?>

@push('modal')
<!-- begin: owner/material-dashboard/profile/location/modal-change-name -->
<div id="{{$modalID}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">Ubah nama Lokasi <span class="text-primary">{{$location->name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
				<form id="{{$formID}}" action="{{route('web.owner.profile.change.location.name')}}" method="post">
					@csrf
					<input name="location" type="hidden" value="{{md5($location->id)}}" />
					@php
						$errorID = "_".\Str::random();
					@endphp
					<input id="{{$nameID}}" 
						name="name" 
						type="text" 
						class="form-control" 
						placeholder="Nama Lokasi Baru" 
						value="{{$location->name}}" 
						old-value="{{$location->name}}" 
						validate="min:3"
						validate-error="#{{$errorID}}"/>
					<div id="{{$errorID}}" class="invalid text-danger d-none">Minimal 3 karakter huruf &amp; angka.</div>
				</form>
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				<button id="{{$saveBtnID}}" type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</div>
	</div>
</div>
@endpush

@push('script')
<script>
$("#{{$modalID}}").on('show.bs.modal', function() {
	let target = $("#{{$nameID}}");
    target.val($("#{{$nameID}}").attr('old-value'));
	setTimeout(function(){ 
		target.focus().trigger('change');
		target[0].setSelectionRange($("#{{$nameID}}").val().length, $("#{{$nameID}}").val().length);
	}, 500);
});

$("#{{$formID}}").requireValidation();
$("#{{$saveBtnID}}").click(function(){
	$("#{{$formID}}").trigger('validate');
});
</script>
@endpush
<!-- end: owner/material-dashboard/profile/location/modal-change-name -->