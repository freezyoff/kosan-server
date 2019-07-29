<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetOS extends Model
{
    protected $table = "chipset_os";
	
	protected $fillable = [
		"chipset_id",
		"version",
		"hash",
		"sketch_bin",
		"spiffs_bin"
	];
	
	public function chipset(){
		return $this->belongsTo("App\Models\Chipset", "chipset_id", "id");
	}
	
}
