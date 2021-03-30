<?php 

$oldPasswordError = session('oldPasswordError')? true : false;
$newPasswordError = session('newPasswordError')? true : false;
?>
@extends('layout-material-dashboard', ['sidebar'=>false])

@push('content')

<div class="row">
	<div class="col-sm-12">
		<form method="post" action="{{route('web.service.android.change-pwd',[$email])}}">
			<div class="card">
				<div class="card-header card-header-text card-header-primary">
					<div class="card-text">
						<h4 class="card-title">Ubah Password / Sandi</h4>
					</div>
				</div>
				<div class="card-body">
					@csrf
					<div class="mt-2 {{$oldPasswordError? 'has-danger' : ''}}">
						<input name="pwd[old]" type="password" class="form-control" placeholder="Sandi Lama" />
						@if ($oldPasswordError)
						<small id="emailHelp" class="form-text text-muted text-danger">{{$oldPasswordError}}</small>
						@endif
					</div>
					<div class="mt-4 {{$newPasswordError? 'has-danger' : ''}}">
						<input name="pwd[new]" type="password" class="form-control" placeholder="Sandi Baru" />
						@if ($newPasswordError)
						<small id="emailHelp" class="form-text text-muted text-danger">{{$newPasswordError}}</small>
						@endif
					</div>
					<div class="mt-4 {{$newPasswordError? 'has-danger' : ''}}">
						<input name="pwd[confirm]" type="password" class="form-control" placeholder="Ulangi Sandi" />
						@if ($newPasswordError)
						<small id="emailHelp" class="form-text text-muted text-danger">{{newPasswordError}}</small>
						@endif
					</div>
				</div>
				<div class="card-footer" style="align-items:flex-end; justify-content:flex-end">
					<button type="submit" class="btn btn-primary d-block">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
		
@endpush