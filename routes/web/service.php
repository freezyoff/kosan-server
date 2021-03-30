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
		
		Route::prefix("logout")
			->group(function(){
				Route::any("", "AuthController@logout")->name("web.service.auth.logout");
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

//TODO: remove this when APK Released on google play store
Route::get("apk/download", function(){
	return response()->file(app_path("../storage/app/apk/app-debug.apk") ,[
		'Content-Type'=>'application/vnd.android.package-archive',
		'Content-Disposition'=> 'attachment; filename="android.apk"',
	]);
});

//TODO: remove this when subdomain my.kosan.co.id has SSL Installed
Route::prefix('access')
	->middleware("auth")
	->namespace("\App\Http\Controllers\My\Web")
	->group(function(){
		
		Route::get("", "DashboardController@landing")->name("web.my.dashboard");
		Route::get("listener/{roomid}", "DashboardController@getMqttListener")->name("web.my.dashboard.listener");
		
	});
	