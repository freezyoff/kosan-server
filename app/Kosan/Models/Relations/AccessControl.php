<?php 

namespace App\Kosan\Models\Relations;

use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model
{
	protected $connection = 'kosan_device';
	protected $table = "access_controls";
    protected $fillable = [
		"id",
		"name",
		"room_id",
		"device_id",
		"chanel",
	];
	
	public function device(){
		if ($this->device_id){
			return $this->belongsTo('\App\Kosan\Models\Device', 'device_id', 'id');			
		}
		return null;
	}
	
	public function room(){
		if ($this->room_id){
			return $this->belongsTo('\App\Kosan\Models\Room', 'room_id', 'id');
		}
		
		return null;
	}
	
	public static function findByHash($hash){
		return self::whereRaw("MD5(id) = '$hash'")->first();
	}
}