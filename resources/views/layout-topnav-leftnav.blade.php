@extends('layout-root')

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section('body')
	
	<div id="topnav" class="card pt-1 pb-1 position-fixed d-flex" 
		style="background-color:#1e1e1e;border-radius:0;box-shadow: 0 0 5px 1px #717171;z-index:999;width: 100%;top: 0;left: 0;">
		<div class="container-fluid">
			@include("layout.topnav")
		</div>
	</div>
	@include("layout.leftnav")
	
	<div class="container-fluid mt-5 mb-5">
		@yield("body.content")
		@stack("body.content")
	</div >
	
@endsection