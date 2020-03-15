<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $connection = 'kosan_kosan';
	protected $table = "rooms";
    protected $fillable = [
		"id", 
		"location_id", 
		"name", 
		"rate_daily", 
		"rate_weekly", 
		"rate_monthly",
		"ready"
	];
	
	public function isReady() : Boolean {
		return $this->ready? true : false;
	}
	
}
