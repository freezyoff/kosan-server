<?php 
	$modalID = isset($modalID)? $modalID : "_".\Str::random();
	
	$formID = "_".\Str::random();
	$inputID = "_".\Str::random();
	$buttonID = "_".\Str::random();
?>

@push('modal')
<!-- begin: owner/material-dashboard/access-control/modal-subscription -->
<div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<form id="{{$formID}}" 
			method="post" 
			action="{{route('web.owner.room.lease')}}" 
			class="m-0"
			validation>
			@csrf
			<input name="room" type="hidden" value="{{md5($room->id)}}" />
			<div class="modal-header border-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">
					<span>Sewakan kamar kost </span>
					<span class="text-primary">{{$room->name}}</span>
					<span>di </span> 
					<span class="text-primary">{{$location->name}}</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 p-4">
			{{--
				<div>
					@php 
						$validateID = "_".\Str::random();
					@endphp
					<input name="ktp[nik]" 
						type="text" 
						class="form-control {{$inputID}}" 
						placeholder="NIK (Nomor Induk Kependudukan)" 
						validate="min:16"
						validate-error="#{{$validateID}}"/>
					<div id="{{$validateID}}" class="invalid text-danger d-none">Minimal 16 karakter angka.</div>
				</div>
			--}}
				<div class="mt-2">
					@php 
						$validateID = "_".\Str::random();
					@endphp
					<input name="ktp[name]" 
						type="text" 
						class="form-control {{$inputID}}" 
						placeholder="Nama Pelanggan" 
						validate="min:10|alphabet"
						validate-error="#{{$validateID}}"/>
					<div id="{{$validateID}}" class="invalid text-danger d-none">Minimal 10 karakter huruf.</div>
				</div>
				<div class="mt-2">
					@php 
						$validateID = "_".\Str::random();
					@endphp
					<input name="ktp[email]" 
						type="text" 
						class="form-control {{$inputID}}" 
						placeholder="Email Pelanggan" 
						validate="email" 
						validate-error="#{{$validateID}}"/>
					<div id="{{$validateID}}" class="invalid text-danger d-none">Gunakan format email.</div>
				</div>
				<div class="mt-2">
					@php 
						$validateID = "_".\Str::random();
					@endphp
					<input name="ktp[tlp]" 
						type="text" 
						class="form-control {{$inputID}}" 
						placeholder="Telepon Pelanggan" 
						validate="phone|min:8"
						validate-error="#{{$validateID}}"/>
					<div id="{{$validateID}}" class="invalid text-danger d-none">Minimal 8 karakter angka.</div>
				</div>
				<div class="mt-2">
					@php 
						$validateID = ["_".\Str::random(), "_".\Str::random(), "_".\Str::random()];
					@endphp
					<button id="{{$validateID[0]}}" 
						type="button" 
						class="btn btn-info d-block mb-0 w-100" 
						onclick="$(this).next().trigger('click')">
						Upload KTP
					</button>
					<input name="ktp[img]"
						type="file" 
						class="form-control {{$inputID}} d-none" 
						placeholder="Foto KTP" 
						validate="max:2097152" 
						validate-error="#{{$validateID[0]}}, #{{$validateID[2]}}"
						accept="image/jpg,image/png,image/jpeg,image/gif,image/bmp"/>
					<div id="{{$validateID[1]}}" style="overflow:hidden;text-overflow:ellipsis; font-size:.8rem;"></div>
					<div id="{{$validateID[2]}}" class="invalid text-danger d-none">Maksimal 2MB extensi jpg,jpeg,png,gif,bmp</div>
				</div>
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
			<div id="datepicker" data-date="12/03/2012"></div>
			<input type="hidden" id="my_hidden_input">
	</form>
	</div>
</div>
</div>
@endpush

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<style>
form[validation] .invalid{ font-size:.8rem; }
form[validation] .form-control.invalid {
	background-image: linear-gradient(0deg,#f44336 2px,rgba(244,67,54,0) 0),linear-gradient(0deg,#d2d2d2 1px,hsla(0,0%,82%,0) 0); 
	color: #f44336;
}
</style>
@endpush

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
$("#{{$modalID}}").on('show.bs.modal', function() {
	$("input.{{$inputID}}").each((index, item)=>{
		$(item).val("");
	});
	setTimeout(function(){ 
		$($("input.{{$inputID}}")[0]).focus();
	}, 500);
});

$( $("input.{{$inputID}}")[0] ).inputFilterNumber();
$( $("input.{{$inputID}}")[2] ).inputFilterPhone();
$( $("input.{{$inputID}}")[3] ).on('change', function(){
	$(this).next().html( this.files[0].name );
});

$("#{{$formID}}").requireValidation();

$('#datepicker').datepicker();
$('#datepicker').on('changeDate', function() {
    $('#my_hidden_input').val(
        $('#datepicker').datepicker('getFormattedDate')
    );
});
</script>
@endpush
<!-- end: owner/material-dashboard/access-control/modal-subscription -->