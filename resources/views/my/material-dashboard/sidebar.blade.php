@php 

$items = config('kosan.sidebar.user.left');

$idx = isset($activeIndex)? $activeIndex : 0;
$items[$idx]["active"] = 1;

@endphp

@foreach($items as $item)
	@include("layout.material-dashboard.nav-item", $item)
@endforeach