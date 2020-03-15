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
		"gender",
		"address_province",
		"address_regency",
		"address_district",
		"address_village",
		"address_address",
		"address_postcode",
		"address_region",
		"address_number",
		"picture_profile",
		"picture_idcard",
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
	
	//
	//location relations
	//
	public function hasOwnedLocations(){
		return $this->locations()->count() > 0;
	}
	
	public function locations(){
		return $this->hasMany("App\Kosan\Models\Location", "owner_user_id", "id");
	}
	
	//
	//device relation
	//
	public function devices(){
		return $this->hasMany("\App\Kosan\Models\Device", "owner_user_id", "id");
	}
	public function hasDevice(){
		return $this->devices()->count() > 0;
	}
	
	//
	//room_users relation
	//
	public function roomSubscriptions(){
		return $this->belongsToMany(
			"App\Kosan\Models\Room",  
			"room_users",
			"user_id", 
			"room_id"
		)->using("App\Kosan\Models\Relations\RoomUser");
	}
	
	public function hasRoomSubscriptions(){
		return $this->roomSubscriptions()->count() > 0;
	}
	
}
