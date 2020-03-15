<?php 
/*
 |	DOMAIN: owner.kosan.co.id/
 */
 
Route::get('', function(){
	return redirect(route("web.owner.dashboard"), 301);
});

Route::prefix("dashboard")
	->namespace("\App\Http\Controllers\Owner\Web")
	->group(function(){
		
		Route::get("", "DashboardController@landing")->name("web.owner.dashboard");
		
	});

Route::prefix("rooms")
	->namespace("\App\Http\Controllers\Owner\Web")
	->group(function(){
		
		Route::get("", "RoomsController@landing")->name("web.owner.room");
		
	});	
	
Route::namespace("\App\Http\Controllers\Owner\Web")
	->group(function(){
		
		Route::get("devices", "DevicesController@landing")->name("web.owner.devices");
		Route::get("devices/listener", "DevicesController@landingListener")->name("web.owner.devices.listener");
		
		Route::get("device/mac/{macHash}", "DevicesController@device")->name("web.owner.device");
		
	});	