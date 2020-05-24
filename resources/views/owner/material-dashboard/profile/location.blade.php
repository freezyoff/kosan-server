<div class="card">
	<div class="card-header card-header-text card-header-primary">
		<div class="card-icon d-flex align-items-center">
		
			<div class="d-flex align-items-center mr-2">	
				<i class="material-icons" style="font-size:22px">location_on</i>
				<span>Lokasi Kost</span>
			</div>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table mb-0">
				<thead class="text-primary">
					<tr>
						<th>Lokasi</th>
						<th>Alamat</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($locations->get() as $loc)
					<tr>
						<td>{{$loc->name}}</td>
						<td>{{$loc->address}}</td>
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
								@include('owner.material-dashboard.profile.location.modal-change-name',['location'=>$loc])
							</div>
						</td>
					</tr>
				
				@endforeach
				</tbody>
			</table>
		</div>
		
	</div>
</div>