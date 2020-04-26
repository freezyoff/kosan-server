@php 

if (\Str::startsWith($href, "route:")){
	$href = route(\Str::replaceFirst("route:", "", $href));
}

@endphp

<li class="nav-item @isset($active) active @endisset ">
	<a class="nav-link" href="{{$href}}">
		@isset($icon)
		<i class="material-icons">{{$icon}}</i>
		@endisset
		<p>{{ucfirst($label)}}</p>
	</a>
</li>