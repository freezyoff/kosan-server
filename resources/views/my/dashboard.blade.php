@extends('layout-material-dashboard')

@push("nav-item")
	@include("layout.material-dashboard.nav-item", ["label"=>"dashboard", 'icon'=>'dashboard', "href"=>url("")])
@endpush