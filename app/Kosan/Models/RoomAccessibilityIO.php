<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAccessibilityIO extends Model
{
    protected $connection = 'kosan_device';
	protected $table = "room_accessibility_io";
    protected $fillable = [
		"id", 
		"room_accessibility_id", 
		"door_chipset_io_id", 
		"lock_chipset_io_id"
	];
	
	public function doorChipsetIO(){
		return $this->belongsTo("App\Kosan\Models\ChipseIO", "door_chipset_io_id", "id");
	}
	
	public function lockChipsetIO(){
		return $this->belongsTo("App\Kosan\Models\RoomAccessibilityIO", "lock_chipset_io_id", "id");
	}
	
	public function roomAccessibility(){
		return $this->belongsTo("App\Kosan\Models\RoomAccessibility", "room_accessibility_id", "id");
	}
}
