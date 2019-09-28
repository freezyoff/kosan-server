<?php 
namespace App\Kosan\Service;

use Illuminate\Support\Facades\Validator;

use App\Kosan\Service\EmailValidationService;
use App\Models\User;
use App\Models\EmailValidate;
use App\Notifications\RegisterEmailNotification;

class RegisterService{
	
	public static function validateRegister(array $cred){
		 $validator = Validator::make($cred, [
			'name' => 'required|max:255',
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required',
        ]);

        return !$validator->fails();
	}
	
	public static function register(array $cred){
		$user = new User;
		$user->fill($cred);
		$user->save();
		
		//generate token
		$plain_token = EmailValidationService::make($user->email);
		
		//send email notification
		$user->notify(new RegisterEmailNotification([
			'name'=> $user->name,
			'email'=> $user->email,
			'password'=> $cred['password'],
			'token'=> $plain_token
		]));
		
		//add mosquitto user and password to passwd file
		//so the user can use mqtt
		$passwdFilePath = config("kosan.mqtt_password_file");
		exec("mosquitto_passwd -b ". $passwdFilePath ." ". $user->email ." ". $cred['password']);
		
		$user->renewApiToken();
		
		return [
			'api_token'=> 			$user->api_token,
			'api_token_expired'=>	$user->api_token_expired,
		];
		
	}
	
}