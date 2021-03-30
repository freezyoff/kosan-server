<?php 

namespace App\Kosan\Services;
use DB;
use Str;
use Carbon\Carbon;
use App\Kosan\Models\User;

class UserService{
	
	static function generateResetToken($email){
		$data = [
				'token' => $token = Str::random(60),
				'created_at' => Carbon::now()
		];
		DB::table('password_resets')->updateOrInsert(['email'=>$email], $data);
		return $data['token'];
	}
	
	static function isValidResetToken($token){
		$created = Carbon::parse($token->created_at);
		return $created->addDays(7)->gte(Carbon::now());
	}
	
	static function getResetToken($email){
		$user = User::findByEmail($email);
		if (!$user) return false;
		
		//get current token
		$currentToken = DB::table('password_resets')->where("email", $user->email)->first();
		if ($currentToken && self::isValidToken($currentToken)){
			return $currentToken->token;
		}
		
		//create new token
		return self::makeToken($user->email);
	}
	
	static function checkResetToken($token){
		return DB::table('password_resets')->where("token", $token)->first();
	}
	
	static function findByEmail($emailOrHashedEmail){
		$user = User::findByEmail($emailOrHashedEmail);
		return $user;
	}
}