<?php
/*
 |	DOMAIN: service.kosan.co.id/api
 */

Route::prefix("android")
	->namespace("\App\Http\Controllers\Services\API")
	->group(function(){
		
		Route::post("change/pwd", "Android@changePassword")
			->name('web.service.android.change-pwd');
		
	});

Route::prefix("user")
	->middleware("kosan>>api.only")
	->group(function(){
		
	Route::post("reset/password", "\App\Http\Controllers\Services\API\ResetPassword@reset");
	Route::post("login", "\App\Http\Controllers\Services\API\AuthController@userLogin");
	
	Route::middleware("kosan>>user.auth.api")->group(function(){

		Route::post("logout", "\App\Http\Controllers\Services\API\AuthController@userLogout");
		
	});
	
	Route::prefix("resource")
		->middleware("kosan>>user.auth.api")
		->group(function(){
			
			Route::get("owned/locations", "\App\Http\Controllers\Services\API\UserResource@ownedLocations");
			Route::get("accessibilities", "\App\Http\Controllers\Services\API\UserResource@accessiblities");
			
		});

});
