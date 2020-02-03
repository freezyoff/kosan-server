<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $connection = 'kosan_kosan';
	protected $table = "facilities";
    protected $fillable = [
		"id", 
		"name"
	];
	
	public function rooms(){
		return $this->belongsToMany(
				"App\Kosan\Models\Room", 
				"App\Kosan\Models\Relations\RoomFacility", 
				"facility_id", 
				"room_id"
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
}
