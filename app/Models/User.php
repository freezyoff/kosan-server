<?php

namespace App\Models;

use App\User as BaseModel;
use App\Models\User\HasBio;
use App\Models\User\HasDocs;

class User extends BaseModel
{
	use HasBio,
		HasDocs;
	
	
	public function locations(){
		return $this->hasMany("\App\Models\Location", "owner_user_id", "id");
	}
	
	public function ownedLocations(){
		return locations()->get();
	}
	
	public function hasAnyOwnedLocations(){
		return ownedLocations()->count()>0;
	}
	
}
