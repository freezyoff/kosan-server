<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAccessibility extends Model
{
    protected $connection = 'kosan_accessibility';
	protected $table = "devices_accessibilities";
    protected $fillable = [
		'device_id',
		'lock_pin',
		'door_pin',
		'name'
	];
	
	protected $hidden = [
		'created_at',
		'updated_at',
	];
	
	public function device(){
		return $this->belongsTo("App\Models\Device", "device_id", "id");
	}
	
	public function userAccessibilities(){
		return $this->hasMany("App\Models\UserAccessibility", "device_accessibility_id", "id");
	}
}
