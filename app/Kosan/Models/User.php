<?php

namespace App\Kosan\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\User as BaseModel;


class User extends BaseModel
{
    protected $connection = 'kosan_system';
	protected $table = "users";
    protected $fillable = [
		"id",
		"name",
		"email",
		"email_verified_at",
		"password",
		"remember_token",
		"api_token",
		"api_token_expired",
		"oauth_google_token"
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
	
	public function setOauthGoogleToken($value){
		$this->attributes['oauth_google_token'] = Crypt::encryptString($value);
	}
	
	public function getOauthGoogleToken(){
		return Crypt::decryptString( $this->attributes['oauth_google_token'] );
	}
	
	public function rooms(){
		return $this->belongsToMany(
			"App\Kosan\Models\Room", 
			"App\Kosan\Models\Contracts\RoomUser", 
			"user_id", 
			"room_id"
		)->withPivot([
			"created_at",
			"updated_at",
			"id",
			"name",
			"email",
			"email_verified_at",
			"password",
			"remember_token",
			"api_token",
			"api_token_expired",
		]);
	}
	
	public function ownedLocations(){
		return $this->hasMany("App\Kosan\Models\Location", "owner_user_id", "id");
	}
	
	public function managedLocations(){
		return $this->hasMany("App\Kosan\Models\Location", "pic_user_id", "id");
	}
	
	public function issuedInvoice(){
		return $this->hasMany("App\Kosan\Models\Invoice", "issuer_user_id", "id");
	}
	
	public function billedInvoice(){
		return $this->hasMany("App\Kosan\Models\Invoice", "billed_to_user_id", "id");
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
	
	public function verifyEmail(){
		$this->email_verified_at = now()->format('Y-m-d H:i:s');
		$this->save();
	}
	
	public function isEmailVerified(){
		return $this->email_verified_at? true : false;
	}
	
	public static function findByEmail($email){
		return User::where('email',strtolower($email))->first();
	}
	
	public static function findByApiToken($token){
		return User::where('api_token',$token)->first();
	}
	
	public static function findByActivationToken($token){
		return User::whereRaw("MD5(`email`) = ?",[$token])->first();
	}
}
