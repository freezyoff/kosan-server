<div class="table-responsive">
	<table class="table">
		<thead class="text-primary">
			<tr>
				<th>Kamar</th>
				<th>Perangkat</th>
				{{--
				<th class="text-right">Harian (Rp.)</th>
				<th class="text-right">Mingguan (Rp.)</th>
				<th class="text-right">Bulanan (Rp.)</th>
				--}}
				<th>Konektifitas</th>
				<th class="text-right">&nbsp;</th>
			</tr>
		</thead>
		
		@foreach($locations->get() as $location)
		<tbody id="tbody_{{md5($location->id)}}">
		
			@forelse($location->rooms()->orderBy("name")->get() as $room)
			<tr>
				<td>{{$room->name}}</td>
				<td>
					@php 
						$acc = $room->accessControls();
					@endphp
					@if ($acc->count())
						@php 
							$accDevice = $acc->first()->device()->first();
						@endphp
						<button class="btn btn-info btn-sm" 
							onclick="document.location='{{route('web.owner.device',[md5($accDevice->mac)])}}'">
							@if ($accDevice->alias)
								{{$accDevice->alias}}
							@else
								{{$accDevice->mac}}
							@endif
						</button>
					@else
						tidak terhubung
					@endif
				</td>
				
{{--
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
--}}
				<td>
					<div class="d-flex">
					
						{{-- begin: change button --}}
						@php 
							$modalID = "_".\Str::random();
						@endphp
						<a href="#{{$modalID}}" data-toggle="modal">
							<i class="material-icons" 
								style="min-width:24px"
								data-toggle="tooltip" 
								data-placement="top" 
								title="Ubah data">
								create
							</i>
						</a>
						@include('owner.material-dashboard.rooms.modal-change', ["modalID"=>$modalID, "room"=>$room])
						{{-- end: change button --}}
						
						{{-- begin: subscription button --}}
						@php 
							$modalID = "_".\Str::random();
						@endphp
						<a href="#{{$modalID}}" data-toggle="modal">
							<i class="material-icons" 
								style="min-width:24px"
								data-toggle="tooltip" 
								data-placement="top" 
								title="Sewakan">
								receipt
							</i>
						</a>
						@include('owner.material-dashboard.rooms.modal-subscription', ["modalID"=>$modalID, "room"=>$room])
						{{-- end: subscription button --}}
						
						@php 
							$modalID = "_".\Str::random();
						@endphp
						<a href="{{route('web.owner.rooms.access.histories', [md5($room->id)])}}">
							<i class="material-icons" 
								style="min-width:24px; font-weight:900"
								data-toggle="tooltip" 
								data-placement="top" 
								data-offset="10px"
								title="Daftar Akses Kamar">
								login
							</i>
						</a>
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