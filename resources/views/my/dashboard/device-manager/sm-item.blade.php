<!-- Begin: Device card -->
<div class="card mt-3">
	<div class="card-body">
		<h5 id="card-title-{{md5($device->uuid)}}" class="card-title">
			<span>{{$device->mac}}</span>
			<span class="ml-1 badge badge-primary d-none">online</span>
		</h5>
		<h6 class="card-subtitle text-muted">
			{{$location->name}}
		</h6>
	</div>
	<div class="table-responsive">
		<table class="table table-striped text-dark table-sm">
			<tbody>
				<tr>
					<td colspan="2" class="text-nowrap">
						<span class="font-weight-bold">Info Hardware</span>
					</td>
				</tr>
				<tr>
					<td class="text-nowrap">Registered</td>
					<td class="text-nowrap">{{ $device->created_at }}</td>
				</tr>
				<tr>
					<td class="text-nowrap">Chipset</td>
					<td class="text-nowrap">
						@if (Str::contains($device->chipset()->first()->name, "ESP8266"))
							4 Pin Channels
						@elseif (Str::contains($device->chipset()->first()->name, "ESP32"))
							8 Pin Channels
						@else
							Unknown
						@endif
					</td>
				</tr>
				<tr>
					<td><div class="text-nowrap">Serial</div></td>
					<td><div class="text-nowrap">{{ $device->uuid }}</div></td>
				</tr>
				<tr>
					<td class="text-nowrap">PIC</td>
					<td class="text-nowrap">
						@if ($location->pic_user_id)
							<a href="#" 
								class="text-primary" 
								style="text-decoration:none"
								data-toggle="modal" 
								data-target="#mdl-sm-pic">
								<span data-toggle="tooltip" 
									data-placement="top" 
									title="Klik untuk ubah PIC">
									{{ ucwords($location->pic->name) }}
									({{ strtolower($location->pic->email) }})
								</span>
							</a>
						@else
							<a href="#" 
								class="text-primary" 
								style="text-decoration:none"
								data-toggle="modal" 
								data-target="#mdl-sm-pic">
								<i class="fas fa-share"></i>
								<span>Tunjuk PIC</span>
							</a>
						@endif
						@include('my.dashboard.device-manager.sm-pic-modal',["deviceAccessibilityID"=>$device->id])
					</td>
				</tr>
				<tr>
					<td colspan="2" class="nowrap">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="nowrap">
						<span class="font-weight-bold">Akses</span>
					</td>
				</tr>
				@foreach($device->accessibilities as $item)
				<tr>
					<td class="text-nowrap">{{$item->name}}</td>
					<td class="text-nowrap">
						<?php
							$collections = $item->userAccessibilities()
												->whereRaw("'".now()."' BETWEEN `valid_after` and DATE_ADD(`valid_before`, INTERVAL 3 DAY)");
						?>
						@foreach($collections->get() as $acc)
							@if ($acc->isExpired())
								@continue
							@endif
							<a href="#" class="d-block">
								{{ucwords($acc->user->name)}} 
								({{strtolower($acc->user->email)}})
							</a>
						@endforeach
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<!-- End: Device card -->