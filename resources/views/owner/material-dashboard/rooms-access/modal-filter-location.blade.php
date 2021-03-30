<?php 
	$modalID = isset($modalID)? $modalID : "_".\Str::random();
?>
@push("modal")
<!-- begin: owner/material-dashboard/rooms/modal-filter-location -->
<div id="{{$modalID}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">Pilih Lokasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 pt-4 pb-4 pl-0 pr-0">
				<ul class="nav flex-column">
				
					@foreach($locations->orderBy('name')->get() as $location)
					<li class="nav-item border-top pl-2">
						<a id="a_{{md5($location->id)}}" 
							href="javascript:;"
							onclick="APP.showTableData($('#a_{{md5($location->id)}}'))"
							table-data="{{md5($location->id)}}"
							class="nav-link modal-filter-location"
							data-dismiss="modal">
							{{$location->name}}
						</a>
					</li>
					@endforeach
					
				</ul>
			</div>
			<div class="modal-footer border-0 pt-0 d-flex align-items-right">
				<button class="btn btn-dark" data-dismiss="modal" type="button">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- end: owner/material-dashboard/rooms/modal-filter-location -->
@endpush