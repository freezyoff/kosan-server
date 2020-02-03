<?php

namespace App\Kosan\Models\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Kosan\Models\Contracts\DateValidityTrait;

class RoomUser extends Pivot
{
	use DateValidityTrait;
	
	public $incrementing = true;
	
	public function room(){
		return $this->belongsTo("App\Kosan\Models\Room", "room_id", "id");
	}
	
	public function invoice(){
		return $this->belongsTo("App\Kosan\Models\Invoice", "invoice_id", "id");
	}
	
	public function user(){
		return $this->belongsTo("App\Kosan\Models\User", "user_id", "id");
	}
	
}
