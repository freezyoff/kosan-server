<?php 

Route::get("/", function(){
	return \App\Kosan\Service\RegisterService::store([
		'name'=>'musa',
		'email'=>'freezyoff@gmail.com',
		'password'=>'1234567890'
	]);
});