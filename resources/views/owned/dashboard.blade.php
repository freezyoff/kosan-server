@extends("layout-topnav")

@section('styles')
<!-- Begin: global style -->
<style>
.form-control:disabled, .form-control[readonly]{ background-color:#FEFEFE; }
</style>
<!-- End: global style -->
@endsection

@section('body.attr')
	class="bg-light pb-3" style="color:#1e1e1e"
@endsection

@section("body.content")
<div class="row">
	<div class="col d-none d-md-block">left nav</div>
	<div class="col">nav</div>
</div>
@endsection
