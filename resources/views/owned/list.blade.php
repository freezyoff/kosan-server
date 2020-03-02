@extends("my.owned")

@push("body.content.owned")

	@if(!$ownedCount)
	<div class="card" style="">
	  <div class="card-body">
		<!--<h5 class="card-title">Kamar Kost belum</h5>-->
		<!--<p class="card-text"></p>-->
		<a href="{{route("web.my.owned.make")}}" class="btn btn-primary">Buat jasa Kost</a>
	  </div>
	</div>
	@endif

@endpush