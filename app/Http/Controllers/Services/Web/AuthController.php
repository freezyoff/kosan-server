<?php

namespace App\Http\Controllers\Services\Web;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use Hash;
use Str;

use App\Http\Controllers\Controller;
use App\Kosan\Services\Auth\AuthService;
use App\Kosan\Services\Auth\OAuthService;
use App\Kosan\Services\Auth\RegisterService;
use App\Kosan\Services\Auth\ResetPasswordService;
use App\Kosan\Models\Region;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgotPwdRequest;
use App\Kosan\Services\Auth\Requests\ResetPwdRequest;

class AuthController extends Controller{
	use ThrottlesLogins;
	
	public function registerForm($data=[]){
		return view(
			"service.register", 
			array_merge(
				$data,
				[
					"genders"=>config("kosan.genders"),
					"provinces"=>Region::provinces()->get(),
				]
			)
		);
	}
	
	public function register(RegisterRequest $req){
		//flag that user register with google or facebook account
		$viaOauth = Str::contains(url()->previous(), "oauth");
		RegisterService::register($req->all(), $viaOauth);
		return redirect(route("web.my.dashboard"), 301);
	}
	
	public function loginForm(){
		return view('service.login');
	}
	
	public function login(LoginRequest $request){
		if (AuthService::loginHasTooManyAttempts($request)){
			return AuthService::loginSendLockoutResponse($request);
		}
		
		$logged_in = AuthService::login(
			$request->only(['email', 'password'])
		);
		
		//logged in, redirect to dashboard
		if ( $logged_in ){
			AuthService::loginClearAttempts($request);
			return redirect()->route('web.service.redirector');
		}
		
		//assume login failed, check throttle login
		AuthService::loginIncrementAttempts($request);
		return view('service.login');
	}
	
	public function verifyGoogleAccount($googleToken){
		$token = OAuthService::verifyGoogleToken($googleToken);
		if (!$token){
			return abort(401);
		}
		
		//check if google account already registered as kosan user
		if ( OAuthService::isRegisteredUser($token) ){
			return redirect()->route("web.my.dashboard");
		}
		
		return redirect()->route("web.service.oauth.register", [
			"redirectToken" => OAuthService::makeRedirectToken($token)
		]);
	}
	
	public function verifyFacebookAccount($fbToken){
		$token = OAuthService::verifyFacebookToken($fbToken);
		if (!$token){
			return abort(401);
		}
		
		//check if facebook account already registered as kosan user
		if ( OAuthService::isRegisteredUser($token) ){
			return redirect()->route("web.my.dashboard");
		}
		
		return redirect()->route("web.service.oauth.register", [
			"redirectToken" => OAuthService::makeRedirectToken($token)
		]);
	}
	
	public function registerWithRedirectToken($fbRedirectToken){
		$token = OAuthService::resolveRedirectToken($fbRedirectToken);
		if (!$token){
			return abort(401);
		}
		
		//TODO: fix this, pull gender info from google api
		//hack for google api
		//google api not provide gender
		if (!isset($token["gender"])){
			$token["gender"] = "";
		}
		
		return $this->registerForm($token);
	}
	
	public function activation($token){
		if (!RegisterService::activate($token)){
			abort(401);
		}
		
		return view('service.redirector', [
			"target"=> route("web.my.dashboard"),
			"message"=> "Akun telah diaktifkan. Laman akan diarahkan ke Dashboard."
		]);
	}
	
	public function forgotPwdForm(Request $req){
		return view('service.forgotPwd');
	}
	
	public function forgotPwd(ForgotPwdRequest $req){
		ResetPasswordService::makeRequest($req->input('email'));
		return view('service.forgotPwd',['success'=>true]);
	}
	
	public function resetPwdForm($token){
		$email = ResetPasswordService::resolveRequest($token);
		if (!$email){
			abort(404);
		}
		return view('service.resetPwd', [
			"token"=>$token
		]);
	}
	
	public function resetPwd(ResetPwdRequest $req){
		$user = ResetPasswordService::reset($req->token, $req->password);
		if (!$user){
			abort(401);
		}
		
		Auth::login($user);
		return redirect(route("web.my.dashboard"));
	}
	
}