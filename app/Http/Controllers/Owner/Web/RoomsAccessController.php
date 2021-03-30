<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RoomsAccessController extends Controller{
	
	public function landing(){
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
		
		return view('owner.material-dashboard.rooms-access', $data);
	}
	
}