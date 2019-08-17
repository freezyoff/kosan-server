<?php

namespace App\Http\Controllers\v01;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceShell;
use App\Models\ChipsetOS;

use App\Kosan\KosanDeviceIntepreter;
use App\Kosan\KosanDeviceResponse;

class DeviceCtrl extends Controller
{
	
	private function findDeviceByMac($mac){
		$device = Device::findByMac($mac);
		if (!$device){ 
			abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		return $device;
	}
	
	private function findDeviceByCredentials($dev_mac, $dev_uuid, $loc_uuid){
		$device = Device::findByCredentials($dev_mac, $dev_uuid, $loc_uuid);
		if (!$device){ 
			abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		return $device;
	}
	
	private function findDeviceByApiToken(){
		$device = Device::findByApiToken(request()->bearerToken());
		if (!$device){ 
			abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		return $device;
	}
	
	private function validateDeviceOSHash(Device $device, $hash){
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			
			//match chipset os with given $hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			
			if (!$osMatch){
				abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
			}
			
		}
	}
	
	private function validateDeviceChipset(Device $device, $chipset){
		$dev_chipset = $device->chipset()->first();
		if (!$dev_chipset || $dev_chipset->name != $chipset){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
	}
	
	
	/**
	 * 	HTTP Request Body:
	 *		- mc | mac:		-> device mac address
	 *		- hs | hash:	-> hash
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address
	 *		- 500:	-> server error
	 *		- 200:	-> already registered
	 *		- 201:	-> register success
	 *
	 */
    public function register(){
		//compability for minified version
		//TODO: remove compability if update applied
		$mac = 	request("mc", request("mac"));
		$hash = request("hs", request("hash"));
		
		$device = $this->findDeviceByMac($mac);
		$this->validateDeviceOSHash($device, $hash);
		
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
		//	- api_token:			-> bearer token
		//	- api_token_expired:	-> bearer roken expired
		$dev_location = $device->location()->first();
		$response  = KosanDeviceIntepreter::config_device(
				$device->uuid, 
				$dev_location->uuid
			);
		
		$response .= "\n";
		$response .= KosanDeviceIntepreter::config_device_gpio_collections($device);
		
		return KosanDeviceResponse::response($code, $response);
	}
	
	/**
	 * 	HTTP Request Body:
	 *		- mc | mac:			-> device mac address
	 *		- hs | hash:		-> sketch hash
	 *		- du | dev_uuid:	-> device uuid (@see #register())
	 *		- lu | loc_uuid:	-> device uuid (@see #register())
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address or uuid or hash
	 *		- 500:	-> server error
	 *		- 200:	-> api token ok
	 *		- 201:	-> renew api token
	 *
	 */
	public function auth(){
		//compability for minified version
		//TODO: remove compability if update applied
		$mac 			= request("mc", request("mac"));
		$device_uuid 	= request("du", request("dev_uuid"));
		$location_uuid 	= request("lu", request("loc_uuid"));
		$hash 			= request("hs", "hash");
		
		$device = $this->findDeviceByCredentials($mac, $device_uuid, $location_uuid);
		$this->validateDeviceOSHash($device, $hash);
		
		//mac, uuid, & hash match. Valid Device
		//return api token
		$code = $device->isApiTokenExpired()? 201 : 200;
		$token = $device->apiToken();
		$response = KosanDeviceIntepreter::config_server_remote(false, false, $token["token"], $token["expired"]);
		return KosanDeviceResponse::response($code, $response);
	}
	
	/**
	 * 	HTTP Request Header:
	 *		- bearer_token:	-> device auth api token
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown api token
	 *		- 500:	-> server error
	 *		- 200:	-> has access request
	 *		- 204:	-> no content or no access request
	 *
	 */
	public function publish(){
		$device = $this->findDeviceByApiToken();
		
		//publishing
		//for save time efficiency, we compare the state value
		//if no change, we just touch the updated_at field
		if (request("state") || request("config")){
			
			if($device->state != request("state")){
				$device->state = request("state");
			}
			
			if ($device->config != request("config")){
				$device->config = request("config");
			}
			
			$device->save();
			
		}
		else{
			
			$device->touch();
			
		}
		
		//check if any user accessibility request
		//TODO:
		$accessLines = "";
		
		//check if any owner or admin shell command
		$shellLines = $device->shell_unexecuted();
		
		return KosanDeviceResponse::response(
			strlen($shellLines)>0? 200 : 204, 
			$shellLines
		);
	}
		
	/**
	 * 	HTTP Request Body:
	 *		- v  | version: 			-> sketch version
	 *		- hs | hash:				-> sketch hash
	 *		- cs | chipset:				-> chipset type ESP8266 & ESP32
	 *		- cf | chipset_free_space:	-> chipset free space
	 *		- m  | mode:				-> update mode, 100=filesystem or 0=firmware
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address or uuid or hash
	 *		- 417:	-> chipset free space not enough (update too large)
	 *		- 500:	-> server error
	 *		- 200:	-> has update
	 *		- 204:	-> no content / no update
	 *
	 */
	public function update(){
		//compability for minified version
		//TODO: remove compability if update applied
		$hash 	 			= request("hs", request("hash"));
		$version 			= request("v", request("version"));
		$mode 	 			= request("m", request("mode", false));
		$chipset 			= request("cs", request("chipset"));
		$chipset_free_space = request("cf", request("chipset_free_space"));
		
		$device = $this->findDeviceByApiToken();
		$this->validateDeviceOSHash($device, $hash);
		$this->validateDeviceChipset($device, $chipset );
		
		//check latest
		//check chipset_free_space	first
		$latestOS = ChipsetOS::latest($device->chipset_id);
		if ($latestOS->version == $version || $latestOS->firmware_hash == $hash){
			abort(204, \App::environment("production")? "No Content" : "No Update");
		}
		
		if ($chipset_free_space < $latestOS->firmware_size){
			abort(417, \App::environment("production")? "Unauthorized" : "Not Enough Free Space");
		}
		
		//return file 
		$response = $latestOS->download($mode);
		if (!$response){
			return KosanDeviceResponse::response(204, "");
		}
		
		return $response;
	}
	
}
