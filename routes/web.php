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
	
Route::domain("service.$domain")
	->group( base_path("routes/web/service.php") );
	
Route::domain("my.$domain")
	->middleware("auth")
	->group( base_path("routes/web/my.php") );

Route::domain("owner.$domain")
	->middleware("auth")
	->group( base_path("routes/web/owner.php") );
	
Route::prefix("test")
	->group(function(){
		Route::get("layout/dashboard", function(){
			return view("layout-dashboard");
		});
	});