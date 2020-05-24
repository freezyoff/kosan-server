<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Invoce extends Model
{
    protected $connection = 'kosan_finance';
	protected $table = "invoices";
    protected $fillable = [
		"id", 
		"biller_user_id", 
		"issue_date", 
		"due_date", 
		"grace_periode", 
		"notes"
	];
	
}
