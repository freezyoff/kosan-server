@extends("my.owned")

@push("body.content.owned")

<form action="{{route('web.my.owned.make')}}" method="POST">
	@csrf
	<div class="card" style="">
		<div class="card-body">
			<h5 class="card-title">Kost Baru</h5>
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="name">@</span>
				</div>
				<input name="name" class="form-control" type="text" placeholder="Nama Kosan" />
			</div>
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="address">@</span>
				</div>
				@include("my.owned.location.xs-sm_address-modal")
			</div>
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="roomCount">@</span>
				</div>
				<input name="roomCount" class="form-control" type="text" placeholder="Jumlah Kamar" />
			</div>
			<div class="input-group mt-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="pic">@</span>
				</div>
				<input name="pic" class="form-control" type="text" placeholder="Email PIC" />
			</div>
			<div class="mt-3 text-right">
				<button class="btn btn-secondary" 
					type="button" 
					onclick="document.location='{{route('web.my.owned')}}'">
					Batal
				</button>
				<button class="btn btn-primary" type="submit">Simpan</button>
			</div>
		</div>
	</div>
</form>

@endpush