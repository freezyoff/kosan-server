@extends("layout-topnav")

@section('styles')
<!-- Begin: global style -->
<style>
.top-nav{ font-size:1.05rem; color:#FEFEFE;}
.top-nav:hover{ color:#FEFEFE;}
.top-nav.active { color:#007bff; }
.form-control:disabled, .form-control[readonly]{ background-color:#FEFEFE; }
</style>
<!-- End: global style -->
@endsection

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section("body.content")

<div class="pt-2">
@if ( !$ownedLocationCount && !$managedLocationCount && !$subscribedLocationCount)
<!-- Begin: Landing view -->
	@include("my.dashboard.landing")
<!-- End: Landing view -->
@endif
</div>

@endsection
