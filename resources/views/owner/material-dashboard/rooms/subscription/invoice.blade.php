<form id="{{$formID}}" 
	method="post" 
	action="{{route('web.owner.room.lease')}}" 
	class="m-0"
	enctype="multipart/form-data"
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
	
	<div class="modal-body border-0 p-4 invoice">
		<h6>Info Sewa</h6>
		<div>
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="date[start]" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Tanggal Mulai sewa" 
				value=""
				validate="date:dd-mm-yyyy"
				validate-error="#{{$validateID}}"/>
			<div id="{{$validateID}}" class="invalid text-danger d-none">Tentukan tanggal mulai sewa.</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="date[end]" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Tanggal berakhir sewa" 
				validate="date:dd-mm-yyyy"
				validate-error="#{{$validateID}}" />
			<div id="{{$validateID}}" class="invalid text-danger d-none">Tentukan tanggal berakhir sewa.</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="date[grace]" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Masa tenggang, contoh: 30 hari" />
			<div style="overflow:hidden;text-overflow:ellipsis; font-size:.8rem;">
				Pelanggan tetap bisa mengakses kamar kost selama masa tenggang. Kosongkan jika pelanggan tidak diizinkan akses setelah tanggal akhir sewa.
			</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="rate" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Harga Sewa" 
				value=""
				style="text-align:right"
				validate="min:3"
				validate-error="#{{$validateID}}"/>
			<div id="{{$validateID}}" class="invalid text-danger d-none">Tentukan harga sewa.</div>
		</div>
		<div class="mt-2">
			@php 
				$validateID = "_".\Str::random();
			@endphp
			<input name="tax" 
				type="text" 
				class="form-control {{$formID}}" 
				placeholder="Biaya Pajak" 
				style="text-align:right"/>
			<div style="overflow:hidden;text-overflow:ellipsis; font-size:.8rem;">
				Biaya pajak yang ditanggung oleh pelanggan. Kosongkan jika tidak dikenakan biaya pajak.
			</div>
		</div>
	</div>
	
	<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0 invoice">
		<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
		<button type="button" class="btn btn-grey" onclick="{{$formID}}.back()">Kembali</button>
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
	
	<div class="modal-body border-0 p-4 start-datepicker">
		<h6>Tanggal Mulai Sewa</h6>
		<div id="{{$formID}}-start-datepicker" data-date=""></div>
	</div>
	<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0 start-datepicker">
		<button type="button" class="btn btn-grey" onclick="{{$formID}}.showInvoice()">Kembali</button>
	</div>
	
	<div class="modal-body border-0 p-4 end-datepicker">
		<h6>Tanggal Berakhir Sewa</h6>
		<div id="{{$formID}}-end-datepicker" data-date=""></div>
	</div>
	<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0 end-datepicker">
		<button type="button" class="btn btn-grey" onclick="{{$formID}}.showInvoice()">Kembali</button>
	</div>
	
</form>