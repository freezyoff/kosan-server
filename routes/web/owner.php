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
		Route::post("change", "RoomsController@change")->name("web.owner.room.change");
		Route::post("create", "RoomsController@create")->name("web.owner.room.create");
		
	});	

Route::namespace("\App\Http\Controllers\Owner\Web")
	->prefix("profile")
	->group(function(){		
		Route::get("", "ProfileController@landing")->name('web.owner.profile');
		Route::post("change-pwd", "ProfileController@changePwd")->name('web.owner.change-pwd');
	});
	
Route::namespace("\App\Http\Controllers\Owner\Web")
	->group(function(){
		
		Route::get("devices/listener/{targetDeviceMacHash?}", "DevicesController@getDeviceListener")
			->name("web.owner.devices.listener");
			
		Route::get("devices", "DevicesController@landing")
			->name("web.owner.devices");
			
		Route::get("device/info/{macHash}", "DevicesController@device")
			->name("web.owner.device");
		Route::post("device/info/{macHash}", "DevicesController@devicePost")
			->name("web.owner.device");
		
		Route::prefix("access-control")
			->group(function(){
				
				Route::get("{macHash}", "DevicesController@accessControl")
					->name("web.owner.access-control");
				
				Route::post("change/name", "DevicesController@accessControlChangeName")
					->name("web.owner.access-control.change.name");
				
				Route::post("change/room", "DevicesController@accessControlChangeRoom")
					->name("web.owner.access-control.change.room");
					
				Route::post("create/room", "DevicesController@accessControlCreateRoom")
					->name("web.owner.access-control.create.room");
			});
			
	});	