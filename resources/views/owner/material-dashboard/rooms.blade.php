@php 
	$activeIndex = 2;
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

@push('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-icon card-header-primary">
				<div class="card-icon"><i class="material-icons">location_on</i></div>
			</div>
			<div class="card-body">
				<div class="btn-group">
					<div class="btn btn-primary">Lokasi</div>
					<button id="btn-location" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div id="btn-location-dropdown" class="dropdown-menu" aria-labelledby="location-dropdown">
						@foreach($locations->get() as $location)
						<a class="dropdown-item" href="#">{{$location->name}}</a>
						@endforeach
					</div>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead class="text-primary">
							<tr>
								<th>Kamar</th>
								<th class="text-right">Harian</th>
								<th class="text-right">Bulanan</th>
								<th class="text-right">Tahunan</th>
								<th class="text-right"></th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						
						@foreach($locations->get() as $location)
						@foreach($location->rooms()->get() as $room)
						<tbody>
							<tr>
								<td>{{$room->name}}</td>
								<td class="text-right">{{number_format($room->rate_dialy,0,'.',',')}} IDR</td>
								<td class="text-right">{{number_format($room->rate_weekly,0,'.',',')}} IDR</td>
								<td class="text-right">{{number_format($room->rate_monthly,0,'.',',')}} IDR</td>
								<td class="text-right">
									<span data-toggle="tooltip" 
										data-placement="top" 
										title="
											@if($room->ready)
												Kamar siap untuk disewa
											@else
												Kamar belum siap untuk disewa
											@endif
										"
										class="badge p-2 cursor-pointer 
											@if($room->ready) 
												badge-info
											@else 
												badge-danger 
											@endif " >
										@if($room->ready)
											Tersedia
										@else
											Persiapan
										@endif
									</span>
								</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" class="btn btn-info">
										<i class="material-icons">autorenew</i>
									</button>
									<button type="button" rel="tooltip" class="btn btn-success">
										<i class="material-icons">edit</i>
									</button>
									<button type="button" rel="tooltip" class="btn btn-danger">
										<i class="material-icons">close</i>
									</button>
								</td>
							</tr>
						</tbody>
						@endforeach
						@endforeach
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endpush

@push('scripts')
<script>
let getLocationItems = (index)=>{
	if (index>=0){
		return $($("div#btn-location-dropdown").find('a')[index]);
	}
	return $("div#btn-location-dropdown").find('a');
}

let setLocation = (selectedIndex)=>{
	let item = getLocationItems(selectedIndex);
	$("button#btn-location").html((item? "<span class='mr-3'>" + item.html() + "</span>" : ""));
};

let getLocationSelectedIndex = ()=>{
	let str = $("button#btn-location").html().trim();
	let selected = -1;
	getLocationItems().each((index, item)=>{
		if ($(item).html().trim() == str){
			selected = index;
		}
	});
	
	return selected>=0? selected : 0;
};

let getLocationItemIndex = (value)=>{
	value = value.toLowerCase();
	let idx = -1;
	getLocationItems().each((index, item)=>{
		if (value == $(item).html().trim().toLowerCase()){
			idx = index;
		}
	});
	return idx;
};

$(document).ready(()=>{
	//ini location dropdown item onclick
	getLocationItems().each((index, item)=>{
		$(item).click(()=>{
			setLocation(getLocationItemIndex($(item).html()));
		});
	});
	setLocation(getLocationSelectedIndex());
	$('[data-toggle="tooltip"]').tooltip({
		template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
	}); 
});
</script>
@endpush