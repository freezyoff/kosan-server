@php
$js_upload = "file_".uniqid();
@endphp

<!-- Begin: xs - sm -->
<form action="{{route("web.service.auth.register")}}" 
	method="POST" 
	accept-charset="UTF-8" 
	enctype="multipart/form-data">

@csrf

<input name="picture_profile" 
	@if (isset($picture))
		value="{{$picture}}"
	@else
		value="old('picture_profile')"
	@endif
	type="hidden" />
	
<div class="d-sm-none">
	
	@if(isset($picture))
		<img class="rounded-circle rounded mx-auto d-block mb-4 mt-3" width="100" src="{{$picture}}" />
	@else 
		<div class="mt-1">&nbsp;</div>
	@endif
	
	<div class="container pb-4">
		<div class="row"><h5>Akun</h5></div>
		<div class="row">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-envelope"></i>
					</span>
				</div>
				<input 
					id="inp-email"
					name="email" 
					type="text" 
					placeholder="Alamat Email" 
					autocomplete="off" 
					
					@if (isset($email))
						value="{{$email}}"
					@else
						value="{{old('email')}}"
					@endif
					
					@if($errors->has('email')) 
						class="form-control border-danger" 
					@else
						class="form-control" 
					@endif
					
					/>
					
				@if ($errors->has('email'))
					<small class="w-100 text-danger text-right">{{$errors->get("email")[0]}}</small>
				@endif
				
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-lock"></i>
					</span>
				</div>
				<input 
					id="inp-password"
					name="password" 
					type="password" 
					placeholder="Sandi" 
					autocomplete="off" 
					
					@if($errors->has('password')) 
						class="form-control border-danger" 
					@else 
						class="form-control" 
					@endif
					
					/>
					
				@if ($errors->has('password'))
					<small class="w-100 text-danger text-right">{{$errors->get("password")[0]}}</small>
				@endif
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-lock"></i>
					</span>
				</div>
				<input 
					id="inp-password-confirm"
					name="password_confirm" 
					type="password" 
					placeholder="Konfirmasi Sandi" 
					autocomplete="off" 
					
					@if($errors->has('password_confirm')) 
						class="form-control border-danger" 
					@else 
						class="form-control" 
					@endif
					
					/>
					
				@if ($errors->has('password_confirm'))
					<small class="w-100 text-danger text-right">{{$errors->get("password_confirm")[0]}}</small>
				@endif
			</div>
		</div>
		<div class="row mt-5"><h5>Info</h5></div>
		<div class="row">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inp-name" >
						<i class="fas fa-font"></i>
					</span>
				</div>
				<input name="name" 
					type="text" 
					placeholder="Nama"
					autocomplete="off" 
					
					@if (isset($name))
						value="{{$name}}"
					@else
						value="{{old('name')}}"
					@endif
				
					@if($errors->has('name')) 
						class="form-control border-danger"
					@else 
						class="form-control"
					@endif
					
					/>
					
				@if ($errors->has('name'))
					<small class="w-100 text-danger text-right">{{$errors->get("name")[0]}}</small>
				@endif
				
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-venus-mars"></i>
					</span>
				</div>
				
				@include("service.register.register-xs-sm_gender-modal") 
				
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" >
						<i class="fas fa-map-marker-alt"></i>
					</span>
				</div>
				
				@include("service.register.register-xs-sm_address-modal")
				
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text font-weight-bold">+62</span>
				</div>
				<input id="inp-phone-code" name="phone_region" type="hidden" value="+62" />
				<input 
					id="inp-phone-number"
					name="phone_number" 
					type="text" 
					placeholder="Nomor Handphone" 
					autocomplete="off" 
					
					@if (isset($phone_number))
						value="{{$phone_number}}"
					@else
						value="{{old('phone_number')}}"
					@endif
					
					@if($errors->has('phone_number')) 
						class="form-control border-danger"
					@else 
						class="form-control"
					@endif
				
					/>
					
				@if($errors->has('phone_number')) 
					<small class="w-100 text-danger text-right">{{$errors->get("phone_number")[0]}}</small>
				@endif
				
			</div>
		</div>
		<div class="row mt-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text font-weight-bold">
						<i class="fas fa-id-card"></i>
					</span>
				</div>
				<input id="inp-idcard" name="picture_idcard" type="file" class="d-none" accept="image/*"/>
				<input id="inp-idcard-label"
					type="text" 
					placeholder="Foto KTP" 
					autocomplete="off"
					readonly="readonly"
					
					@if($errors->has('picture_idcard')) 
						class="form-control cursor-pointer file-upload bg-transparent border-danger" 
					@else 
						class="form-control cursor-pointer file-upload bg-transparent" 
					@endif
					
					 />
					 
				<div class="input-group-append cursor-pointer file-upload">
					<span class="input-group-text font-weight-bold">
						<i class="fas fa-file-upload"></i>
					</span>
				</div>
				
				@if($errors->has('picture_idcard')) 
					<small class="w-100 text-danger text-right">{{$errors->get("picture_idcard")[0]}}</small>
				@else
					<small class="w-100 text-right mr-2 mt-1">Max. 1Mb</small>
				@endif
			</div>
		</div>
		
		<div class="row mt-3">
			<button type="submit" class="btn btn-primary btn-block">
				<i class="fas fa-share"></i>
				Daftar
			</button>
		</div>
	</div>
</div>
</form>
<!-- End: xs - sm -->

@push('script.ready')
	$(".input-group-text").css({"min-width":"50px","justify-content":"center"});
	
	$("#inp-phone-number").inputFilterPhoneFormat();

	$(".file-upload").click(function(){
		$("#inp-idcard").trigger("click");
	}).focus(function(){
		$(this).trigger("click");
	});
	
	$("#inp-idcard").change(function(e){
		$("#inp-idcard-label").val( e.target.files[0].name );
	});
@endpush