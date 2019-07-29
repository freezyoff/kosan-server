<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetIO extends Model
{
    protected $table = "chipset_io";
	
	protected $fillable = [
		"chipset_id",
		"pin",
		"mode",
		"type",
		"trigger",
		"target_pin"
	];
	
	public function chipset(){
		return $this->belongsTo("\App\Models\Chipset", "chipset_id", "id");
	}
	
}
