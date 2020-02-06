<?php 
/*
 |	DOMAIN: owned.kosan.co.id/
 */
 
Route::get('', function(){
	return redirect(route("web.owner.dashboard"), 301);
});