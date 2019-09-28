<?php

namespace App\Http\Controllers\Services\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Kosan\Service\RegisterService;

class RegisterController extends Controller
{
    public function register(){
		//get the post data 
		$creds = request()->only(['name','email','password']);
		
		//return 400 (bad request), if input validation failed
		if (!RegisterService::validateRegister($creds)){
			return response()->json([], 500);
		}
		
		$registrationToken = RegisterService::register($creds);
		if ($registrationToken){
			//return 201 (Created), registration success
			return response()->json($registrationToken, 201);
		}
		
		//return 409 (Conflict), email already exists
		return response()->json([], 409);
	}
}
