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
				<h5 class="modal-title">Buat Akun Bank</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
				<form id="{{$formID}}" 
					class="mb-0"
					action="{{route('web.owner.profile.bank.add')}}" 
					method="post">
					@csrf
					<input name="user" type="hidden" value="{{md5(\Auth::user()->id)}}" />
					<div class="{{$formID}}-div-bank">
						<p class="mb-1">Cari Bank dengan Nomor Kode atau Nama Bank. Klik untuk memilih.</p>
						<input id="{{$formID}}-inp-filter" class="form-control mb-3" type="text" placeholder="Kode atau Nama Bank"/>
						<ul id="{{$formID}}-ul-banks" class="d-block nav" style="max-height:300px; overflow-y:scroll">
						@foreach(\App\Kosan\Models\Bank::all() as $bank)
							<li class="nav-item">
								<a class="d-block"
									href="javascript:;">
									<span>{{$bank->code}}</span>
									<span class="pl-3">{{$bank->name}}</span>
								</a>
							</li>
						@endforeach
						</ul>
					</div>
					<div class="{{$formID}}-div-details">
						<div>
							@php 
								$errorID = "_".\Str::random();
							@endphp
							<input id="{{$formID}}-inp-name" name="acc[name]" 
								class="form-control" 
								type="text" 
								placeholder="Nama Akun"
								validate="min:3"
								validate-error="#{{$errorID}}" />
							<div id="{{$errorID}}" class="invalid text-danger d-none">Minimal 3 karakter huruf atau angka.</div>
						</div>
						<div class="mt-2">
							@php 
								$errorID = "_".\Str::random();
							@endphp
							<input name="acc[bank_code]" 
								type="hidden" 
								validate="in:{{\App\Kosan\Services\Kosan\BankService::bankCodes(1)}}"
								validate-error="#{{$errorID}}" />
							<input id="{{$formID}}-inp-bank"
								class="form-control" 
								type="text" 
								placeholder="Pilih Bank" />
							<div id="{{$errorID}}" class="invalid text-danger d-none">Pilih bank terdaftar.</div>
						</div>
						<div class="mt-2">
							@php 
								$errorID = "_".\Str::random();
							@endphp
							<input id="{{$formID}}-inp-acc" name="acc[bank_account]" 
								class="form-control" 
								type="text" 
								placeholder="Nomor Rekening"
								validate="min:5"
								validate-error="#{{$errorID}}" />
							<div id="{{$errorID}}" class="invalid text-danger d-none">Nomor rekening minimal 5 karakter angka.</div>
						</div>
						<div class="mt-2">
							@php 
								$errorID = "_".\Str::random();
							@endphp
							<input name="acc[holder]" 
								class="form-control" 
								type="text" 
								placeholder="Nama Pemilik Rekening" 
								validate="min:5"
								validate-error="#{{$errorID}}" />
							<div id="{{$errorID}}" class="invalid text-danger d-none">Pemilik rekeing minimal 5 karakter huruf &amp; angka.</div>
						</div>
					</div>
				</form>
			</div>
			<div class="{{$formID}}-div-bank modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
			</div>
			<div class="{{$formID}}-div-details modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" onclick="$('#{{$formID}}').submit()">Simpan</button>
			</div>
		</div>
	</div>
</div>
@endpush

@push('script')
<script>
let {{$formID}}_steps=[".{{$formID}}-div-details", ".{{$formID}}-div-bank"];

function {{$formID}}_showView(index){
	if (index > 1) return;
	$({{$formID}}_steps[index]).show();
	$({{$formID}}_steps[index==0? 1 : 0]).hide();
}

$("#{{$formID}}-inp-bank").on('focusin', function(){
	{{$formID}}_showView(1);
	setTimeout(function(){ 
		$( $({{$formID}}_steps[1]).find("input:first") ).focus();
	}, 500);
});

$("#{{$formID}}-inp-filter").on('change keyup', function(){
	let searchStr = $(this).val().toLowerCase().trim();
	$("ul#{{$formID}}-ul-banks>li").filter(function(index, item){
		$(item).toggle($(item).html().toLowerCase().indexOf(searchStr) > -1);
	});
});

$("#{{$modalID}}").on('show.bs.modal', function() {
	{{$formID}}_showView(0);
	setTimeout(function(){ 
		$( $({{$formID}}_steps[0]).find("input:first") ).focus();
	}, 500);
});

$("ul#{{$formID}}-ul-banks>li").on('click', function(){
	$("#{{$formID}}-inp-bank-code").val($(this).find("span:first").html());
	setTimeout(function(){ 
		$( inps[3] ).focus();
	}, 500);
	{{$formID}}_showView(0);
	let inps = $({{$formID}}_steps[0]).find("input");
	let vals = $(this).find("span");
	let bank = [$(vals[0]).html(), $(vals[1]).html()];
	$( inps[1] ).val( bank[0] );
	$( inps[2] ).val( "("+ bank[0] +") "+  bank[1]);
});

$("#{{$formID}}-inp-acc").inputFilterNumber();


$("#{{$formID}}").requireValidation({
	firstErrorField: false,
	beforeValidation: function(form){
		this.firstErrorField = false;
	},
	onInvalidFoundCallback: function(invalidField){
		if (!this.firstErrorField){
			if (invalidField.name == "acc[bank_code]"){
				$("#{{$formID}}-inp-name").focus();
			}
			else{
				$(invalidField).focus();
			}
			this.firstErrorField = true;
		}
	}
});
</script>
@endpush
<!-- end: owner/material-dashboard/profile/location/modal-change-name -->