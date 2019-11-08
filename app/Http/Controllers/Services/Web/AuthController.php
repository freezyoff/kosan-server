<?php

namespace App\Http\Controllers\Services\Web;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\Controller;
use App\Kosan\Service\AuthService;

class AuthController extends Controller{
    
	public function loginForm(){
		return view('services.login');
	}
	
	public function login(Request $request){
		$validatedData = $request->validate([
			'email' => 'bail|required|exists:kosan_system.users,email',
			'password' => 'required',
		]);
		
		$logged_in = AuthService::userLogin(
			$request->only(['email', 'password'])
		);
		if ( $logged_in ){
			return redirect()->route('web.service.redirector');
		}
		
		return redirect()->route('web.service.login');
	}
	
}
