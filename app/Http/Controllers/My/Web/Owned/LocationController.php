<?php

namespace App\Http\Controllers\My\Web\Owned;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\Controller;

class LocationController extends Controller{
	
	public function makeForm(){
		return view("my.owned.location.make");
	}
	
	public function make(Request $request){
		return $request;
	}
	
}
