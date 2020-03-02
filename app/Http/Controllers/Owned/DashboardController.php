<?php

namespace App\Http\Controllers\Owned;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller{
	
    public function landing(){
		return view("owned.dashboard");
	}
	
}
