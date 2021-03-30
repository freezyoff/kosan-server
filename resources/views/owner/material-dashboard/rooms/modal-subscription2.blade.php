<?php 
	$modalID = isset($modalID)? $modalID : "_".\Str::random();
	$formSubscriber = "_".\Str::random();
	$formInvoice = "_".\Str::random();
?>
	
@push('modal')
<!-- begin: owner/material-dashboard/rooms/modal-subcriber-subscriber -->
<div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		@include('owner.material-dashboard.rooms.subscription.subscriber', ['formID'=>$formSubscriber, 'room'=>$room])
		@include('owner.material-dashboard.rooms.subscription.invoice', ['formID'=>$formInvoice, 'room'=>$room])
	</div>
</div>
</div>
<!-- end: owner/material-dashboard/rooms/modal-subcriber-subscriber -->
@endpush

@push('script')
<script>
const {{$formSubscriber}} = {
	form: $( "#{{$formSubscriber}}" ),
	onModalShow: function() {
		this.setNotivicationVisible(false);
		setTimeout(function(){ 
			$( $("input.{{$formSubscriber}}")[0] ).focus();
		}, 500);
	},
	onModalHide: function(){
		this.form.find("input.{{$formSubscriber}}").each((index, item)=>{
			$(item).val("");
		});
	},
	onModalSubmit: function(e, isValid){
		e.preventDefault();
		e.stopPropagation();
		if (isValid){
			{{$formSubscriber}}.next();
		}
		return false;
	},
	onModalSearch: $.debounce(250, function(e) {
		{{$formSubscriber}}.changeProfileValue({});
		$.ajax({
			url: {{$formSubscriber}}.form.attr('action'), 
			accepts: "application/json",
			method: "POST",
			data: {{$formSubscriber}}.form.serialize(),
			success: function(data){
				{{$formSubscriber}}.changeProfileValue(data);
			},
			complete: function(){
				$( $("#subscriber{{$formSubscriber}}").attr('spinner') ).hide();
			},
			beforeSend: function(){
				$( $("#subscriber{{$formSubscriber}}").attr('spinner') ).show();
			}
		});
	}),
	resetValidation: function(){
		this.form.resetValidation();
		return this;
	},
	changeProfileValue: function(json){
		var found = Object.keys(json).length>0;
		
		if (found) {
			this.resetValidation();
			this.setNotivicationVisible(true);
		}
		else{
			this.setNotivicationVisible(false);
			json = {name:"", email:"", phone:{number:""}};
		}
		
		this.form.find("input.{{$formSubscriber}}[name='ktp[name]']").val(json.name).attr('readonly', found);
		this.form.find("input.{{$formSubscriber}}[name='ktp[email]']").val(json.email).attr('readonly', found);
		this.form.find("input.{{$formSubscriber}}[name='ktp[tlp]']").val(json.phone.number).attr('readonly', found).trigger('keyup');
		
		//upload button
		const img = this.form.find("input.{{$formSubscriber}}[name='ktp[img]']");
		if (found){
			img.attr('old-validate', img.attr('validate')).removeAttr('validate').parent().slideUp();
		}
		else{
			img.attr('validate', img.attr('old-validate')).parent().slideDown();
		}
		
	},
	setNotivicationVisible: function(visible){
		let notificationElement = $("#subscriber{{$formSubscriber}}").attr('notification');
		if (visible){
			$(notificationElement).slideDown();
		}
		else{
			$(notificationElement).slideUp();
		}
	},
	next: function(){
		{{$formSubscriber}}.form.slideUp();
		{{$formInvoice}}.form.slideDown();
	}
};

$("#subscriber{{$formSubscriber}}").on('input keyup', {{$formSubscriber}}.onModalSearch);
{{$formSubscriber}}.form.find("input.{{$formSubscriber}}[name='ktp[nik]']").inputFilterNumber();
{{$formSubscriber}}.form.find("input.{{$formSubscriber}}[name='ktp[tlp]']").inputFilterPhone();
{{$formSubscriber}}.form.find("input.{{$formSubscriber}}[name='ktp[img]']").on('change', function(){
	$(this).next().html( this.files[0].name );
});
{{$formSubscriber}}.form.requireValidation({afterValidation: {{$formSubscriber}}.onModalSubmit});
</script>
<script>
const {{$formInvoice}} = {
	form: $( "#{{$formInvoice}}" ),
	views: [".invoice", ".start-datepicker", ".end-datepicker"],
	onModalHide: function(){
		this.form.find("input.{{$formInvoice}}").each((index, item)=>{
			$(item).val("");
		});
		this.showInvoice();
		this.back();
	},
	onModalSubmit: function(e, isValid){
		if (!isValid){
			return false;
		}
		
		$.each(["nik","name", "email", "tlp", "img"], function(index, item){
			{{$formSubscriber}}.form.find("input[name='ktp["+ item +"]']")
				.css('display', 'none')
				.appendTo({{$formInvoice}}.form);
		});
		
		return true;
	},
	back: function(){
		{{$formSubscriber}}.form.slideDown();
		{{$formInvoice}}.form.slideUp();
		return this;
	},
	resetValidation: function(){
		this.form.resetValidation();
		return this;
	},
	show: function(idx){
		if (idx >=0 && idx <= this.views.length){
			$(this.views[idx]).show();
		}
		return this;
	},
	hide: function(idx){
		if (idx >=0 && idx <= this.views.length){
			$(this.views[idx]).hide();
		}
		return this;
	},
	showInvoice:function(){
		this.show(0).hide(1).hide(2);
		return this;
	},
	showStartDate: function(){
		this.hide(0).show(1).hide(2);
		return this;
	},
	showEndDate: function(){
		this.hide(0).hide(1).show(2);
		return this;
	}
};

$("input.{{$formInvoice}}[name='date[start]']").on("focusin", function(){
	{{$formInvoice}}.showStartDate();
});
$("input.{{$formInvoice}}[name='date[end]']").on("focusin", function(){
{{$formInvoice}}.showEndDate();
});
$("input.{{$formInvoice}}[name='date[grace]']").inputFilterNumber();

const endDatepicker{{$formInvoice}} = $('#{{$formInvoice}}-end-datepicker');
endDatepicker{{$formInvoice}}.datepicker({ format:'dd-mm-yyyy', language:'id' });
endDatepicker{{$formInvoice}}.on('changeDate', function() {
    $("input.{{$formInvoice}}[name='date[end]']").val( 
		endDatepicker{{$formInvoice}}.datepicker('getFormattedDate') 
	);
	{{$formInvoice}}.showInvoice();
});

const startDatePicker{{$formInvoice}} = $('#{{$formInvoice}}-start-datepicker');
startDatePicker{{$formInvoice}}.datepicker({ 
	format:'dd-mm-yyyy', 
	language:'id', 
	startDate:'{{now()->format("d-m-Y")}}'
});
startDatePicker{{$formInvoice}}.on('changeDate', function() {
	let start = startDatePicker{{$formInvoice}}.datepicker('getFormattedDate');
	$("input.{{$formInvoice}}[name='date[start]']").val( 
		startDatePicker{{$formInvoice}}.datepicker('getFormattedDate') 
	);
	endDatepicker{{$formInvoice}}.datepicker('setStartDate', start);
	$("input.{{$formInvoice}}[name='date[end]']").val("");
	{{$formInvoice}}.showInvoice();
});

{{$formInvoice}}.form.find("input.{{$formInvoice}}[name='rate']").inputFilterCurrency();
{{$formInvoice}}.form.find("input.{{$formInvoice}}[name='tax']").inputFilterCurrency();
{{$formInvoice}}.form.requireValidation({afterValidation: {{$formInvoice}}.onModalSubmit});
{{$formInvoice}}.form.hide();
{{$formInvoice}}.showInvoice();
</script>
<script>
$("#{{$modalID}}").on('show.bs.modal', {{$formSubscriber}}.onModalShow.bind({{$formSubscriber}}));
$("#{{$modalID}}").on('hide.bs.modal', {{$formSubscriber}}.onModalHide.bind({{$formSubscriber}}));
$("#{{$modalID}}").on('hide.bs.modal', {{$formInvoice}}.onModalHide.bind({{$formInvoice}}));
</script>
@endpush