<?php 

$apiVersion = config("kosan.api_version");

Route::get("/version", function(){
	return "v01";
});

Route::middleware("auth:device")
	->prefix("device")
	->group(function() use($apiVersion) {
		
		//Route::post("register", "\App\Http\Controllers\$apiVersion\DeviceCtrl@register");
		//Route::post("auth", "\App\Http\Controllers\$apiVersion\DeviceCtrl@auth");
		//Route::post("publish", "\App\Http\Controllers\$apiVersion\DeviceCtrl@publish");
		//Route::post("update", "\App\Http\Controllers\$apiVersion\DeviceCtrl@update");
		
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