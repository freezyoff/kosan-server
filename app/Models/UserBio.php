<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
	
    protected $table = "user_bio";
	protected $fillable = [
		"user_id",
		"type",
		"name_first",
		"name_middle",
		"name_last",
		"address",
		"postcode",
		"phone1",
		"phone2",
	];
	
	public function user(){
		return $this->belongsTo("\App\Models\User", "user_id", "id");
	}
	
}
