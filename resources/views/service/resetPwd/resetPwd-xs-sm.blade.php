
<p class="pt-4">Ganti Sandi Lama dengan Sandi Baru.</p>


<form action="{{route('web.service.auth.reset',[$token])}}" method="POST" class="mb-0">
	@csrf
	
	<input name="token" value="{{old('token', $token)}}" type="hidden" />
	
	<div class="container">
		<div class="row">
			<div class="input-group @error('password') invalid @enderror ">
				<div class="input-group-prepend">
					
					<span id="password"
						class="input-group-text">
						<i class="fas fa-lock"></i>
					</span>
					
				</div>
				
				<input name="password" 
					placeholder="Sandi Baru" 
					class="form-control" 
					type="password"
					aria-label="password" />
					
				<div class="input-group-append cursor-pointer" 
					onclick="input.password.toggleView($(this).find('i'), $(this).prev())">
					<span class="input-group-text bg-white cursor-pointer"><i class="fas fa-eye"></i></span>
				</div>
			</div>
			
			@error('password')
				<small class="w-100 text-danger text-right">{{$errors->get("password")[0]}}</small>
			@enderror
			
		</div>
		
		<div class="row mt-3">
			<div class="input-group @error('confirm') invalid @enderror ">
				<div class="input-group-prepend">
					
					<span id="confirm"
						class="input-group-text">
						<i class="fas fa-lock"></i>
					</span>
					
				</div>
				<input name="confirm" 
					placeholder="Konfirmasi Sandi Baru" 
					class="form-control" 
					aria-label="confirm"
					type="password" />
				<div class="input-group-append cursor-pointer" 
					onclick="input.password.toggleView($(this).find('i'), $(this).prev())">
					<span class="input-group-text bg-white cursor-pointer"><i class="fas fa-eye"></i></span>
				</div>
			</div>
			
			@error('confirm')
				<small class="w-100 text-danger text-right">{{$errors->get("confirm")[0]}}</small>
			@enderror
			
		</div>
		
		<div class="row mt-3">
			<button type="submit" class="btn btn-info btn-block">Simpan Sandi Baru</button>
		</div>
	</div>
	
</form>