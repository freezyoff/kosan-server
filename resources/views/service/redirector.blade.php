@extends('layout-root')

@section('body')
	@include("service.redirector.redirector-xs-sm")
	<script>
		setTimeout(function(){
			window.location = "{{$target}}"
		}, 1000);
	</script>
@endsection