<?php 
namespace App\Kosan\Service;

use Auth;
use Hash;
use App\Models\User;
use App\Kosan\Service\ResetPasswordService;

class AuthService{
	
	public static function userLoginWithAPIToken($credentials){
		//check if token belongs to authorized user
		$authorizedUser = User::findByApiToken($credentials);
		if (!$authorizedUser){
			return false;
		}
		
		//logged in the authorized user
		Auth::login($authorizedUser);
		$authorizedUser->renewApiToken();
		return true;
	}
	
	/*
	 * @var $credentials (array) - email and password
	 */
	public static function userLogin($credentials){
		$user = User::findByEmail($credentials['email']);
		if (
			!$user || 
			!ResetPasswordService::check($user, $credentials['password']) ||
			!Hash::check($credentials['password'], $user->password)
			){
				
			return false;
			
		}
		
		//logged in the authorized user
		Auth::login($user);
		$user->renewApiToken();
		return true;
	}
	
	public static function userLogout(User $user){
		if ($user){
			$user->api_token = null;
			$user->api_token_expired = null;
			$user->save();
		}
		Auth::logout();
	}
	
	public static function changePassword(User $user, $new_password){
		if (!$user){
			return false;
		}
		
		$user->password = Hash::make($new_password);
		$user->save();
		
		ResetPasswordService::remove($user->email);
		return true;
	}
}