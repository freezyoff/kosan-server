<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Device\HasAdminShell;

class Device extends Model
{
	use HasAdminShell;
	
    protected $table = "devices";
	
	protected $fillable = [
		"location_id",
		"chipset_id",
		"name",
		"uuid",
		"mac",
		"api_token",
		"api_token_expired",
		"state"
	];
	
	public function location(){
		return $this->belongsTo("\App\Models\Location", "location_id", "id");
	}
	
	public function chipset(){
		return $this->belongsTo("\App\Models\Chipset", "chipset_id", "id");
	}
	
	public function io($default = false){
		if ($default){
			return $this->chipset()->first()->io();
		}
		
		return $this->hasMany("\App\Models\DeviceIO", "device_id", "id");
	}
	
	public function hasUUID(){
		return !($this->uuid == "");
	}
	
	public function register(){
		//we make sure uuid not change after set
		if (!$this->hasUUID()){
			$this->uuid = Str::uuid();
			$this->save();
		}
	}
	
	public function isApiTokenExpired(){
		if ($this->api_token_expired == null || $this->api_token_expired == ""){
			return true;
		}
		
		//not null, check 
		$apiExp = Carbon::parse($this->api_token_expired);
		if ($apiExp->lessThanOrEqualTo(now())){
			return true;
		}
		
		return false;
	}
	
	public function apiToken(){
		if ($this->isApiTokenExpired()){
			//api expired less or equal now
			//we renew the api token
			$lifetime = now()->addSeconds(config("kosan.device.api_token_lifetime"))->format("Y-m-d H:i:s");
			$this->api_token = hash('sha256', $this->uuid . " " . $lifetime);
			$this->api_token_expired = $lifetime;
			$this->save();
		}
		
		$unix = Carbon::parse($this->api_token_expired)->timestamp;
		return ["token"=>$this->api_token, "expired"=>$unix];
	}
	
	// Static function -----------------------------------
	static function findByApiToken($apiToken){
		return self::findByCredentials(["api_token"=>$apiToken]);
	}
	
	static function findByMAC($mac){
		return self::findByCredentials(["mac"=>$mac]);
	}
	
	static function findByCredentials($credentials){
		$search = Device::orderBy("id");
		foreach($credentials as $key=>$value){
			$search->where($key, $value);
		}
		return $search->first();
	}
}
