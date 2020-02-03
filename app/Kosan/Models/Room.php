<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $connection = 'kosan_kosan';
	protected $table = "rooms";
    protected $fillable = [
		"created_at",
		"updated_at",
		"id", 
		"location_id", 
		"name", 
		"rate_daily", 
		"rate_weekly", 
		"rate_monthly"
	];
	
	public function facilities(){
		return $this->belongsToMany(
				"App\Kosan\Models\Facility", 
				"App\Kosan\Models\Relations\RoomFacility", 
				"room_id", 
				"facility_id"
			)->withPivot([
				"created_at",
				"updated_at",
                "id", 
				"room_id", 
				"facility_id", 
				"value", 
				"shared", 
				"additional"
            ]);
	}
	
	public function users(){
		return $this->belongsToMany(
			"App\Kosan\Models\User", 
			"App\Kosan\Models\Contracts\RoomUser", 
			"room_id", 
			"user_id"
		)->withPivot([
			"created_at",
			"updated_at",
			"id",
			"name",
			"email",
			"email_verified_at",
			"password",
			"remember_token",
			"api_token",
			"api_token_expired",
		]);
	}
	
	public function device(){
		return $this->belongsToMany(
				"App\Kosan\Models\Device", 
				"App\Kosan\Models\Relations\RoomAccessibility", 
				"room_id", 
				"device_id"
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
		return $this->belongsToMany("App\Kosan\Models\Invoice", "subscription_room_id","id");
	}
	
	public function locations(){
		return $this->belongsTo("App\Kosan\Models\Locations", "locations_id", "id");
	}
	
}
