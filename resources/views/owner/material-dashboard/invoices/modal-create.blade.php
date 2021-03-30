@push('modal')
<!-- begin: owner/material-dashboard/invoices/modal-create -->
<div class="modal fade" id="@htmlId('modal-create')" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		@include('owner.material-dashboard.invoices.modal-create.select-room', ['locations'=>Auth::user()->locations()])
	</div>
</div>
</div>
<!-- end: owner/material-dashboard/invoices/modal-create -->
@endpush

@push('script')
<script>
@jsVar('mdl-create') = {
	@jsVar('mdl-create-target'): $("#@htmlId('modal-create')"),
	@jsVar('mdl-create-groups'): null,
	@jsVar('mdl-create-onLoad'): function(){
		this.@jsVar('mdl-create-target')
			.on('show.bs.modal', this.@jsVar('mdl-create-onShow').bind(this))
			.on('hide.bs.modal', this.@jsVar('mdl-create-onHide').bind(this));
		
		//register event
		this.@jsVar('mdl-create-target').find('[data-item]').slideDown();
		this.@jsVar('mdl-create-target').find('[data-group]').on(
			'click', 
			this.@jsVar('mdl-create-events').@jsVar('mdl-create-events-location-click')
		);
		@jsVar('mdl-create').@jsVar('mdl-create-target').find('[data-item]').on(
			'click', 
			this.@jsVar('mdl-create-events').@jsVar('mdl-create-events-room-click')
		);
	},
	@jsVar('mdl-create-onShow'): function(){},
	@jsVar('mdl-create-onHide'): function(){},
	@jsVar('mdl-create-onNext'): function(){},
	@jsVar('mdl-create-onBack'): function(){},
	@jsVar('mdl-create-onSubmit'): function(){},
	@jsVar('mdl-create-events'): {
		@jsVar('mdl-create-events-location-click'): function(){
			let @jsVar('this') = $(this);
			let @jsVar('target') = @jsVar('mdl-create').@jsVar('mdl-create-target');
			@jsVar('target').find('[data-item="'+$(this).attr('data-group')+'"]')
				.slideToggle({
					done: function(){
						console.log(@jsVar('this'));
						@jsVar('this').find("i").html(
							@jsVar('this').next().height() > 0? "indeterminate_check_box" : "add_box"
						);
					}
				});
		},
		@jsVar('mdl-create-events-room-click'): function(){
			let @jsVar('checkbox') = $(this).find(':checkbox');
			let @jsVar('icon') = $(this).find('i');
			@jsVar('checkbox').trigger('click');
			@jsVar('icon').html(@jsVar('checkbox').is(":checked")?'check_box':'check_box_outline_blank');
		}
	}
};

$(document).ready(function(){
	@jsVar('mdl-create').@jsVar('mdl-create-onLoad')();
});
</script>
@endpush