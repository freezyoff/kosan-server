<?php

namespace App\Kosan\Models\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomFacility extends Pivot
{
	public $incrementing = true;
	
	public function room(){
		return $this->belongsTo("App\Kosan\Models\Room", "facility_id", "id");
	}
	
	public function facility(){
		return $this->belongsTo("App\Kosan\Models\Facility", "facility_id", "id");
	}
	
	public function isShared(){
		return $this->shared;
	}
	
	public function isAdditional(){
		return $this->additional;
	}
	
}
