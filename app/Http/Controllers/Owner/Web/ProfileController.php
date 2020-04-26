<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller{
	
    public function landing(){
		return view('owner.material-dashboard.profile');
	}
	
}
