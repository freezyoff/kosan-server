<?php

namespace App\Http\Controllers\v01;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;

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
			
		$token = $device->apiToken();
		$response .= "\n";
		$response .= KosanDeviceIntepreter::config_server_remote(false, false, $token["token"], $token["expired"]);
		
		
		return $response;
	}
	
	public function auth(){}
	
	public function publish(){}
	
	public function update(){}
	
}
