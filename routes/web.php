<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$domain = config("app.url");

Route::domain($domain)
	->group(function(){
		
		Route::get('/', function () {
			return view('welcome');
		});
		
	});
	
Route::domain("services.$domain")
	->group( base_path("routes/web/services.php") );
	
Route::domain("my.$domain")
	->middleware("auth")
	->group( base_path("routes/web/my.php") );
