<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Location extends Model
{
    protected $connection = 'kosan_hardware';
	protected $table = "locations";
    protected $fillable = [
		'owner_user_id',
		'pic_user_id',
		'uuid',
		'name',
		'address',
		'postcode',
		'phone'
	];
	
	public function owner(){
		return $this->belongsTo("App\Models\User", "owner_user_id", "id");
	}
	
	public function pic(){
		return $this->belongsTo("App\Models\User", "pic_user_id", "id");
	}
	
	public function devices(){
		return $this->hasMany("App\Models\Device", "location_id", "id");
	}
	
	public function toAndroidGson(User $user=null){
		$attrs = [
			"id" => $this->id,
			"uuid" => $this->uuid,
			'name' => $this->name,
			'address' => $this->address,
			'postcode' => $this->postcode,
			'phone' => $this->phone
		];
		
		// check if given $owner_user_id not same as this location owner
		if ($user && $user->id != $this->owner_user_id){
			$attrs["owner"] = $this->owner->toAndroidGson();
		}
		
		//check if given $pic_user_id not same as this location pic
		if ($user && $user->id != $this->pic_user_id){
			$attrs["pic"] = $this->pic->toAndroidGson();
		}
		
		return $attrs;
	}
	
}
