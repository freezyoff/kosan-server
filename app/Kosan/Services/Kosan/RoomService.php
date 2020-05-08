<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;

use App\Kosan\Models\Location;
use App\Kosan\Models\Room;

class RoomService {
	
	public static function make(Location $location, Array $roomAttr){
		$roomAttr['location_id'] = $location->id;
		
		$room = new Room($roomAttr);
		$room->save();
		
		return $room;
	}
	
	public static function change(Room $room, Array $attr){
		if (!$room){
			return false;
		}
		$room->fill($attr);
		$room->save();
		return true;
	}
	
}