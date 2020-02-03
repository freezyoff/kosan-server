<?php 
namespace App\Kosan\Services\Auth;

use Illuminate\Cache\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Artisan;
use Auth;
use Hash;
use Str;
use Lang;

use App\Kosan\Models\User;
use App\Kosan\Services\ResetPasswordService;
use App\Notifications\RegisterEmailNotification;

class AuthService{
	
	public static function createUser($credentials){
		foreach(["name","email","password"] as $validate){
			if (!array_key_exists($validate, $credentials)){
				return false;
			}
		}
		
		$user = new User;
		$user->fill($credentials);
		$user->save();
		
		//add user to mosquitto passwd
		/*
		Artisan::call('kosan:mqtt-add-user', [
			"pwdfile"=>	config("kosan.mqtt_password_file"),
			"user"=>	$user->email,
			"pwd"=>		$credentials["password"]
		]);
		*/
		
		//restart mosquitto
		//Artisan::call('kosan:mqtt-restart',[]);
		
		//restart kosan server
		//Artisan::call('kosan:kosan-server-restart',[]);
		
		return $user;
	}
	
	public static function register($credentials){
		$user = User::findByEmail($credentials["email"]);
		
		//user not exitst yet
		if (!$user){
			
			//create user
			$user = self::createUser($credentials);
			
			//send notification
			$user->notify( new RegisterEmailNotification($credentials) );
		}
		
		return $user;
	}
	
	public static function login($credentials){
		//with email, password
		if (is_array($credentials)){
			$user = User::findByEmail($credentials['email']);
			$invalid = !$user || 
						!ResetPasswordService::check($user, $credentials['password']) ||
						!Hash::check($credentials['password'], $user->password);
						
			if ($invalid){ 
				return false; 
			}
		}
		
		//with api token
		elseif (array_key_exists("api_token", $credentials)){
			$user = User::findByApiToken($credentials);
		}
		
		//with User Object
		elseif ($credentials instanceof User){
			$user = $credentials;
		}
		
		else{
			return false;
		}
		
		$user->renewApiToken();
		Auth::login($user);
		return true;
	}
	
	public static function loginIncrementAttempts($request){
		app(RateLimiter::class)->hit(
			Str::lower($request->input('email')).'|'.$request->ip(), 
			//60 * property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1
			60 * 1
		);
	}
	
	public static function loginHasTooManyAttempts($request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            Str::lower($request->input('email')).'|'.$request->ip(), 
			//property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5
			5
        );
    }
	
	public static function loginClearAttempts(Request $request)
    {
        app(RateLimiter::class)->clear(Str::lower($request->input('email')).'|'.$request->ip());
    }
	
	public static function loginSendLockoutResponse($request)
    {
		return abort(429, "Too many login attempts");
    }
	
	public static function logout(){
		$user = Auth::user();
		if ($user){
			$user->api_token = null;
			$user->api_token_expired = null;
			$user->save();
		}
		Auth::logout();
	}
	
	public static function changePassword($new_password){
		if (!$user){
			return false;
		}
		
		Auth::user()->password = Hash::make($new_password);
		Auth::user()->save();
		
		ResetPasswordService::remove($user->email);
		return true;
	}
	
}