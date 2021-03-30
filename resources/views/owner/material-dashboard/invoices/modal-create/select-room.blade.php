<div class="modal-header border-0 pt-0 pl-4 pr-4 pt-4 pb-0">
	<h5 class="modal-title">Pilih Lokasi</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body border-0 pt-4 pb-4">
	<ul class="nav flex-column">
	
		@foreach($locations->orderBy('name')->get() as $location)
			<li data-group="{{$location->name}}"
				class="nav-item border-top pl-2"
				style="cursor:pointer">
				<div class="d-flex align-items-center">
					<i class="material-icons text-success">indeterminate_check_box</i> 
					<span class="ml-2">Lokasi: {{$location->name}}</span>
				</div>
			</li>
			@foreach($location->rooms()->get() as $room)
			<li data-item="{{$location->name}}"
				class="nav-item border-top pl-2"
				style="cursor:pointer">
				<div class="d-flex align-items-center">
					<input name="room[]" class="d-none" type="checkbox" value="{{md5($room->id)}}" />
					<i class="material-icons text-info">check_box_outline_blank</i> 
					<span class="ml-2">{{$room->name}}</span>
				</div>
			</li>
			@endforeach
		@endforeach
		
	</ul>
</div>
<div class="modal-footer border-0 pt-0 d-flex align-items-right">
	<button class="btn btn-dark" data-dismiss="modal" type="button">Batal</button>
</div>