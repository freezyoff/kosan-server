<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetOS extends Model
{
    protected $table = "chipset_os";
	
	protected $fillable = [
		"chipset_id",
		"version",
		"firmware_size",
		"firmware_hash",
		"firmware_bin",
		"storage_size",
		"storage_hash",
		"storage_bin"
	];
	
	protected $protected = [
		"firmware_bin",
		"storage_bin"
	];
	
	public function chipset(){
		return $this->belongsTo("App\Models\Chipset", "chipset_id", "id");
	}
	
	public static function latest($chipset_id){
		return self::where("chipset_id", $chipset_id)->orderBy("created_at", "desc")->first();
	}
}
