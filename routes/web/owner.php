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

Route::namespace("\App\Http\Controllers\Owner\Web")->group(function(){
		
		
	//prefix: rooms 
	Route::prefix("rooms")->group(function(){
		Route::get("", "RoomsController@landing")->name("web.owner.rooms");
		Route::post("change", "RoomsController@change")->name("web.owner.rooms.change");
		Route::post("create", "RoomsController@create")->name("web.owner.rooms.create");
		Route::post("lease", "RoomsController@lease")->name("web.owner.rooms.lease");
		
		Route::prefix("access")->group(function(){
			Route::get("", "RoomsAccessController@landing")->name("web.owner.rooms.access");
			Route::get("histories/{roomHash}", "RoomsController@accessList")->name("web.owner.rooms.access.histories");
		});
	});
	
	//prefix: profile 
	Route::prefix("profile")->group(function(){
		Route::get("", "ProfileController@landing")->name('web.owner.profile');
		
		//change password
		Route::post("change-pwd", "ProfileController@changePwd")->name('web.owner.change-pwd');
		
		//change location name
		Route::post("change/location/name", "ProfileController@changeLocationName")
			->name('web.owner.profile.change.location.name');
		
		//add & change bank account
		Route::post("bank/add", "ProfileController@addBankAccount")
			->name('web.owner.profile.bank.add');
		Route::post("bank/change", "ProfileController@editBankAccount")
			->name('web.owner.profile.bank.edit');
		Route::post("bank/delete", "ProfileController@deleteBankAccount")
			->name('web.owner.profile.bank.delete');
	});
	
	Route::prefix("access-control")->group(function(){
		Route::get("device/{macHash}", "DevicesController@accessControl")->name("web.owner.access-control");
		Route::prefix("change")->group(function(){
			Route::post("name", "DevicesController@accessControlChangeName")->name("web.owner.access-control.change.name");
			Route::post("room", "DevicesController@accessControlChangeRoom")->name("web.owner.access-control.change.room");
			Route::post("disconnect", "DevicesController@accessControlDisconnectRoom")->name("web.owner.access-control.change.disconnect");
		});
		Route::prefix("create")->group(function(){
			Route::post("room", "DevicesController@accessControlCreateRoom")->name("web.owner.access-control.create.room");
		});
	});
	
	Route::prefix("devices")->group(function(){
		Route::get("", "DevicesController@landing")
			->name("web.owner.devices");
		Route::get("listener/{targetDeviceMacHash?}", "DevicesController@getDeviceListener")
			->name("web.owner.devices.listener");
	});
	
	Route::prefix("device")->group(function(){
		Route::get("info/{macHash}", "DevicesController@device")->name("web.owner.device");
		Route::post("info/{macHash}", "DevicesController@devicePost")->name("web.owner.device");
	});	
	
	Route::prefix("lease")->group(function(){
		Route::get("", "InvoicesController@landing")->name("web.owner.lease");
	});
});