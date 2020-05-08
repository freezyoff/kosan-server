@php 
	$activeIndex = 3;
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

@push('style')
<style>
	td div i {font-size:1rem !important; cursor:pointer;}
	.dropdown-toggle::after {margin-right:.5rem;}
	.dropdown-toggle{font-size:1rem;}
	ul.nav>li.nav-item:last-child{border-bottom:1px solid #dee2e6 !important;}
	
	.card-icon>a:hover>span,
	.card-icon>div:hover>* {opacity:90%}
	
	.card-icon i {width:auto !important;}
</style>
@endpush

@push('script')

<script src="{{mix('js/http/owner/rooms.js')}}"></script>

@isset($preffered_location)
<script>
$(document).ready(()=>{
	APP.showTableData( $("#a_{{$preffered_location}}") );
});
</script>
@endisset

@endpush

@push('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-text card-header-primary">
				<div class="card-icon d-flex align-items-center">
				
					@php 
						$modalID = "_".\Str::random();
					@endphp
					<div class="d-flex align-items-center">						
						<i class="material-icons">location_on</i>
						<a id="btn-location" class="dropdown-toggle text-white" href="#{{$modalID}}" data-toggle="modal"></a>
						@include('owner.material-dashboard.rooms.modal-filter-location')
					</div>
					
					<div class="border-left ml-2 mr-2" style="height:1rem;opacity:50%">&nbsp;</div>
					
					@php 
						$modalID = "_".\Str::random();
					@endphp
					<div class="d-flex align-items-center" 
						style="font-size:1rem; cursor:pointer"
						data-target="#{{$modalID}}"
						data-toggle="modal">
						<i class="material-icons">add</i>
						<span class="ml-2 mr-1">Kamar Baru</span>
						@include('owner.material-dashboard.rooms.modal-create')
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead class="text-primary">
							<tr>
								<th>Kamar</th>
								<th class="text-right">Harian (Rp.)</th>
								<th class="text-right">Mingguan (Rp.)</th>
								<th class="text-right">Bulanan (Rp.)</th>
								<th class="text-right">&nbsp;</th>
							</tr>
						</thead>
						
						@foreach($locations->get() as $location)
						<tbody id="tbody_{{md5($location->id)}}">
						
							@forelse($location->rooms()->orderBy("name")->get() as $room)
							<tr>
								<td>{{$room->name}}</td>
								<td class="text-right">
									@if ($room->rate_daily)
										{{number_format($room->rate_daily,0,'.',',')}}
									@else
										-
									@endif
								</td>
								<td class="text-right">
									@if ($room->rate_weekly)
										{{number_format($room->rate_weekly,0,'.',',')}}
									@else
										-
									@endif
								</td>
								<td class="text-right">
									@if ($room->rate_monthly)
										{{number_format($room->rate_monthly,0,'.',',')}}
									@else
										-
									@endif
								</td>
								<td class="text-right">
									<div class="d-flex align-items-center justify-content-end">
										@php 
											$modalID = "_".\Str::random();
										@endphp
										<a href="#{{$modalID}}" data-toggle="modal">
											<i class="material-icons ml-1" 
												data-toggle="tooltip" 
												data-placement="top" 
												title="Ubah data">
												create
											</i>
										</a>
										@include('owner.material-dashboard.rooms.modal-change', ["modalID"=>$modalID, "room"=>$room])
									</div>
								</td>
							</tr>							
							@empty
							<tr>
								<td colspan="5" class="bg-warning">
									Kamar belum dibuat. <a href="javascript:;">Buat sekarang</a>
								</td>
							</tr>
							@endforelse
							
						</tbody>
						@endforeach
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endpush