<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Chipset extends Model
{
    protected $connection = 'kosan_device';
	protected $table = "chipsets";
    protected $fillable = [
		"id",
		"name",
		"used_io"
	];
	
	public function chipsetOS(){
		return $this->hasMany("App\Kosan\Models\ChipsetOS", "chipset_id", "id");
	}
	
	public function latestChipsetOS(){
		return $this->chipsetOS()->orderBy('id', 'desc')->first();
	}
	
	public function chipsetIO(){
		return $this->hasMany("App\Kosan\Models\ChipsetIO", "chipset_id", "id");
	}
	
	public function devices(){
		return $this->hasMany("App\Kosan\Models\Device", "chipset_id", "id");
	}
}
