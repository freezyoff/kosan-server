<?php 
namespace App\Kosan\Service;

use Auth;
use Hash;
use Notification;
use Str;
use App\Models\User;
use App\Models\Location;
use App\Kosan\Service\RegisterService;
use App\Notifications\InvitePicNotification;

class PicService{
	
	/**
	 * check if pic registered
	 */
	public static function _getUser($email){
		$user = User::where('email', $email)->first();
		if ($user) return $user;
		return false;
	}
	
	public static function invite($locationID, $name, $email){
		//1. check if registered
		$user = self::_getUser($email);
		if (!$user){
			// register user
			RegisterService::register([
				"name"=>$name,
				"email"=>$email,
				"password"=>Str::random(8),
				"email_verified_at"=>now(),
			]);
		}
		
		//2. set pic 
		$user = self::_getUser($email);
		$location = Location::find($locationID);
		$location->pic_user_id = $user->id;
		$location->save();
		
		//3. send notification
		$user->notify(
			new InvitePicNotification(
				$locationID, 
				$user->name, 
				$user->email
			)
		);
		echo "Notifying!";
		exit;
	}
	
}