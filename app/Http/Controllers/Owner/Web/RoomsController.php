<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RoomsController extends Controller{
	
    public function landing(){
		$data = [];
		if (Auth::user()->hasOwnedLocations()){
			$data["locations"] = Auth::user()->locations();
		}
		return view("owner.material-dashboard.rooms", $data);
	}
	
}
