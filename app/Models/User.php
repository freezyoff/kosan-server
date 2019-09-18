<?php

namespace App\Models;

use App\User as BaseModel;
use Hash;

class User extends BaseModel
{
	protected $connection = 'mysql';
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
		$this->attributes['api_token_expired'] = now()->format("Y-m-d H:i:s");
	}
	
	public function renewApiToken(){
		$this->api_token = hash('sha256', $this->id ."-". now()->format("Y-m-d H:i:s"));
	}
}
