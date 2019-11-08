<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserAccessibility extends Model
{
    protected $connection = 'kosan_accessibility';
	protected $table = "users_accessibilities";
    protected $fillable = [
		'device_accessibility_id',
		'user_id',
		'valid_after',
		'valid_before'
	];
	
	public function deviceAccessibility(){
		return $this->belongsTo('App\Models\DeviceAccessibility', 'device_accessibility_id', 'id');
	}
	
	public function isExpired(){
		return !now()->between(Carbon::parse($this->valid_after), Carbon::parse($this->valid_before));
	}
	
	public function toAndroidGson(){
		return [
			"id" => $this->id,
			"location_id" => $this->deviceAccessibility->device->location->id,
			"name" => $this->deviceAccessibility->name,
			"valid_after" => Carbon::parse($this->valid_after)->timestamp,
			"valid_before" => Carbon::parse($this->valid_before)->timestamp,
		];
	}
}
