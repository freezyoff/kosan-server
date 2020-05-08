<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;

use App\Kosan\Models\User;
use App\Kosan\Models\Location;
use App\Kosan\Models\Room;

class LocationService{
	
	public function make(User $user, array $locationData, int $rooms){
		//make location
		$location = new Location($locationData);
		$location->save();
		
		//make rooms
		for($i=0; $i<$rooms; $i++){
			Room::make($location, "Kamar ".($i+1));
		}
		
		return $location;
	}
	
}