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
	
	/**
	 * 	Require Body:
	 *		- mac:	-> device mac address
	 *		- hash:	-> hash
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
			abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			
			//match chipset os with given $hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			
			if (!$osMatch){
				return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
			}
			
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
	 * 	Require Body:
	 *		- mac:		-> device mac address
	 *		- dev_uuid:	-> device uuid (@see #register())
	 *		- loc_uuid:	-> device uuid (@see #register())
	 *		- hash:		-> sketch hash
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address or uuid or hash
	 *		- 500:	-> server error
	 *		- 200:	-> api token ok
	 *		- 201:	-> renew api token
	 *
	 */
	public function auth(){
		$mac 		= request("mac");
		$dev_uuid 	= request("dev_uuid");
		$loc_uuid 	= request("loc_uuid");
		$hash 		= request("hash");
		
		$device = Device::findByCredentials(["mac"=>$mac, "uuid"=>$dev_uuid]);
		if (!$device){ 
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//match location uuid with given $loc_uuid
		if ($device->location()->first()->uuid != $loc_uuid){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			
			//match chipset os with given $hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			
			if (!$osMatch || !$loc_uuid_match){
				return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
			}
			
		}
		
		//mac, uuid, & hash match. Valid Device
		//return api token
		$code = $device->isApiTokenExpired()? 201 : 200;
		$token = $device->apiToken();
		$response = KosanDeviceIntepreter::config_server_remote(false, false, $token["token"], $token["expired"]);
		return KosanDeviceResponse::response($code, $response);
	}
	
	/**
	 * 	Require Body:
	 *		- mac:	-> device mac address
	 *		- dev_uuid:	-> device uuid (@see #register())
	 *		- loc_uuid:	-> device uuid (@see #register())
	 *		- hash:	-> sketch hash
	 *
	 *	HTTP Response:
	 *		- 401:	-> unknown mac address or uuid or hash
	 *		- 500:	-> server error
	 *		- 200:	-> has access request
	 *		- 204:	-> no content or no access request
	 *
	 */
	public function publish(){
		$mac 		= request("mac");
		$dev_uuid 	= request("dev_uuid");
		$loc_uuid 	= request("loc_uuid");
		$hash 		= request("hash");
		
		$device = Device::findByCredentials(["mac"=>$mac, "uuid"=>$dev_uuid]);
		if (!$device || $device->uuid != $dev_uuid){ 
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//match location uuid with given $loc_uuid
		if ($device->location()->first()->uuid != $loc_uuid){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//we check chipset firmware hash when on production
		if (\App::environment("production")){
			
			//match chipset os with given $hash
			$osMatch = $device->chipset()->first()->os()->where("hash", $hash)->first();
			
			if (!$osMatch || !$loc_uuid_match){
				return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
			}
			
		}
		
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
	 * 	Require Body:
	 *		- mac:					-> device mac address
	 *		- dev_uuid:				-> device uuid (@see #register())
	 *		- loc_uuid:				-> device uuid (@see #register())
	 *		- version: 				-> sketch version
	 *		- hash:					-> sketch hash
	 *		- chipset:				-> chipset type ESP8266 & ESP32
	 *		- chipset_free_space:	-> chipset free space
	 *		- 
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
		$mac 		= request("mac");
		$dev_uuid 	= request("dev_uuid");
		$device = Device::findByCredentials(["mac"=>$mac, "uuid"=>$dev_uuid]);
		
		if (!$device || $device->uuid != $dev_uuid){ 
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//match location uuid with given $loc_uuid
		$loc_uuid = request("loc_uuid");
		if (!$device->location()->first() || $device->location()->first()->uuid != $loc_uuid){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//match chipset os with given $hash
		$hash = request("hash");
		$osMatch = $device->chipset()->first()->os()->where("firmware_hash", $hash)->first();	
		if (!$osMatch){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//check chipset: 
		$chipset = request("chipset");
		if (!$osMatch->chipset()->first() || $osMatch->chipset()->first()->name != $chipset){
			return abort(401, \App::environment("production")? "Unauthorized" : "Unknown Device");
		}
		
		//check latest 
		//check chipset_free_space	first
		$chipset_free_space = request("chipset_free_space");
		$latestOS = ChipsetOS::latest($osMatch->chipset_id);
		if ($latestOS->version == request("version") || $latestOS->firmware_hash == $hash){
			//return response(\App::environment("production")? "No Content" : "No Update", 204);
			return abort(204, \App::environment("production")? "No Content" : "No Update");
		}
		
		if ($chipset_free_space < $latestOS->firmware_size){
			return abort(417, \App::environment("production")? "Unauthorized" : "Not Enough Free Space");
		}
		
		//return file 
		$filename = 'update/'. md5(\Illuminate\Support\Str::random(16)).'.bin';
		\Storage::put($filename, $latestOS->firmware_bin);
		$headers = [ "version-hash" => $latestOS->firmware_hash ];
		return response()->download(storage_path("app/$filename"), $latestOS->version.'.bin', $headers)->deleteFileAfterSend();
		//return $downloadPath;
	}
	
}
