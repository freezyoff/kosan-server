<?php

namespace App\Models;

use App\User as BaseModel;
use App\Kosan\Service\EmailValidationService;
use Hash;
use Carbon\Carbon;

class User extends BaseModel
{
	protected $connection = 'kosan_user';
	protected $table = "users";
    protected $fillable = [
		'name',
		'email',
		'password'
	];
	
	public function setPasswordAttribute($value){
		$this->attributes['password'] = Hash::make($value);
	}
	
	public function setApiTokenAttribute($value){
		$this->attributes['api_token'] = $value;
		$this->attributes['api_token_expired'] = now()->addMinute()->format("Y-m-d H:i:s");
	}
	
	public function setEmailAttribute($value){
		$this->attributes['email'] = strtolower($value);
	}
	
	public function renewApiToken(){
		if ($this->isApiTokenExpired()){
			$this->api_token = hash('sha256', $this->id ."-". now()->timestamp);
			$this->save();
		}
		return ['api_token'=> $this->api_token, 'api_token_expired'=> $this->api_token_expired];
	}
	
	public function isApiTokenExpired(){
		return 	$this->api_token == NULL ||
				$this->api_token_expired == NULL ||
				now()->greaterThanOrEqualTo(Carbon::parse($this->api_token_expired));
	}
	
	public function verifyEmail($token){
		if (EmailValidationService::verify($this->email, $token)){
			$this->email_verified_at = now()->format('Y-m-d H:i:s');
			$this->save();
		}
	}
	
	public static function findByEmail($email){
		return User::where('email',strtolower($email))->first();
	}
	
	public static function findByApiToken($token){
		return User::where('api_token',$token)->first();
	}
	
}
