@foreach($accessControls as $item)
<tr>
	<td>
		<div class="d-flex align-items-center">
			<div style="flex-grow:1">{{$item->name}}</div>
			
			@php 
				$modalID = "_".\Str::random();
			@endphp 
			
			<a href="#{{$modalID}}" data-toggle="modal">
				<i class="material-icons ml-2"
					data-toggle="tooltip"
					data-placement="top"
					title="Ubah nama kanal">
					create
				</i>
			</a>
			
			
			{{-- begin: change name modal --}}
			@push("modal")
				@include("owner.material-dashboard.access-control.modal-edit-chanel-name", ["modalID"=>$modalID, "accessCtrl"=>$item])
			@endpush
			{{-- end: change name modal --}}
			
			
		</div>
	</td>
	<td>
		<div class="d-flex align-items-center">
			<div style="flex-grow:1">
				@if ($item->room_id)
					{{$item->room->name}}
				@else
					<span class="badge badge-secondary">belum ada kamar terhubung</span>
				@endif
			</div>
			
			{{-- begin: change room --}}
			@php 
				$modalID = "_".\Str::random();
			@endphp 
			<a href="#{{$modalID}}" data-toggle="modal">
				<i class="material-icons ml-2"
					data-toggle="tooltip"
					data-placement="top"
					title="Ubah kamar terhubung">
					create
				</i>
			</a>
			@push("modal")
				@include("owner.material-dashboard.access-control.modal-change-room", ["modalID"=>$modalID, "accessCtrl"=>$item])
			@endpush
			{{-- end: change room --}}
		</div>
	</td>
</tr>
@endforeach