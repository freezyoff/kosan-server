<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'kosan_hardware';
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
	
	public function location(){
		return $this->belongsTo("App\Models\Location", "location_id", "id");
	}
}
