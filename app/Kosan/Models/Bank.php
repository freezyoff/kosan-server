<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'kosan_finance';
	
	protected $primaryKey = 'code';
	public $incrementing = false;
	protected $keyType = 'string';
	
	protected $table = "banks";
    protected $fillable = [
		"id",
		"code",
		"name",
	];
}
