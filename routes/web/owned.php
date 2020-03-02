<?php 
/*
 |	DOMAIN: owned.kosan.co.id/
 */
 
Route::get('', function(){
	return redirect(route("web.owned.dashboard"), 301);
});

Route::prefix("dashboard")
	->namespace("\App\Http\Controllers\Owned")
	->group(function(){
		
		Route::get("", "DashboardController@landing")->name("web.owned.dashboard");
		
	});