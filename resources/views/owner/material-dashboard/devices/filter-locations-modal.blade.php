@push("modal")
<!-- begin: owner/material-dashboard/devices/filter-locations-modal -->
<div id="filterByLocation" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
				<h5 class="modal-title">Filter Lokasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body border-0 pt-4 pb-4 pl-0 pr-0">
				<ul class="nav flex-column">
				
					@php 
						$url = route('web.owner.devices');
					@endphp
					
					<li class="nav-item border-top pl-2">
						<a class="nav-link" href="{{$url}}">Semua Lokasi</a>
					</li>
					@foreach(Auth::user()->locations as $location)
						<li class="nav-item border-top pl-2">
							<a class="nav-link" href="{{$url.'?location='.md5($location->id)}}">{{$location->name}}</a>
						</li>
					@endforeach
					
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- end: owner/material-dashboard/devices/filter-locations-modal -->
@endpush