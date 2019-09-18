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
            'email' => 'required|unique:users,email|max:255',
            'password' => 'required',
        ]);

        return !$validator->fails();
	}
	
	public static function store(array $cred){
		if (self::validateRegister($cred)){
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
			
			return true;
		}
		
		return false;
	}
	
}