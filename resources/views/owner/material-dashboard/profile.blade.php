@php 
	$activeIndex = 1;
	$pageTitle = config("kosan.sidebar.owner.left.$activeIndex.label");
	$href = config("kosan.sidebar.owner.left.$activeIndex.href");
	
	$modalID = '_'.\Str::random();
	$btnSaveID = '_'.\Str::random();
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>$pageTitle, 'href'=>$href])

@push('content')
<!-- begin: owner.material-dashboard.profile -->
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Pofil Pengguna</h4>
			</div>
			<div class="card-body">
				
				<div id="profile-email" class="row">
					<div class="col col-12 col-md-4 col-lg-4">Email</div>
					<div class="col col-12 col-md-8 col-lg-8 d-flex align-items-center">
						<div style="flex-grow:1">{{Auth::user()->email}}</div>
						<a href="javascript:;" class="invisible">
							<i class="material-icons" style="font-size:1.125rem">create</i>
						</a>
					</div>
				</div>
			
				<div id="profile-pwd" class="row align-items-center">
					<div class="col col-12 col-md-4 col-lg-4">Sandi</div>
					<div class="col col-12 col-md-8 col-lg-8 d-flex align-items-center">
						<div style="flex-grow:1; font-size:1.5rem;">{!!str_repeat("&#8226;",20)!!}</div>
						<a href="javascript:;" data-toggle="modal" data-target="#{{$modalID}}">
							<i class="material-icons" style="font-size:1.125rem">create</i>
						</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
<div>
<!-- end: owner.material-dashboard.profile -->
@endpush

@push('modal')
<!-- begin: owner.material-dashboard.profile -->
<form>
	@csrf
	<div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header border-0">
					<h5 class="modal-title">Ubah Sandi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body border-0 pb-0">
					<div class="form-group">
						<label>Sandi Baru</label>
						<input name="pwd" type="password" class="form-control" />
					</div>
					<div class="form-group">
						<label>Konfirmasi Sandi</label>
						<input name="confirm" type="password" class="form-control" />
					</div>
				</div>
				<div class="modal-footer border-0 pt-0">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button id="{{$btnSaveID}}" type="button" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- end: owner.material-dashboard.profile -->
@endpush

@push('script')
<script>
// path: owner.material-dashboard.profile
$(document).ready(function(){
	var focusCaller = function(){ $(this).find('input')[0].focus(); };
	$("#{{$modalID}}").on('shown.bs.modal', function(){
		setTimeout(focusCaller.bind(this), 300);
	});
	
	$("#{{$btnSaveID}}").click(function(){
		const form = $($("#{{$btnSaveID}}").parents('form')[0]);
		$.post("{{route('web.owner.change-pwd')}}", form.serialize());
	});
});
</script>
@endpush