<!-- Begin: xs - sm -->
<form action="{{route('web.service.login')}}" method="post">
	@csrf
	<div class="pl-4 pr-4 mt-5 d-block d-sm-none">
		<div class="brand text-center mx-auto">Kosan</div>
		<div class="brand-tag text-center mx-auto mb-4" style="margin-top:-.5rem">Manage with ease</div>
		
		@if ($errors->any())
		<div class="alert alert-danger pt-2 pb-2" role="alert">
			<div class="d-flex">
				<div><i class="fas fa-exclamation-triangle"></i></div>
				<span class="ml-2">Kombinasi Email dan Sandi tidak dikenali</span>
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
				</div>
			</div>
			
			<div class="row mt-3">
				<button type="submit" class="btn btn-primary btn-block">Masuk</button>
			</div>
		</div>
	</div>
</form>
<!-- End: xs - sm -->