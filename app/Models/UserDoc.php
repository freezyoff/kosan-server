<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDoc extends Model
{
	
    protected $table = "user_docs";
	protected $fillable = [
		"user_id",
		"type",
		"reg_number",
		"issued_date",
		"issued_at",
		"verified",
		"verified_by",
		"verified_at",
	];
	
	public function user(){
		return $this->belongsTo("\App\Models\User", "user_id", "id");
	}
	
}
