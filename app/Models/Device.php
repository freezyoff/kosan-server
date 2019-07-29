<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = "devices";
	
	protected $fillable = [
		"location_id",
		"chipset_id",
		"name",
		"uuid",
		"mac",
		"os_hash",
		"api_token",
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
}
