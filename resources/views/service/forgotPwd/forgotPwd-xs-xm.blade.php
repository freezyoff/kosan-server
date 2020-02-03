
<p class="pt-4">Link atur ulang sandi akan dikirim ke Email akun yang terdaftar. Masukkan alamat Email dan klik tombol kirim.</p>

@isset($success)
<div class="alert alert-success" role="alert">
<h5 class="alert-heading font-weight-bold">Email Terkirim</h5>
<p class="mb-0">Petunjuk atur ulang sandi telah dikirim. Periksa inbox email.</p>
</div>
@endisset

<form action="{{route('web.service.auth.forgot')}}" method="post" class="mb-0">
	@csrf
	<div class="container">
		<div class="row">
			<div class="input-group @error('email') invalid @enderror ">
				<div class="input-group-prepend">
					
					<span id="Email"
						class="input-group-text">
						<i class="fas fa-envelope"></i>
					</span>
					
				</div>
				<input 
					name="email" 
					class="form-control" 
					type="text" 
					placeholder="Email" 
					aria-label="Email"
					
					@if (isset($email))
						value="{{$email}}"
					@else
						value="{{old('email')}}"
					@endif
					
					/>
			</div>
			
			@error('email')
				<small class="w-100 text-danger text-right">{{$errors->get("email")[0]}}</small>
			@enderror
			
		</div>
		<div class="row mt-3">
			<button type="submit" class="btn btn-info btn-block">Kirim link</button>
		</div>
	</div>
</form>