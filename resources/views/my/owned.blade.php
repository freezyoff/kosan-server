@extends("layout-topnav")

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section("body.content")
<div class="row pt-3">
	<div class="col-sm d-none d-md-block">
		@include("my.owned.nav")
	</div>
	<div class="col-sm">
		@stack("body.content.owned")
	</div>
</div>
@endsection
