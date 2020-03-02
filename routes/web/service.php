<?php 
/*
 |	DOMAIN: service.kosan.co.id/
 */

Route::get("/", function(){
	return redirect()->route('web.service.auth.login');
});

Route::prefix('auth')
	->namespace("\App\Http\Controllers\Services\Web")
	->group(function(){
		
		Route::prefix("register")
			->group(function(){
				
				Route::get("", "AuthController@registerForm")->name("web.service.auth.register");
				Route::post("", "AuthController@register");
				
				Route::post("checkSize", "AuthController@checkIdFileSize")
					->name("web.service.auth.register.checkFileSize");
					
			});
		
		Route::get("activate/{token}", "AuthController@activation")
			->name("web.service.auth.activation");
			
		Route::prefix("login")
			->group(function(){
				
				Route::get("", "AuthController@loginForm")->name("web.service.auth.login");
				Route::post("", "AuthController@login");
				
			});
		
		Route::prefix("forgot")
			->group(function(){
				
				Route::get("", "AuthController@forgotPwdForm")->name("web.service.auth.forgot");
				Route::post("", "AuthController@forgotPwd");
				
			});
		
		Route::prefix("reset")
			->group(function(){
				
				Route::get("{token}", "AuthController@resetPwdForm")->name("web.service.auth.reset");
				Route::post("{token}", "AuthController@resetPwd");
				
			});
			
	});
	
Route::prefix("oauth")
	->namespace("\App\Http\Controllers\Services\Web")
	->group(function(){
		
		Route::name("web.service.oauth.verify.google")
			->get("google/verify/{googleToken}", "AuthController@verifyGoogleAccount");
		
		Route::name("web.service.oauth.verify.facebook")
			->get("facebook/verify/{facebookToken}", "AuthController@verifyFacebookAccount");
			
		Route::name("web.service.oauth.register")
			->get("register/{redirectToken}", "AuthController@registerWithRedirectToken");
			
	});

Route::prefix("redirect")
	->middleware("auth")
	->namespace("\App\Http\Controllers\Services\Web")
	->group(function(){
		Route::get("", "RedirectorController@redirect")
			->name('web.service.redirector');
	});

Route::prefix("resource")
	->group(function(){
		
		Route::prefix("region")
			->namespace("\App\Http\Controllers\Services\Web")
			->group(function(){
				
				Route::get("provinces", "ResourceRegionController@provinces")
					->name("web.service.resource.region.provinces");
					
				Route::get("regencies/{province}", "ResourceRegionController@regencies")
					->name("web.service.resource.region.regencies");
					
				Route::get("districts/{regency}", "ResourceRegionController@districts")
					->name("web.service.resource.region.districts");
				
				Route::get("villages/{district}", "ResourceRegionController@villages")
					->name("web.service.resource.region.villages");
				
			});
		
	});
	
Route::get("markdown/test", function(){
	$message = (new \App\Notifications\RegisterEmailNotification([
		"name"=>'123',
		"email"=>'asdasdsadasdsad',
		'password'=>'1231232132',
		'activationToken'=>'asdsadsadsa'
	]))->toMail('test@email.com');
	return $message;
});