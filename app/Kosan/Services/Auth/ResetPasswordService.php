<?php 
namespace App\Kosan\Services\Auth;

use Illuminate\Support\Str;
use App\Kosan\Models\User;
use App\Notifications\ResetPasswordNotification;
use Hash;

class ResetPasswordService{
	
	protected static function makeRecord($email){
		$plain_token = $random = Str::random(8);
		$hashed_token = Hash::make($plain_token);
		
		//save reset password request
		\DB::table("password_resets")->updateOrInsert(
			['email' => $email],
			[
				'token' => $hashed_token, 
				'created_at'=> now()->format('Y-m-d H:i:s')
			]
		);
		
		return $plain_token;
	}
	
	protected static function destroyRecord($email){
		\DB::table("password_resets")->where("email", $email)->delete();
	}
	
	public static function resolveRequest($token){
		//get all reset password records
		foreach(\DB::table("password_resets")->get() as $item){
			
			//compare
			if (Hash::check($token, $item->token)){
				return $item;
			}
			
		}
		
		return false;
	}
	
	public static function makeRequest($email){
		
		//check if email registered
		$user = User::findByEmail($email)->first();
		if (!$user){
			return false;
		}
		
		//send reset password email
		$notification = new ResetPasswordNotification( self::makeRecord($email) );
		$user->notify($notification);
		
		return true;
		
	}
	
	/**
	 *	@return (App/Kosan/Models/User) target user by token
	 */
	public static function reset($token, $newPwd){
		$resetRequest = self::resolveRequest($token);
		$user = User::findByEmail( $resetRequest->email )->first();
		if (!$user){
			return false;
		}
		
		$user->password = $newPwd;
		$user->save();
		return $user;
	}
	
}