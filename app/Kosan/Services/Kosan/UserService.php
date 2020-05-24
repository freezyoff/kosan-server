<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;

class UserService {
	
	public static function make($name, $email, $password){
		//register new user
		$user = new User;
		$user->name = $name;
		$user->email = $email;
		$user->password = $password;
		$user->save();
		
		//notify registered
		$user->notify(
			new RegisterEmailNotification([
				'name'=> $user->name,
				'email'=> $user->email,
				'password'=> $password,
				
				//we hide activation link in notification if register with oauth
				'activationToken' => $viaOauth? false : md5($user->email)
			])
		);
		
		//add mosquitto user and password to passwd file
		//so the user can use mqtt
		Artisan::call('mosquitto:adduser', [
			'user' 	  => md5(strtolower($user->email)),
			'pwd' 	  => md5($user->created_at)
		]);
		
		//reload mosquitto server to take immidiate effect of password file change
		Artisan::call('mosquitto:reload', []);
		
		return $user;
	}
	
}