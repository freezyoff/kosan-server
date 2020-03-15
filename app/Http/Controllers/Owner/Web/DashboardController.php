<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller{
	
    public function landing(){
		return view("owner.material-dashboard.dashboard");
	}
	
}
