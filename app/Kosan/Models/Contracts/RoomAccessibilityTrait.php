<?php 

namespace App\Kosan\Models\Contracts;

use App\Kosan\Models\Contracts\DateValidityTrait;

trait RoomAccessibilityTrait{
	
	use DateValidityTrait;
	
	public function getValidBeforeAttribute(){
		return Carbon::parse($this->valid_after);
	}
	
	public function getValidBeforeAttribute(){
		return Carbon::parse($this->valid_before);
	}
	
	public function accessIO(){
		return $this->hasMany("App\Kosan\Models\RoomAccessibilityIO", "room_accessibility_id", "id");
	}
	
	public function device(){
		return $this->belongsTo("App\Kosan\Models\DeviceAccessibility", "device_id", "id");
	}
	
	public function room(){
		return $this->belongsTo("App\Kosan\Models\DeviceAccessibility", "room_id", "id");
	}
	
	public function invoice(){
		return $this->belongsTo("App\Kosan\Models\Invoice", "invoice_id", "id");
	}
	
}