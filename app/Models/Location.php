<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table="locations";
	
	protected $fillable=[
		"owner_user_idIndex",
		"uuid",
		"name",
		"address",
		"postcode",
		"phone",
		"descriptions",
		"pic_user_id",
	];
	
	public function owner(){
		return $this->belongsTo("\App\Models\User", "user_id", "id");
	}
	
	public function pic(){
		return $this->belongsTo("\App\Models\User", "pic_user_id", "id");
	}
	
	public function devices(){
		return $this->hasMany("\App\Models\Device", "location_id", "id");
	}
}
