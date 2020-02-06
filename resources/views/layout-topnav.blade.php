@extends('layout-root')

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section('body')
	
	@include("layout.topnav")
	
	<div class="container mt-5 mb-5">
		@yield("body.content")
		@stack("body.content")
	</div >
	
@endsection