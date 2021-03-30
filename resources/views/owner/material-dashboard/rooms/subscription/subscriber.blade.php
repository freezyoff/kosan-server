<form id="{{$formID}}" 
	method="post" 
	action="{{route('web.owner.room.find.subscriber')}}" 
	class="m-0"
	validation>
	@csrf
	<input name="room" type="hidden" value="{{md5($room->id)}}" />
	<div class="modal-header border-0 pl-4 pr-4 pt-4 pb-0">
		<h5 class="modal-title">
			<span>Hak Akses Kamar Kost </span>
			<span class="text-primary">{{$room->name}}</span>
			<span>di </span> 
			<span class="text-primary">{{$location->name}}</span>
		</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	
	<div class="modal-body border-0 p-4 subscriber">
		<h6>Info Pelanggan</h6>
		<div>
			@php 
				$validateID = "_".\Str::random();
				$notificationID = "_".\Str::random();
				$spinnerID = "_".\Str::random();
			@endphp
			<div id="{{$spinnerID}}" style="position:absolute; right:1.5rem; display:none">
				<div class="spinner-border text-primary" role="status" style="width:1rem; height:1rem; position:relative; border-width:0.15rem">
				  <span class="sr-only">Loading...</span>
				</div>
			</div>
			<input id="subscriber{{$formID}}" 
				name="ktp[nik]" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="NIK (Nomor Induk Kependudukan)" 
				notification="#{{$notificationID}}"
				spinner="#{{$spinnerID}}"
				validate="min:16"
				validate-error="#{{$validateID}}"/>
			<div id="{{$notificationID}}" class="text-info" style="font-size:.8rem">Pelanggan terdaftar</div>
			<div id="{{$validateID}}" class="invalid text-danger d-none">Minimal 16 karakter angka.</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="ktp[name]" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Nama Pelanggan" 
				validate="min:6|alphabet"
				validate-error="#{{$validateID}}"/>
			<div id="{{$validateID}}" class="invalid text-danger d-none">Minimal 6 karakter huruf.</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="ktp[email]" 
				type="text" 
				class="form-control {{$formID}}" 
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
				class="form-control {{$formID}}" 
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
				onfocus="$(this).trigger('click')"
				onclick="$(this).next().trigger('click')">
				Upload KTP
			</button>
			<input name="ktp[img]"
				type="file" 
				class="form-control {{$formID}} d-none" 
				placeholder="Foto KTP" 
				validate="max:2097152" 
				validate-error="#{{$validateID[0]}}, #{{$validateID[2]}}"
				accept="image/jpg,image/png,image/jpeg,image/gif,image/bmp"/>
			<div id="{{$validateID[1]}}" style="overflow:hidden;text-overflow:ellipsis; font-size:.8rem;"></div>
			<div id="{{$validateID[2]}}" class="invalid text-danger d-none">Maksimal 2MB extensi jpg,jpeg,png,gif,bmp</div>
		</div>
	</div>
	
	<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0 input-fields">
		<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary">Lanjut</button>
	</div>
	
</form>