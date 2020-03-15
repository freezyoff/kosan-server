<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $connection = 'kosan_kosan';
	protected $table = "facilities";
    protected $fillable = [
		"id", 
		"name"
	];
	
}
