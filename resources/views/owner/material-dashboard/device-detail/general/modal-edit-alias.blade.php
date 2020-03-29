<?php 
	$formID = "_".\Str::random();
	$buttonID = "_".\Str::random();
	$aliasID = "_".\Str::random();
	$saveBtnID = "_".\Str::random();
	
	$formChangeFunc = "_".\Str::random();
	$formFocusFunc = "_".\Str::random();
	$buttonClickFunc = "_".\Str::random();
?>

<!-- begin: owner/material-dashboard/device-detail/general/modal-edit-alias -->
<form id="{{$formID}}" action="{{url()->current()}}" method="post">
@csrf
<input name="type" type="hidden" value="device-alias" />
<input name="device" type="hidden" value="{{md5($device->mac)}}" />
<div class="modal fade" id="sys-general-alias-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">Alias</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
				<input id="{{$aliasID}}" 
					name="alias" 
					type="text" 
					class="form-control" 
					placeholder="Nama Perangkat" 
					value="{{$device->alias?? $device->mac}}" 
					old-value="{{$device->alias?? $device->mac}}" />
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
				<button id="{{$saveBtnID}}" type="submit" class="btn btn-primary" disabled="disabled">Simpan</button>
			</div>
		</div>
	</div>
</div>
</form>

@push('script')
<script>
$("#{{$aliasID}}").on('change', function(){
	$("#{{$saveBtnID}}").attr('disabled', $('#{{$aliasID}}').val().length <= 0);
});
$("#general-alias-modal").on('show.bs.modal', function() {
    $("#{{$aliasID}}").val($("#{{$aliasID}}").attr('old-value'));
	setTimeout(function(){ 
		$("#{{$aliasID}}").focus().trigger('change');
	}, 500);
});
</script>
@endpush
<!-- end: owner/material-dashboard/device-detail/general/modal-edit-alias -->