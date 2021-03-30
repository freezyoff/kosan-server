<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;
use App\Kosan\Models\Contracts\FindByPlainOrHashIdentifier;

class Location extends Model
{
	use FindByPlainOrHashIdentifier;
	
    protected $connection = 'kosan_kosan';
	protected $table = "locations";
    protected $fillable = [
		"id", 
		"owner_user_id", 
		"pic_user_id", 
		"name", 
		"address", 
		"postcode",
		"phone"
	];
	
	public function rooms(){
		return $this->hasMany("App\Kosan\Models\Room", "location_id", "id");
	}
	
	public function owner(){
		return $this->belongsTo("App\Kosan\Models\User", "owner_user_id", "id");
	}
	
	public function pic(){
		return $this->belongsTo("App\Kosan\Models\User", "pic_user_id", "id");
	}
	
}
