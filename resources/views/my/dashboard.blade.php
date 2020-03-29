@extends('layout-material-dashboard')

@push("navbar-brand")
<a href="{{url("")}}" class="navbar-brand brand d-lg-none" style="font-size:1.7rem">
	Kos<span class="unique cursor-pointer">a</span>n
</a>
<a class="navbar-brand d-none d-lg-block" href="{{url("")}}">Dashboard</a>
@endpush

@push("nav-item")
	@include("layout.material-dashboard.nav-item", ["label"=>"dashboard", 'icon'=>'dashboard', "href"=>url(""), "active"=>1])
	@include("layout.material-dashboard.nav-item", ["label"=>"Perangkat Kost", 'icon'=>'usb', "href"=>url("devices")])
	@include("layout.material-dashboard.nav-item", ["label"=>"Faktur", 'icon'=>'dashboard', "href"=>url("")])
@endpush