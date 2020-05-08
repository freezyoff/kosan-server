<?php 
	$modalID = isset($modalID)? $modalID : "_".\Str::random();
	
	$formID = "_".\Str::random();
	$inputID = "_".\Str::random();
	$buttonID = "_".\Str::random();
	$saveBtnID = "_".\Str::random();
	
?>

<!-- begin: owner/material-dashboard/access-control/modal-edit-chanel-name -->
<form id="{{$formID}}" action="{{route('web.owner.access-control.change.name')}}" method="post">
@csrf
<input name="device" type="hidden" value="{{md5($device->mac)}}" />
<input name="accessCtrl" type="hidden" value="{{md5($accessCtrl->id)}}" />
<div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">Ubah Nama Kanal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
				<input id="{{$inputID}}" 
					name="name" 
					type="text" 
					class="form-control" 
					placeholder="Nama Kanal" 
					value="{{$accessCtrl->name?? ""}}" 
					old-value="{{$accessCtrl->name?? ""}}" />
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				<button id="{{$saveBtnID}}" type="submit" class="btn btn-primary" disabled="disabled">Simpan</button>
			</div>
		</div>
	</div>
</div>
</form>

@push('script')
<script>
$("#{{$inputID}}").on('change', function(){
	$("#{{$saveBtnID}}").attr('disabled', $('#{{$inputID}}').val().length <= 0);
});
$("#{{$modalID}}").on('show.bs.modal', function() {
    $("#{{$inputID}}").val($("#{{$inputID}}").attr('old-value'));
	setTimeout(function(){ 
		$("#{{$inputID}}").focus().trigger('change');
	}, 500);
});
</script>
@endpush
<!-- end: owner/material-dashboard/access-control/modal-edit-chanel-name -->