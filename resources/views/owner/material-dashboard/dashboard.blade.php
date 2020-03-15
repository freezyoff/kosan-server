@extends('layout-material-dashboard')

@push("navbar-brand")
<a href="{{url("")}}" class="navbar-brand brand d-lg-none" style="font-size:1.7rem">
	Kos<span class="unique cursor-pointer">a</span>n
</a>
<a class="navbar-brand d-none d-lg-block" href="{{url("")}}">
	@isset($pageTitle)	
		{{ucwords($pageTitle)}}
	@else
		Dashboard
	@endisset
</a>
@endpush

@section("nav-item")
	@include ("owner.material-dashboard.sidebar")
@endsection