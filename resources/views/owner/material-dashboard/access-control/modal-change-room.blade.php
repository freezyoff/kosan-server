<?php 
	$modalID = isset($modalID)? $modalID : "_".\Str::random();
	$createModalID = "_".\Str::random();
	
	$formID = "_".\Str::random();
	$inputID = "_".\Str::random();
	$buttonID = "_".\Str::random();
	$createBtnID = "_".\Str::random();
	
	$deviceLocationSet = $device->location? true : false;
?>

<!-- begin: owner/material-dashboard/access-control/modal-change-room -->
<div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">
					Pilih Kamar Kost
					@if ($deviceLocationSet)
						<span>di </span>
						<span class="text-primary">{{$device->location->name}}</span>
					@endif
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 pt-4 pb-4 pl-0 pr-0">
			
				@if ($deviceLocationSet)
					<ul class="nav flex-column">
						@forelse(\App\Kosan\Models\Room::findByLocation($device->location)->orderBy('name')->get() as $room)
							<li class="nav-item border-top pl-2">
								<form class="m-0" 
									method="post" 
									action="{{route('web.owner.access-control.change.room')}}"
									>
									@csrf
									<input name="device" type="hidden" value="{{md5($device->mac)}}" />
									<input name="accessCtrl" type="hidden" value="{{md5($accessCtrl->id)}}" />
									<input name="room" type="hidden" value="{{md5($room->id)}}" />
									<a class="nav-link" 
										href="javascript:void(0);"
										onclick="$(this).parent().submit()">
										{{$room->name}}
									</a>
								</form>
							</li>
						@empty
							<div class="alert alert-warning" role="alert">
								Belum ada kamar kost. 
								<a href="javascript:void(0)" 
									onclick="$('#'+{{$createBtnID}}).trigger('click')">
									Buat kamar kost &amp; hubungkan.
								</a>
							</div>
						@endforelse
						
					</ul>
					
				@else
					<div class="alert alert-warning m-0 ml-4 mr-4" style="box-shadow:none" role="alert">
						Lokasi perangkat tidak terdaftar. Segera hubungi Admin Kosan.
					</div>
				@endif
				
			</div>
			<div class="modal-footer border-0 pt-0 pl-4 pr-4 pb-4 pt-0">
				<button type="button" class="btn btn-grey" data-dismiss="modal">Batal</button>
				@if ($deviceLocationSet)
				<button id="{{$createBtnID}}" type="button" class="btn btn-primary">Buat kamar kost dan hubungkan</button>
				@endif
			</div>
		</div>
	</div>
</div>
@push('script')
<script>
$(document).ready(()=>{
	$("#{{$createBtnID}}").click(()=>{
		$("#{{$modalID}}").modal('hide');
		setTimeout(()=>{
			$("#{{$createModalID}}").modal('show');
		}, 500);
	});
});
</script>
@endpush
@push("modal")
	@include("owner.material-dashboard.access-control.modal-create-room", ["modalID"=>$createModalID, "accessCtrl"=>$accessCtrl])
@endpush
<!-- end: owner/material-dashboard/access-control/modal-change-room -->