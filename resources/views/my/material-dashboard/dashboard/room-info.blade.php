<?php 
	$dropdown = "_".\Str::random();
?>
<div class="card mb-0 mt-3">
	<div class="card-body">
		<div class="d-flex clickable">
			<i class="material-icons"
				onclick="$('#{{$dropdown}}').dropdown('toggle');">
				home
			</i>
			
			<a href="javascript:;" 
				class="dropdown-toggle ml-2 mr-2" 
				data-toggle="dropdown"
				style="flex-grow:1">
				{{$rooms->first()->name}}
			</a>

			<div id="{{$dropdown}}" class="dropdown-menu" style="width:100%;">
				@foreach($rooms->get() as $sub)
					<a class="dropdown-item" href="javascript:;">{{$sub->name}}</a>
				@endforeach
			</div>
			
			<i class="material-icons"
				onclick="$('#{{$dropdown}}').dropdown('toggle');">
				keyboard_arrow_down
			</i>
			
		</div>
	</div>
</div>