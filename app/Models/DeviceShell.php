<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DeviceShell extends Model
{
	
	protected $table = "device_shell";
	
	protected $fillable = [
		"user_id",
		"device_id",
		"created_at",
		"cleared",
		"executed",
		"executed_at",
		"confirmed",
		"confirmed_at",
		"shell"
	];
	
	public function device(){
		return $this->belongsTo("\App\Models\Device", "device_id", "id");
	}
	
	public function user(){
		return $this->belongsTo("\App\Models\User", "user_id", "id");
	}
	
}
