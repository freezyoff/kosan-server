<?php

namespace App\Models;

use App\User as BaseModel;

class User extends BaseModel
{
    public function asOwner(){
		return $this->hasMany("\App\Models\Owner", "user_id", "id");
	}
}
