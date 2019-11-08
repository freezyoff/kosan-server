<?php

namespace App\Http\Controllers\Services\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserResource extends Controller
{
    public function ownedLocations(){
		$attributes = [];
		$locations = Auth::user()->ownedLocations;
		foreach($locations as $loc){
			$attributes[] = $loc->toAndroidGson();
		}
		
		return response()->json($attributes, 200);
	}
	
	public function accessiblities(){
		$attributes = [];
		$access = Auth::user()->accessibilities;
		foreach($access as $acc){
			$attributes[] = $acc->toAndroidGson();
		}
		return response()->json($attributes, 200);
	}
}
