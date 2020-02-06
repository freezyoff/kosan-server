<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\Controller;

use App\Kosan\Models\Location;
use App\Kosan\Models\Room;

class RoomService extends Controller{
	
	public function make(Location $location, String $name){
		$keys = ["location_id", "name"];
		$room = new Room( array_combine(
			$keys, 
			[$location->id, $name]
		) );
		$room->save();
		
		return $room;
	}
	
}