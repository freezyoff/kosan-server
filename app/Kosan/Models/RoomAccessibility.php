<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Kosan\Models\Contracts\RoomAccessibilityTrait;

class RoomAccessibility extends Model
{
	public $incrementing = true;
	protected $connection = 'kosan_device';
	protected $table = "room_accessibilities";
    protected $fillable = [
		"id", 
		"invoice_id", 
		"room_id", 
		"device_id", 
		"valid_after", 
		"valid_before", 
		"grace_periode"
	];
	
	use RoomAccessibilityTrait;
}
