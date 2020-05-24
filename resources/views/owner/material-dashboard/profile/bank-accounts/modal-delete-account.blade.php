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
				<h5 class="modal-title">Hapus Akun Bank</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
				<form id="{{$formID}}"
					class="mb-0"
					action="{{route('web.owner.profile.bank.delete')}}" 
					method="post"
					style="font-size:1rem">
					@csrf
					<input name="id" type="hidden" value="{{md5($acc->id)}}" />
					<div class="d-flex pt-2 pb-2 border-bottom">
						<div style="min-width:150px">Nama</div>
						<div>: {{$acc->name}}</div>
					</div>
					<div class="d-flex pt-2 pb-2 border-bottom">
						<div style="min-width:150px">Bank</div>
						<div>: ({{$acc->bank_code}}) {{$acc->bank_name()}}</div>
					</div>
					<div class="d-flex pt-2 pb-2 border-bottom">
						<div style="min-width:150px">Nomor Rekening</div>
						<div>: {{$acc->bank_account}}</div>
					</div>
					<div class="d-flex pt-2 pb-2">
						<div style="min-width:150px">Pemilik Rekening</div>
						<div>: {{$acc->holder}}</div>
					</div>
				</form>
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-danger" onclick="$('#{{$formID}}').submit()">Hapus</button>
			</div>
		</div>
	</div>
</div>
@endpush
<!-- end: owner/material-dashboard/profile/location/modal-change-name -->