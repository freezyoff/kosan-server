<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chipset extends Model
{
    protected $table = "chipsets";
	
	protected $fillable = [
		"name",
		"pin_used"
	];
	
	public function io(){
		return $this->hasMany("\App\Models\ChipsetIO", "chipset_id", "id");
	}
	
	public function os(){
		return $this->hasMany("\App\Models\ChipsetOS", "chipset_id", "id");
	}
	
	public function devices(){
		return $this->hasMany("\App\Models\Device", "chipset_id", "id");
	}
}
