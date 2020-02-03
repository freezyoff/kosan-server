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
		"location_id",
		"uuid",
		"mac",
		"api_token",
		"api_token_expired"
	];
	
	public function chipset(){
		return $this->belongsTo("App\Kosan\Models\Chipset", "chipset_id", "id");
	}
	
	public function rooms(){
		return $this->belongsToMany(
				"App\Kosan\Models\Room", 
				"App\Kosan\Models\Relations\RoomAccessibility",
				"device_id", "room_id"
			)->withPivot([
				"created_at",
				"updated_at",
				"id", 
				"invoice_id", 
				"room_id", 
				"device_id", 
				"valid_after", 
				"valid_before", 
				"grace_periode"
			]);
	}
	
	public function invoice(){
		return $this->belongsToMany(
				"App\Kosan\Models\Invoice", 
				"App\Kosan\Models\Relations\RoomAccessibility",
				"subscription_device_id", "invoice_id"
			)->withPivot([
				"created_at",
				"updated_at",
				"id", 
				"invoice_id", 
				"room_id", 
				"device_id", 
				"valid_after", 
				"valid_before", 
				"grace_periode"
			]);
	}
}
