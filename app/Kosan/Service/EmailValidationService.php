<?php 
namespace App\Kosan\Service;

use Illuminate\Support\Str;
use Hash;
use DB;

class EmailValidationService{
	
	protected static function query(){
		return DB::table("email_validates");
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
	
	protected static function deleteRecord($email){
		self::query()->where("email", $email)->delete();
	}
	
	protected static function getRecord($email){
		return self::query()->where('email', $email)->first();
	}
	
	public static function check($email, $plain_token){
		$validation = getRecord($email);
		
		//if record not found
		if (!$validation) {	
			return false;
		}
		
		//if token not match, return false
		if (!Hash::check($plain_token, $validation->token)){
			return false;
		}
		
		//assume token match
		//remove record
		self::deleteRecord($email);
		return true;
	}
	
	public static function make($email){
		$plain_token = $random = Str::random(8);
		$hashed_token = Hash::make($plain_token);
		
		self::saveRecord($email, $hashed_token);
		
		return $plain_token;
	}
	
}