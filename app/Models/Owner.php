<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
	
    protected $table = "owners";
	protected $fillable = [
		"user_id",
		"uuid",
		"org_name",
		"org_address",
		"org_postcode",
		"org_phone",
		"org_phone_ext",
		"pic_name",
		"pic_phone",
		"pic_phone_ext"
	];
	
	public function user(){
		return $this->belongsTo("\App\Models\User", "user_id", "id");
	}
	
	public function locations(){
		return $this->hasMany("\App\Models\Location", "owner_id", "id");
	}
	
}
