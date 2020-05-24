@push('style')
<style>
.card-icon>a:hover>span,
.clickable>.clickable>.card-icon>div:hover>* {opacity:90%}

.card-icon i {width:auto !important;}
</style>
@endpush

<div class="card">
	<div class="card-header card-header-text card-header-primary">
		<div class="card-icon d-flex align-items-center">
		
			<div class="d-flex align-items-center">						
				<i class="material-icons" style="font-size:22px">account_balance_wallet</i>
				<span class="ml-1">Akun Bank</span>
			</div>
			
			<div class="border-left ml-2 mr-2" style="height:1rem;opacity:50%">&nbsp;</div>
			
			@php 
				$modalID = "_".\Str::random();
			@endphp
			<div class="d-flex align-items-center clickable" 
				style="cursor:pointer"
				data-target="#{{$modalID}}"
				data-toggle="modal">
				<i class="material-icons">add</i>
				<span class="ml-1 mr-1">Akun Baru</span>
				@include('owner.material-dashboard.profile.bank-accounts.modal-add-account',['modalID'=>$modalID])
			</div>
			
		</div>
	</div>
	<div class="card-body">
		<p class="mt-1">Daftar Akun Bank akan disertakan pada lembar Faktur (<i>Invoice</i>) yang dikirimkan melalui email kepada penyewa kamar. Silahkan buat Akun Bank apabila menerima pembayaran melalui transfer.</p>
		<div class="table-responsive">
			<table class="table mb-1">
				<thead class="text-primary">
					<tr>
						<th>Akun</th>
						<th>Nama Bank</th>
						<th>Nomor Akun</th>
						<th>Atas Nama</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@forelse($bankAccounts->get() as $acc)
					<tr>
						<td>{{$acc->name}}</td>
						<td>{{$acc->bank_name()}}</td>
						<td>{{$acc->bank_account}}</td>
						<td>{{$acc->holder}}</td>
						<td>
							<div class="d-flex align-items-center justify-content-end">
								@php 
									$modalID = "_".\Str::random();
								@endphp
								<a href="#{{$modalID}}" data-toggle="modal">
									<i class="material-icons ml-1" 
										data-toggle="tooltip" 
										data-placement="top" 
										title="Ubah Nama Lokasi">
										create
									</i>
								</a>
								@include('owner.material-dashboard.profile.bank-accounts.modal-edit-account',['modalID'=>$modalID, 'acc'=>$acc])
								@php 
									$modalID = "_".\Str::random();
								@endphp
								<a href="#{{$modalID}}" data-toggle="modal">
									<i class="material-icons ml-1" 
										data-toggle="tooltip" 
										data-placement="top" 
										title="Ubah Nama Lokasi">
										delete
									</i>
								</a>
								@include('owner.material-dashboard.profile.bank-accounts.modal-delete-account',['modalID'=>$modalID, 'acc'=>$acc])
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="4">Belum memiliki akun bank</td>
					</tr>
				@endforelse
				</tbody>
			</table>
		</div>
		
	</div>
</div>