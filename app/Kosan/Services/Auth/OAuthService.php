<?php 
namespace App\Kosan\Services\Auth;

use Crypt;
use Str;
use App\Kosan\Models\User;

class OAuthService{
	
	public static function verifyGoogleToken($googleAccountToken){
		$client = new \Google_Client(['client_id' => env("GOOGLE_CLIENT_ID")]);
		$payload = $client->verifyIdToken( $googleAccountToken );
		
		if (!$payload || $payload["aud"] !== env("GOOGLE_CLIENT_ID")){
			return false;
		}
		
		return $payload;
	}
	
	public static function verifyFacebookToken($token){
		$fb = new \Facebook\Facebook([
			'app_id' => env("FACEBOOK_APP_ID"),
			'app_secret' => env("FACEBOOK_APP_SECRET"),
			'default_graph_version' => 'v5.0',
			'default_access_token' => $token,
		]);
		
		$helper = $fb->getJavaScriptHelper();
		
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  $accessToken = false;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  $accessToken = false;
		}

		if (!$accessToken) {
		  return false;
		}
		
		$response = $fb->get('/me?fields=id,picture.width(100),first_name,middle_name,last_name,gender,email', $accessToken);
		$fbuser = $response->getGraphUser();
		return [
			"picture"=>$fbuser->getPicture()->getUrl(),
			"email"=>$fbuser->getEmail(),
			"name"=>$fbuser->getFirstName() ." ". $fbuser->getMiddleName() ." ". $fbuser->getLastName(),
			"gender"=>$fbuser->getGender()
		];
	}
	
	public static function makeRedirectToken($payload){
		return Crypt::encrypt( json_encode($payload) );
	}
	
	public static function resolveRedirectToken($token){
		return json_decode( Crypt::decrypt($token), true );
	}
	
	public static function isRegisteredUser($json){
		return User::findByEmail($json["email"])? true : false;
	}
	
}