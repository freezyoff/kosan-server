<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class RoomInvoice extends Model
{
    protected $connection = 'kosan_finance';
	protected $table = "rooms_invoices";
    protected $fillable = [
		"id", 
		"invoice_id", 
		"room_id", 
		"start", 
		"end", 
		"grace_periode",
		"ammount",
		"tax",
		"discount"
	];
	
	public function invoice(){
		return $this->belongsTo("\App\Kosan\Models\Invoice", "invoice_id", "id");
	}
	
}
