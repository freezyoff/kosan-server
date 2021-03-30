<?php

namespace App\Http\Controllers\Services\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Kosan\Services\UserService;

class Android extends Controller
{
	
    function changePassword(Request $r){
		$user = UserService::findByEmail($r->EMAIL);
		if (!$user){
			return response()->json(['error' => 'Not Found.'], 404);
		}
		
		//wrong old password
		else if (!\Hash::check($r->PWD_OLD, $user->password)){
			return response()->json(['error' => 'Unauthorized.'], 401);
		}
		
		//wrong new password and confirm password
		else if (
			strlen($r->PWD_NEW) <= 0 || 
			strlen($r->PWD_CONFIRM) <= 0 ||
			$r->PWD_NEW != $r->PWD_CONFIRM
			){
			return response()->json(['error' => 'Not Acceptable.'], 406);
		}
		
		//from here, assume credentials valid
		else{
			\Artisan::call('kosan-user:change-password', [
				'email' 	  	=> strtolower($user->email),
				'newPassword'	=> $r->PWD_NEW,
			]);
			
			return response()->json([], 200);
		}
	}
}
