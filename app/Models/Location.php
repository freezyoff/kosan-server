<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table="locations";
	
	protected $fillable=[
		"owner_id",
		"uuid",
		"loc_name",
		"loc_address",
		"loc_postcode",
		"loc_phone",
		"loc_phone_ext",
		"pic_name",
		"pic_phone",
		"pic_phone_ext"
	];
	
	public function owner(){
		return $this->belongsTo("\App\Models\Owner", "owner_id", "id");
	}
	
	public function devices(){
		return $this->hasMany("\App\Models\Device", "location_id", "id");
	}
}
