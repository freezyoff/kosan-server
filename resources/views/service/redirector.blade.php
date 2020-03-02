@extends('layout-root')

@section('body')
	
	@if($type)
		@include("service.redirector.bridge")
	@else
		@include("service.redirector.loader")
	@endif
	
@endsection