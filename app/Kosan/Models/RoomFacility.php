<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class RoomFacility extends Model
{
	protected $connection = 'kosan_kosan';
	protected $table = "room_facilities";
    protected $fillable = [
		"id", 
		"room_id", 
		"facility_id", 
		"type", 
		"additional_cost"
	];
}
