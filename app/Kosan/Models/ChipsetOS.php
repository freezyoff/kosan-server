<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetOS extends Model
{
    protected $connection = 'kosan_device';
	protected $table = "chipset_os";
    protected $fillable = [
		"id",
		"chipset_id",
		"hash",
		"firmware"
	];
	
	public function chipset(){
		return $this->belongsTo("App\Kosan\Models\Chipset", "chipset_id", "id");
	}
}
