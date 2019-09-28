<?php
/*
 |	DOMAIN: service.kosan.co.id/api
 */
 
Route::post("test", function(){
	return response()->json(request()->all(), 200);
});

Route::prefix("user")->group(function(){
		
	Route::post("reset/password", "\App\Http\Controllers\Services\API\ResetPassword@reset");
	Route::post("login", "\App\Http\Controllers\Services\API\AuthController@userLogin");
	
	Route::middleware("kosan>>user.auth.api")->group(function(){
			
		Route::post("user/logout", "\App\Http\Controllers\Services\API\AuthController@userLogout");
			
	});
			
});


