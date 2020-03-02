@extends("layout-topnav")

@push("body.content")
<div class="pt-3">
	<div class="card-deck">
	
		<div class="card  ml-lg-5 mr-lg-5 ml-xl-5 mr-xl-5">
			<div class="
					pl-3 pr-3 pt-3 
					pt-3 pb-3
					pt-sm-4 pb-sm-4
					pt-md-4 pb-md-4
					pt-lg-5 pb-lg-5
					card-img-top d-flex bra bg-info
				">
				<i class="fas fa-door-open fa-3x mx-auto text-light d-block d-sm-block d-md-none"></i>
				<i class="fas fa-door-open fa-4x mx-auto text-light d-none d-md-block d-lg-none"></i>
				<i class="fas fa-door-open fa-5x mx-auto text-light d-none d-lg-block"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">Laman Pengguna Kost</h5>
				<p class="card-text">.</p>
				<button class="btn btn-info w-100">Kunjungi</button>
			</div>
		</div>
		
		<div class="card  ml-lg-5 mr-lg-5 ml-xl-5 mr-xl-5">
			<div class="
					pl-3 pr-3 pt-3 
					pt-3 pb-3
					pt-sm-4 pb-sm-4
					pt-md-4 pb-md-4
					pt-lg-5 pb-lg-5
					card-img-top d-flex bra bg-success
				">
				<i class="fas fa-building fa-3x mx-auto text-light d-block d-sm-block d-md-none"></i>
				<i class="fas fa-building fa-4x mx-auto text-light d-none d-md-block d-lg-none"></i>
				<i class="fas fa-building fa-5x mx-auto text-light d-none d-lg-block"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">Laman Pemilik Kost</h5>
				<p class="card-text">.</p>
				<button class="btn btn-success w-100">Kunjungi</button>
			</div>
		</div>
	
	</div>
</div>
@endpush