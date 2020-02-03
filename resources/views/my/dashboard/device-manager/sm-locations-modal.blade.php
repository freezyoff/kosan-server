<!-- Begin: modal -->
<div id="mdl-locations" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-stretch bg-light">
				<h6 class="modal-title">Pilih Lokasi</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times</span>
				</button>
			</div>
			<div class="list-group">
				<a href="#" 
					class="list-group-item list-group-item-action rounded-0 border-top-0"
					data-dismiss="modal" 
					onclick="locationSelect(this, null)">
					Semua Lokasi
				</a>
				
				@foreach($locations as $item)
				<a href="#" class="list-group-item list-group-item-action rounded-0 border-bottom-0"
					data-dismiss="modal" 
					onclick="locationSelect(this, {{$item->id}})">
					{{$item->name}}
				</a>
				@endforeach
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- End: modal -->