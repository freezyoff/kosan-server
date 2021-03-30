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
		
		Route::get('privacy-policy', function(){
			return view('legals.privacy_policy_id');
		});
		
	});
	
Route::domain("service.$domain")
	->group( base_path("routes/web/service.php") );

//TODO:uncomment when subdomain my.kosan.co.id has ssl installed
/*
Route::domain("my.$domain")
	->middleware("auth")
	->group( base_path("routes/web/my.php") );
*/

Route::domain("owner.$domain")
	->middleware("auth")
	->group( base_path("routes/web/owner.php") );
	
Route::prefix("test")
	->group(function(){
		Route::get("layout/dashboard", function(){
			return view("layout-dashboard");
		});
		
		Route::get("apk/download", function(){
			return response()->file(
				storage_path('app/apk/app-debug.apk'),
				[
					'Content-Type'=>'application/vnd.android.package-archive',
					'Content-Disposition'=> 'attachment; filename="android.apk"',
				]
			);
		});
	});