<?php

namespace App\Http\Controllers\My\Web;

use Illuminate\Http\Request;
use Auth;
use Str;
use Storage;

use App\Http\Controllers\Controller;
use App\Kosan\Models\Location;
use App\Kosan\Models\Room;

class DashboardController extends Controller{
	
	public function landing(){
		$locationId = request('l');
		$roomId = request('r');
		
		//check locationId if provided
		if (strlen($locationId) > 0 && !Location::find2($locationId)){
			abort(404);
		}
		
		//check roomId if provided
		if (strlen($roomId) > 0 && !Room::find2($roomId)){
			abort(404);
		}
		
		return view("my.material-dashboard.dashboard",[
			'selectedLocationId'=> 	$locationId,
			'selectedRoomId'=> 		$roomId,
			'user'=>				Auth::user()
		]);
	}
	
	public function getMqttListener($roomIdHash){
	
		$topics = [
			//"kosan/user/<email-md5>/room/<roomid-md5>"
			"kosan/user/?/room/?",
			
			//"kosan/user/<email-md5>/room/<roomid-md5>/command/executed"
			"kosan/user/?/room/?/command/executed",
			
			//"kosan/user/<email-md5>/room/<roomid-md5>/command"
			"kosan/user/?/room/?/command"
		];
		$subscribes = [
			Str::replaceArray("?", [md5(Auth::user()->email), $roomIdHash.""], $topics[0]),
			Str::replaceArray("?", [md5(Auth::user()->email), $roomIdHash.""], $topics[1])
		];
		$publishes = [
			Str::replaceArray("?", [md5(Auth::user()->email), $roomIdHash.""], $topics[2]),
		];
		
		//for security, we use api_token as password
		Auth::user()->renewApiToken();
		$websocket_username = strtolower(Auth::user()->email).'@websocket';
		$websocket_password = Auth::user()->api_token;
		
		//change password in mosquitto passwd file before http response
		\Artisan::call('mosquitto:add-user', [
			'user' 	  => $websocket_username,
			'pwd' 	  => $websocket_password
		]);
		
		return response()->json([
			'port'=> 	 	9883,
			'host'=> 	 	'mqtt.kosan.co.id',
			'username'=> 	$websocket_username,
			'password'=> 	$websocket_password,
			'ca'=>		 	Storage::get('cert/SHA-2.Root.USERTrust.RSA.CA.crt'),
			'subscribes'=>	$subscribes,
			'publishes'=>	$publishes,
		]);
	}
	
}
