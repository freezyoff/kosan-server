@php 
	$activeIndex = 2;
	$pageTitle = config("kosan.sidebar.owner.left.$activeIndex.label");
	$href = config("kosan.sidebar.owner.left.$activeIndex.href");
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>$pageTitle, 'href'=>$href])

@push('style')
<style>
	td div i {font-size:1rem !important; cursor:pointer;}
	/*td div:hover i{display:inline-block !important;}*/
</style>
@endpush

@push('script')
<script src="{{mix('js/http/owner/access-control.js')}}"></script>
<script>
$(document).ready(function(){
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})	
})
</script>
@endpush

@push('navbar-bread')
/@include('layout.material-dashboard.nav-breadcrumb', ['label'=> 'Kontrol Akses', 'href'=>url()->current()])
/@include('layout.material-dashboard.nav-breadcrumb', ['label'=> $device->alias?? $device->mac, 'href'=>url()->current()])
@endpush

@push('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card card-stats">
			<div class="card-header card-header-warning card-header-icon">
				<div class="card-icon">
					<i class="material-icons">gamepad</i>
				</div>
				@if ($device->alias)
					<p class="card-category">Nama Perangkat</p>
					<h4 class="card-title">{{$device->alias}}</h4>
				@else
					<p class="card-category">Mac Address</p>
					<h4 class="card-title">{{$device->mac}}</h4>
				@endif
			</div>
			<div class="card-body text-left">
				<table class="table">
					<thead>
						<tr>
							<th>Nama Kanal</th>
							<th>Kamar Kost</th>
						</tr>
					</thead>
					<tbody>
						@include("owner.material-dashboard.access-control.table")
					</tbody>
				</table>
			</div>
			<div class="card-footer p-0">
				
			</div>
		</div>
	</div>
</div>
@endpush