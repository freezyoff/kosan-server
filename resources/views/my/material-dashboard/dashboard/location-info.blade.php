@php 
$modalID = "_".\Str::random();
@endphp
<div class="card mb-0 mt-3">
	<div class="card-body">
		<div class="d-flex clickable">
			<i class="material-icons">location_on</i>
			<div class="ml-2 mr-2" style="flex-grow:1" data-toggle="modal" data-target="#{{$modalID}}">
				@if ($locationList->count() > 1 && strlen($selectedLocationId) > 0)
					@foreach($locationList->get() as $item)
						@if ($item->id == $selectedLocationId || md5($item->id) == $selectedLocationId)
							{{$item->name}}
						@endif
					@endforeach
				@else
					{{$locationList->first()->name}}
				@endif
			</div>
		
			@if ($locationList->count() > 1)
				@include('my.material-dashboard.dashboard.modal-location', ['modalID'=>$modalID])
			@endif
			
			@if ($locationList->count() > 1)
				<i class="material-icons">keyboard_arrow_down</i>
			@endif
		</div>
		
	</div>
</div>