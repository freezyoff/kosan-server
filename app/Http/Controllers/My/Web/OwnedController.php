<?php

namespace App\Http\Controllers\My\Web;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\Controller;

class OwnedController extends Controller{
	
	public function landing(){
		$user = Auth::user();
		return view("my.owned.list", [
			"ownedCount"=> $user->ownedLocations()->count()
		]);
	}
	
}
