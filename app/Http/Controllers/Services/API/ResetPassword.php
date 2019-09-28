<?php

namespace App\Http\Controllers\Services\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kosan\Service\ResetPasswordService;

class ResetPassword extends Controller
{
    public function reset(){
		$email = request("email");
		if (!ResetPasswordService::isRegistered($email)){
			return response()->json([], 404);
		}
		
		if (ResetPasswordService::make($email)){
			return response()->json([], 200);
		}
		
		return response()->json([], 500);
	}
}
