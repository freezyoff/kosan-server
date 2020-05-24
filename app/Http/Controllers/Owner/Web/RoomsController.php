<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Kosan\Models\Room;
use App\Kosan\Models\Location;

use App\Kosan\Services\Kosan\RoomService;

class RoomsController extends Controller{
	
    public function landing(Request $r){
		$data = [];
		if (Auth::user()->hasOwnedLocations()){
			$data["locations"] = Auth::user()->locations();
		}
		
		//when saving change data, page will redirect here.
		//we need to capture last table list
		//we provide table list in session var "preffered_location"
		if (session('preffered_location')){
			$data["preffered_location"] = session('preffered_location');
		}
		
		return view("owner.material-dashboard.rooms", $data);
	}
	
	public function create(Request $r){
		$location = Location::findByHash($r->input('location'));
		RoomService::make($location, $r->input('roomAttr'));
		return redirect()->route('web.owner.room')
			->with('preffered_location', $r->input('location'));
	}
	
	public function change(Request $r){
		$room = Room::findByHash($r->input('room'));
		if (!$room){
			$room = Room::find($r->input('room'));
			return redirect()->route('web.owner.room');
		}
		
		RoomService::change($room, $r->input('roomAttr'));
		return redirect()->route('web.owner.room')
			->with('preffered_location', md5($room->location_id));
	}
	
	public function lease(Request $r){
		return $r;
	}
	
}