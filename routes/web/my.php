<?php 
/*
 |	DOMAIN: my.kosan.co.id/
 */

Route::get('', function(){
	return "my.kosan.co.id";
	return redirect(route("web.my.dashboard"), 301);
});

Route::prefix("dashboard")
	->group(function(){
	
	Route::get('', function(){ 
		return redirect()->route("web.my.dashboard.accessibilities"); 
	})->name("web.my.dashboard");
	
	Route::namespace('My\Web')
		->prefix('accessibilities')
		->group(function(){
			
		Route::get('', "DashboardController@accessibilitiesPage")
			->name("web.my.dashboard.accessibilities");
		Route::get('location/{locationID?}', "DashboardController@accessibilitiesByLocation")
			->name("web.my.dashboard.accessibilities.location");
			
	});
	
	Route::namespace('My\Web')
		->prefix("setting")
		->group(function(){
			
		Route::get('', "DashboardController@settingPage");
		
	});
	
	Route::namespace('My\Web\Dashboard')
		->prefix("device-manager")
		->group(function(){
			
		Route::get('', "DeviceManagerController@deviceManagerPage")
			->name("web.my.dashboard.device-manager");
		Route::get('location/{locationID?}', "DeviceManagerController@deviceManagerByLocation")
			->name("web.my.dashboard.device-manager.location");
		
		Route::post("invite/pic", "DeviceManagerController@invitePIC")
			->name("web.my.dashboard.device-manager.invite.pic");
	});
	
});