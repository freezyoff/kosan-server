<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;

use App\Kosan\Models\User;
use App\Kosan\Models\Location;
use App\Kosan\Models\Room;

class LocationService{
	
	public static function make(User $user, array $locationData, int $rooms){
		//make location
		$location = new Location($locationData);
		$location->save();
		
		//make rooms
		for($i=0; $i<$rooms; $i++){
			Room::make($location, "Kamar ".($i+1));
		}
		
		return $location;
	}
	
	public static function updateByLocationHash($locationHash, Array $fieldsAndValue){
		$location = Location::findByHash($locationHash);
		if ($location){
			$location->fill($fieldsAndValue);
			$location->save();
			return true;
		}
		return false;
	}
	
	public static function userLocations(){
		$user = Auth::user();
		if (!$user) {
			return false;
		}
		
		if ($user->hasOwnedLocations()){
			return $user->locations();
		}
		
		return false;
	}
	
}