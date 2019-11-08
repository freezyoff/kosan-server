<?php

namespace App\Http\Controllers\Services\API;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kosan\Service\AuthService;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function userLogin(Request $request){
		$response = [
			'api_token'=>"",
			'api_token_expired'=>""
		];
		$logged_in = false;
		
		if ($request->has("api_token")){
			$credentials = $request->only('api_token');
			$logged_in = AuthService::userLoginWithAPIToken($credentials);
		}
		else if ($request->has(["email", "password"])){
			$credentials = request()->only(['email','password']);
			$logged_in = AuthService::userLogin($credentials);
		}
		
		if ($logged_in){
			$user = Auth::user();
			return response()->json($user->toAndroidGson(), 200);
		}
		
		return response()->json([], 404);
	}
	
	public function userLogout(){
		AuthService::userLogout(Auth::user());
		return response()->json([], 200);
	}
}
