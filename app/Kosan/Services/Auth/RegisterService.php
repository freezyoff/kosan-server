<?php 
namespace App\Kosan\Services\Auth;

use Illuminate\Support\Facades\Validator;
use Str;

use App\Kosan\Service\EmailValidationService;
use App\Kosan\Models\User;
use App\Notifications\RegisterEmailNotification;

class RegisterService{
	
	public static function register(array $cred, $viaOauth=false){
		$user = new User;
		$user->fill($cred);
		
		if ($viaOauth){
			$user->email_verified_at = now();
		}
		
		$user->save();
		
		//send email notification
		$user->notify(
			new RegisterEmailNotification([
				'name'=> $user->name,
				'email'=> $user->email,
				'password'=> $cred['password'],
				
				//we hide activation link in notification if register with oauth
				'activationToken' => $viaOauth? false : md5($user->email)
			])
		);
		
		//@TODO: need a way to implement MQTT Client username & password
		//add mosquitto user and password to passwd file
		//so the user can use mqtt
		/*
		exec(
			Str::replaceArray(
				'?', 
				[config("kosan.mqtt_password_file"), $user->email, $cred['password']], 
				config("kosan.linux_shell.add_moquitto_user")
			) 
			. " && " .
			Str::replaceArray(
				'?', 
				[env('DB_PASSWORD', "")], 
				config("kosan.linux_shell.restart_moquitto")
			)
			. " && " .
			Str::replaceArray(
				'?', 
				[env('DB_PASSWORD', "")], 
				config("kosan.linux_shell.restart_kosan_server")
			)
		);
		*/
		
		$user->renewApiToken();
		
		return [
			'api_token'=> 			$user->api_token,
			'api_token_expired'=>	$user->api_token_expired,
		];
		
	}
	
	public static function activate($token){
		$user = User::findByActivationToken($token);
		if (!$user || $user->isEmailVerified()){
			return false;
		}
		
		//activate
		$user->verifyEmail();
		return true;
	}
}