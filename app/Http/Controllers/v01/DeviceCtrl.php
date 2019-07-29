<?php

namespace App\Http\Controllers\v01;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\ChipsetOS;

use App\Kosan\KosanDeviceIntepreter;
use App\Kosan\KosanDeviceResponse;

class DeviceCtrl extends Controller
{
	
	/**
	 * 	Require Body:
	 *		- mac:	-> device mac address
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address
	 *		- 500:	-> server error
	 *		- 200:	-> already registered
	 *		- 201:	-> register success
	 *
	 */
    public function register(){
		$mac = request("mac");
		
		$device = Device::findByMac($mac);
		if (!$device){ 
			return abort(401, "Unknown Device");
		}
		
		//determind the http code
		$code = 0;
		if ($device->hasUUID()){
			$code = 200;
		}
		else{
			$device->register();
			$code = 201;
		}
		
		//create response body:
		//	- device_uuid:			-> device uuid 4
		//	- location_uuid:		-> device location uuid 4
		//	- owner_uuid:			-> device owner uuid 4
		//	- api_token:			-> bearer token
		//	- api_token_expired:	-> bearer roken expired
		$dev_location = $device->location()->first();
		$response  = KosanDeviceIntepreter::config_device(
				$device->uuid, 
				$dev_location->uuid, 
				$dev_location->owner()->first()->uuid
			);
		
		$response .= "\n";
		$response .= KosanDeviceIntepreter::config_device_gpio_collections($device);
		
		return $response;
	}
	
	/**
	 * 	Require Body:
	 *		- mac:	-> device mac address
	 *		- uuid:	-> device uuid (@see #register())
	 *		- hash:	-> sketch hash
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address or uuid or hash
	 *		- 500:	-> server error
	 *		- 200:	-> api token ok
	 *		- 201:	-> renew api token
	 *
	 */
	public function auth(){
		$mac = request("mac");
		$uuid = request("uuid");
		$hash = request("hash");
		
		$device = Device::findByCredentials(["mac"=>$mac, "uuid"=>$uuid]);
		if (!$device || $device->uuid != $uuid){ 
			return abort(401, "Unknown Device");
		}
		
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			//find chipset os with given hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			if (!$osMatch){
				return abort(401, "Unknown Device");
			}
		}
		
		//mac, uuid, & hash match. Valid Device
		//return api token
		$token = $device->apiToken();
		$response = KosanDeviceIntepreter::config_server_remote(false, false, $token["token"], $token["expired"]);
		return $response;
	}
	
	public function publish(){
		$mac = request("mac");
		$uuid = request("uuid");
		$hash = request("hash");
		
		$device = Device::findByCredentials(["mac"=>$mac, "uuid"=>$uuid]);
		if (!$device || $device->uuid != $uuid){ 
			return abort(401, "Unknown Device");
		}
		
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			//find chipset os with given hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			if (!$osMatch){
				return abort(401, "Unknown Device");
			}
		}
		
		//publishing
		$device->state = request("state");
		
		//subscribe
		$request = $device->command;
		$device->save();
		
		//get device request
	}
	
	public function update(){}
	
}
