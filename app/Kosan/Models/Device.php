<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'kosan_device';
	protected $table = "devices";
    protected $fillable = [
		"id",
		"chipset_id",
		"owner_user_id",
		"location_id",
		"uuid",
		"mac",
		"api_token",
		"api_token_expired"
	];
	
	public function chipset(){
		return $this->belongsTo("\App\Kosan\Models\Chipset", "chipset_id", "id");
	}
	
	public function rooms(){
		return $this->belongsToMany("\App\Kosan\Models\Room", "kosan_device.access_controls", "device_id", "room_id");
	}
	
	public function accessControls(){
		return $this->hasMany("\App\Kosan\Models\Relations\AccessControl", "device_id", "id");
	}
	
	public function location(){
		return $this->belongsTo("\App\Kosan\Models\Location", "location_id", "id");
	}
	
	public static function findByMacHash($macHash){
		return Device::whereRaw("MD5(`mac`) = '$macHash'")->first();
	}
	
}
