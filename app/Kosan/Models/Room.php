<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

use App\Kosan\Models\Contracts\FindByPlainOrHashIdentifier;
use \App\Kosan\Models\Location;

class Room extends Model
{
	use FindByPlainOrHashIdentifier;
	
    protected $connection = 'kosan_kosan';
	protected $table = "rooms";
    protected $fillable = [
		"id", 
		"location_id", 
		"name", 
		"rate_daily", 
		"rate_weekly", 
		"rate_monthly",
	];
	
	protected function toNumber($value, $setter=false){
		//replace decimal separator
		if (preg_match('/[,]/', $value)){
			$value = preg_replace("/[,]/","",$value);
		}
		
		//rounding float to double
		return number_format($value, 2, '.', '');
	}
	
	public function setRateDailyAttribute($value){ $this->attributes['rate_daily'] =  $this->toNumber($value); }
	public function setRateWeeklyAttribute($value){ $this->attributes['rate_weekly'] = $this->toNumber($value); }
	public function setRateMonthlyAttribute($value){ $this->attributes['rate_monthly'] = $this->toNumber($value); }
	
	public function location(){
		return $this->belongsTo("\App\Kosan\Models\Location", "location_id", "id");
	}
	
	public function accessControls(){
		return $this->hasMany("\App\Kosan\Models\Relations\AccessControl", "room_id", "id");
	}
	
	public static function findByLocation(Location $location){
		if ($location){
			return self::where("location_id", $location->id);
		}
		return null;
	}

}
