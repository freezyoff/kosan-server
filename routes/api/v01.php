<?php 

Route::get("/version", function() use ($apiVersion){
	return $apiVersion;
});

Route::middleware("kosan.device.only")
	->prefix("device")
	->group(function() use($apiVersion) {
		
		Route::post("register", "\App\Http\Controllers\\$apiVersion\DeviceCtrl@register");
		Route::post("auth", "\App\Http\Controllers\\$apiVersion\DeviceCtrl@auth");
		
		Route::middleware("kosan.device.auth")
			->group(function() use($apiVersion){
				
			Route::post("publish", "\App\Http\Controllers\\$apiVersion\DeviceCtrl@publish");
			//Route::post("update", "\App\Http\Controllers\$apiVersion\DeviceCtrl@update");
				
			});
		
	});
	
Route::middleware("auth:api")
	->prefix("user")
	->group(function() use($apiVersion) {
		
		//Route::get("auth/login", "");
		//Route::get("auth/logout", "");
		
		//Route::prefix("dashboard")
			//->group(function() use ($apiVersion){
			
			//Route::get("monitor");
			
		//});
		
	});