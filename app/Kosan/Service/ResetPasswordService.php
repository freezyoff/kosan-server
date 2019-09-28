<?php 
namespace App\Kosan\Service;

use Illuminate\Support\Str;
use App\Models\User;
use Hash;

class ResetPasswordService{
	
	protected static function query(){
		return \DB::table("password_resets");
	}
	
	protected static function findByEmail($email){
		return User::findByEmail($email)->first();
	}
	
	protected static function saveRecord($email, $hashed_token){
		self::query()->updateOrInsert(
			['email' => $email],
			[
				'token' => $hashed_token, 
				'created_at'=> now()->format('Y-m-d H:i:s')
			]
		);
	}
	
	protected static function sendEmail($user, $plain_token){
		$user->notify(new \App\Notifications\ResetPasswordNotification([
				'name' => $user->name, 
				'password' => $plain_token
			]));
	}
	
	public static function isRegistered($email){
		return self::findByEmail($email)? true : false;
	}
	
	public static function make($email){
		$user = User::findByEmail($email);
		if (!$user){
			return false;
		}
		
		$plain_token = $random = Str::random(8);
		$hashed_token = Hash::make($plain_token);
		
		self::saveRecord($email, $hashed_token);
		self::sendEmail($user, $plain_token);
		
		return true;
	}
	
	public static function check(User $user, $plain_password){
		$records = self::findByEmail($user->email);
		
		if (!$records || Hash::check($plain_password, $records->token)){
			return false;
		}
		
		return true;
	}
	
	public static function remove($email){
		self::query()->where("email", $email)->delete();
	}
	
}