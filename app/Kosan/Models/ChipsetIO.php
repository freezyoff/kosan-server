<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetIO extends Model
{
    protected $connection = 'kosan_device';
	protected $table = "chipset_io";
    protected $fillable = [
		"id",
		"chipset_id",
		"mode", 
		"pin", 
		"trigger_signal", 
		"trigger_target_pin", 
		"trigger_target_signal", 
		"trigger_target_delay"
	];
	
	public function chipset(){
		return $this->belongsTo("App\Kosan\Models\Chipset", "chipset_id", "id");
	}
	
	public function accessDoorIO(){
		return $this->hasMany("App\Kosan\Models\RoomAccessibilityIO", "door_chipset_id", "id");
	}
	
	public function accessLockIO(){
		return $this->hasMany("App\Kosan\Models\RoomAccessibilityIO", "lock_chipset_id", "id");
	}
}
