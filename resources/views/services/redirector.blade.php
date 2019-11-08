@extends('layout-root')

@section('body')
	@include("services.redirector.redirector-xs-sm")
	<script>
		setTimeout(function(){
			window.location = "{{route('web.my.dashboard')}}"
		}, 2000);
	</script>
@endsection