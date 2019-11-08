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

		Route::post("logout", "\App\Http\Controllers\Services\API\AuthController@userLogout");
		
	});
	
	Route::prefix("resource")
		->middleware("kosan>>user.auth.api")
		->group(function(){
			
			Route::get("owned/locations", "\App\Http\Controllers\Services\API\UserResource@ownedLocations");
			Route::get("accessibilities", "\App\Http\Controllers\Services\API\UserResource@accessiblities");
			
		});

});