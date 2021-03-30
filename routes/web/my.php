<?php 
/*
 |	DOMAIN: my.kosan.co.id/
 */

Route::get('', function(){
	//return redirect(route("web.my.dashboard"), 301);
	return view('my.dashboard');
});

Route::prefix("dashboard")
	->namespace('My\Web')
	->group(function(){
	
	Route::get('', "DashboardController@landing")->name("web.my.dashboard");
	
	
	/* DEPRECATED */
	/*
	Route::prefix('accessibilities')
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
	*/
	
});

Route::prefix("owned")
	->namespace('My\Web')
	->group(function(){
		
		/*
		Route::get("", "OwnedController@landing")
			->name("web.my.owned");
		Route::prefix("location")
			->group(function(){
				Route::get("make", "Owned\LocationController@makeForm")->name("web.my.owned.make");
				Route::post("make", "Owned\LocationController@make");
			});
		
		*/
	});
	
Route::prefix("resource")
	->group(function(){
		
		Route::prefix("region")
			->namespace("\App\Http\Controllers\Services\Web")
			->group(function(){
				
				Route::get("provinces", "ResourceRegionController@provinces")
					->name("web.my.resource.region.provinces");
					
				Route::get("regencies/{province}", "ResourceRegionController@regencies")
					->name("web.my.resource.region.regencies");
					
				Route::get("districts/{regency}", "ResourceRegionController@districts")
					->name("web.my.resource.region.districts");
				
				Route::get("villages/{district}", "ResourceRegionController@villages")
					->name("web.my.resource.region.villages");
				
			});
		
	});
