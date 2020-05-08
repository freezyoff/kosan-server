<div class="col-12 col-lg-8">
	<div id="sys-general" class="card card-stats">
		<div class="card-header card-header-success card-header-icon">
			<div class="card-icon">
				<i class="material-icons">router</i>
			</div>
			<h3 class="card-title pt-3">
				<span class="">Info Perangkat</span>
			</h3>
		</div>
		<div class="card-body text-left">
			<div class="row pb-2 mb-2 m-0 border-bottom">
				<div class="col col-4 p-0">Nama Perangkat</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span class="text-truncate">{{$device->alias?? $device->mac}}</span>&nbsp;
					<a href="#" data-toggle="modal" data-target="#sys-general-alias-modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
				@include('owner.material-dashboard.device-detail.general.modal-edit-alias')
			</div>
			<div class="row pb-2 mb-2 m-0 border-bottom">
				<div class="col col-4 p-0">Chipset</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span class="text-truncate">{{$device->chipset->name}}</span>&nbsp;
					<a href="#" class="invisible" data-toggle="modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
			</div>
			<div class="row pb-2 mb-2 m-0 border-bottom">
				<div class="col col-4 p-0">MAC</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span class="text-truncate">{{$device->mac}}</span>&nbsp;
					<a href="#" class="invisible" data-toggle="modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
			</div>
			<div class="row pb-2 mb-2 m-0 border-bottom">
				<div class="col col-4 p-0">Nomor Serial</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span class="w-100 text-truncate">{{$device->uuid}}</span>&nbsp;
					<a href="#" class="invisible" data-toggle="modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
			</div>
			<div class="row pb-2 mb-2 m-0 border-bottom">
				<div class="col col-4 p-0">Versi Firmware</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span id="sys-general-device-hash" class="text-truncate d-none d-md-block w-100"></span>
					<span id="sys-general-device-hash-tooltips" 
							class="col col-sm-8 text-truncate text-right pr-0 d-md-none w-100"
							data-toggle="tooltip" 
							title=""></span>&nbsp;
					<a href="#" class="invisible" data-toggle="modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
			</div>
			<div class="row pb-2 m-0">
				<div class="col col-4 p-0">Kanal Terminal Pintu</div>
				<div class="col col-8 p-0 text-right d-flex align-items-center justify-content-end">
					<span class="text-truncate w-100">{{$device->chipset->used_io/2}} Terminal</span>&nbsp;
					<a href="#" class="invisible" data-toggle="modal">
						<i class="material-icons action-icons ml-2">edit</i>
					</a>
				</div>
			</div>
		</div>
		<div class="card-footer pt-0 pb-2">
			<div class="row">
				<div class="col">
					@php
						$accessControlURL = route('web.owner.access-control',["macHash"=>md5($device->mac)]);
					@endphp
					<button class="btn btn-warning d-block"
						type="button"
						onclick="document.location='{{$accessControlURL}}'">
						<i class="material-icons">gamepad</i>&nbsp;
						<span>Pengaturan Kontrol Akses</span>
					</button>				
				</div>
				<div class="col">
					<button id="restart" 
						class="btn btn-danger d-block"
						type="button"
						device="{{md5($device->mac)}}"
						owner="{{md5(Auth::user()->email)}}">
						<i class="material-icons">autorenew</i>&nbsp;
						<span>Restart Perangkat</span>
					</button>				
				</div>
			</div>
		</div>
	</div>
</div>