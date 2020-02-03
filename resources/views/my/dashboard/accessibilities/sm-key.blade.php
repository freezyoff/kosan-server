<!-- Begin: accessibilities card -->
<div class="card mt-3">
	<div class="card-body">
		<h5 class="card-title">
			{{$accessibility->deviceAccessibility()->first()->name}}
		</h5>
		
		<h6 class="card-subtitle mb-2 text-muted mb-3">
			{{$accessibility->deviceAccessibility()->first()->device()->first()->location()->first()->name}}
		</h6>
		
		<div class="btn-group d-flex align-content-stretch align-items-stretch mb-3" role="group" aria-label="Door Access">
			<div class="door-{{md5($accessibility->id)}} btn bg-secondary text-light">
				<i class="fas fa-question-circle"></i>
				<span class="pl-2"></span>
			</div>
			<div class="lock-{{md5($accessibility->id)}} btn bg-secondary text-light">
				<i class="fas fa-question-circle"></i>
				<span class="pl-2"></span>
			</div>
		</div>
		
		<button type="button" 
			class="btn-{{md5($accessibility->id)}} btn btn-secondary flex-grow-1 w-100"
			disabled="disabled"
			onclick="publishAccessibilityCommand(this, '{{$accessibility->id}}')">
			<i class="fas fa-question-circle"></i>
			<span class="pl-2"></span>
		</button>
	</div>
</div>
<!-- End: card -->