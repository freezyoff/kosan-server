<?php 
namespace App\Kosan\Services\Auth;

use Illuminate\Support\Facades\Validator;
use Str;
use Artisan;

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
		$user->renewApiToken();
		
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
		
		//add mosquitto user and password to passwd file
		//so the user can use mqtt
		Artisan::call('mosquitto:adduser', [
			'user' 	  => md5($user->email),
			'pwd' 	  => $user->api_token
		]);
		
		//reload mosquitto server to take immidiate effect of password file change
		Artisan::call('mosquitto:reload', []);
		
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