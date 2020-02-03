<!-- Begin: xs - sm -->
<div class="pl-4 pr-4 mt-5 d-block d-sm-none">
	<div class="brand text-center mx-auto">Kosan</div>
	<div class="brand-tag text-center mx-auto mb-4" style="margin-top:-.5rem">Manage with ease</div>
	
	<form action="{{route('web.service.auth.login')}}" method="post" class="mb-0">
		@csrf
		
		@if ($errors->any())
		<div class="alert alert-danger mt-3 pt-2 pb-2" role="alert">
			<div class="d-flex align-items-center">
				<div><i class="fas fa-exclamation-triangle"></i></div>
				<span class="ml-2">Kombinasi Email dan Sandi tidak terdaftar.</span>
			</div>
		</div>
		@endif

		<div class="container">
			<div class="row">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="Email">
							<i class="fas fa-envelope"></i>
						</span>
					</div>
					<input 
						name="email" 
						type="text" 
						class="form-control" 
						placeholder="Email" 
						aria-label="Email">
				</div>
			</div>
			
			<div class="row mt-3">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="Password">
							<i class="fas fa-lock"></i>
						</span>
					</div>
					<input 
						name="password" 
						type="password" 
						class="form-control" 
						placeholder="Sandi" 
						aria-label="Password">
					<div class="input-group-append" 
						style="cursor:pointer" 
						onclick="input.password.toggleView($(this).find('i'), $(this).prev())">
						<span class="input-group-text bg-white cursor-pointer">
							<i class="fas fa-eye"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<a href="{{route('web.service.auth.forgot')}}" class="text-warning mt-2">Lupa password?</a>
			</div>
			<div class="row mt-3">
				<button type="submit" class="btn btn-primary btn-block">Masuk</button>
			</div>
		</div>
	</form>
	
	<button id="oauth-google-xs-sm" 
		type="button" 
		class="btn btn-light btn-block d-flex align-items-center mt-3">
		<div><i class="fab fa-google fa-lg"></i></div>
		<div style="flex-grow:1">Masuk dengan Akun Google</div>
	</button>
	
	<button type="button" 
		class="btn btn-block btn-oauth-facebook d-flex align-items-center mt-3" 
		style="background-color:#4267b2;display:flex">
		<span><i class="fab fa-facebook-f fa-lg"></i></span>
		<span style="flex-grow:1">Masuk dengan Akun Facebook</span>
	</button>
	
	<div class="l-space mt-4">
		<div class="line">&nbsp;</div>
		<div class="label">Belum punya Akun</div>
	</div>
	
	<button id="oauth-google-xs-sm" 
		type="button" 
		class="btn btn-success btn-block d-flex align-items-center"
		onclick="window.location='{{route('web.service.auth.register')}}'">
		<div style="flex-grow:1">Daftar</div>
	</button>
</div>
<!-- End: xs - sm -->