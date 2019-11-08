<?php 
/*
 |	DOMAIN: service.kosan.co.id/
 */

Route::get("/", "\App\Http\Controllers\Services\Web\AuthController@loginForm")
	->name("web.service.login");
Route::post("/", "\App\Http\Controllers\Services\Web\AuthController@login");	


Route::get("/redirect", function(){
	return view('services.redirector');
})->name('web.service.redirector');