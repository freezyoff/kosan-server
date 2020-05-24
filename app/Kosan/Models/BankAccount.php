<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $connection = 'kosan_finance';
	protected $table = "bank_accounts";
    protected $fillable = [
		"id",
		"owner_user_id",
		"name",
		"bank_code",
		"bank_account",
		"holder"
	];
	
	public function bankName(){
		return $this->belongsTo("\App\Kosan\Models\Bank", "bank_code", "code")->first()->name;
	}
	
	public function bank_name(){
		return $this->bankName();
	}
	
	public static function findByHash($hash){
		return BankAccount::whereRaw("MD5(`id`) = ?", $hash)->first();
	}
}
