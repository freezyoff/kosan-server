@php 
	$pageTitle = ucwords($pageTitle?? config("kosan.sidebar.owner.left.0.label"));
	$href = isset($href)? $href : "javascript:;";
@endphp

@extends('layout-material-dashboard')


@prepend("navbar-bread")
	@include('layout.material-dashboard.nav-breadcrumb', ['label'=> $pageTitle, 'href'=>$href])
@endprepend

@section("nav-item")
	@include ("owner.material-dashboard.sidebar")
@endsection