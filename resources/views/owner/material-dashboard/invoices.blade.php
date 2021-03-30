@php 
	$activeIndex = 4;
@endphp

@extends('owner.material-dashboard.dashboard', ['pageTitle'=>config("kosan.sidebar.owner.left.$activeIndex.label")])

@section("nav-item")

	{{-- sidebar --}}
	@include ("owner.material-dashboard.sidebar", ['activeIndex'=>$activeIndex])
	
@endsection

@push('style')
<link rel="stylesheet" href="{{mix('css/spinner.css')}}" />
<link rel="stylesheet" href="{{mix('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" />
<style>
	td div i {font-size:1rem !important; cursor:pointer;}
	.dropdown-toggle::after {margin-right:.5rem;}
	ul.nav>li.nav-item:last-child{border-bottom:1px solid #dee2e6 !important;}
	
	.card-icon>a:hover>span,
	.card-icon>div:hover>* {opacity:90%}
	
	.card-icon i {width:auto !important;}
	
	input.form-control[readonly] { background-color:transparent !important; }
	
	form[validation] .invalid{ font-size:.8rem; }
	form[validation] .form-control.invalid {
		background-image: linear-gradient(0deg,#f44336 2px,rgba(244,67,54,0) 0),linear-gradient(0deg,#d2d2d2 1px,hsla(0,0%,82%,0) 0); 
		color: #f44336;
	}
	
	.datepicker-inline { width:100% !important; }
	.datepicker-inline table.table-condensed { width:100% !important; }
	
	.form-control::placeholder { text-align:left; }
	
	.nav-item>div{margin:0; padding:.5rem 0 .5rem 0;}
</style>
@endpush

@push('script')
<script src="{{mix('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{mix('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js')}}"></script>
@endpush

@push('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-text card-header-primary">
				<div class="card-icon d-flex align-items-center">
					<div id="create" class="d-flex align-items-center" 
						style="cursor:pointer"
						data-target="#@htmlId('modal-create')"
						data-toggle="modal">
						<i class="material-icons">add</i>
						<span class="ml-2 mr-1">Buat Invoice</span>
					</div>
					
				</div>
			</div>
			<div class="card-body">
				@include('owner.material-dashboard.invoices.table')
			</div>
		</div>
	</div>
</div>
@endpush

@include('owner.material-dashboard.invoices.modal-create', ['id'=>'modal-create'])

@push('script')
<script src="{{mix('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{mix('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js')}}"></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush