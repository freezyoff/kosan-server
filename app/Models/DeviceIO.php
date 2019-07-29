<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceIO extends Model
{
    protected $table = "device_io";
	
	protected $fillable = [
		"device_id",
		"pin",
		"mode",
		"type",
		"trigger",
		"target_pin"
	];
	
	public function device(){
		return $this->belongsTo("\App\Models\Device", "device_id", "id");
	}
}
