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
		
		Route::get("devices", "DevicesController@landing")
			->name("web.owner.devices");
			
		Route::get("device/statistics/{macHash}", "DevicesController@device")
			->name("web.owner.device");
		Route::post("device/statistics/{macHash}", "DevicesController@devicePost")
			->name("web.owner.device");
		
		Route::get("devices/listener/{targetDeviceMacHash?}", "DevicesController@getDeviceListener")
			->name("web.owner.devices.listener");
	});	