<?php

namespace App\Kosan;

use App\Models\Device;

class KosanDeviceIntepreter 
{
	public static function config_device($device_uuid, $location_uuid){
		$str  = "#device ";
		$str .= strlen($device_uuid)>0? 	"--uuid=$device_uuid " : "";
		$str .= strlen($location_uuid)>0? 	"--loc-uuid=$location_uuid " : "";
		return $str;
	}
	
	public static function config_server_remote($host, $port, $api_token, $api_token_expired){
		$str  = "#server-remote ";
		$str .= strlen($host)>0? 				"--host=$host " : "";
		$str .= strlen($port)>0? 				"--port=$port " : "";
		$str .= strlen($api_token)>0? 			"--api-token=$api_token " : "";
		$str .= strlen($api_token_expired)>0? 	"--api-token-expired=$api_token_expired" : "";
		return $str;
	}
	
	public static function config_device_gpio($type, $pin, $mode, $trigger, $target_pin){
		//
		//	#device-gpio	
		//		--type=			<int, 0=sensor, 1=relay>
		//		--pin=			<int, GPIOPin or NOT_SET>
		//		--mode=			<int, GPIOPinMode or NOT_SET>
		//		--trigger=		<int, signal LOW/HIGH/NOT_SET>
		//		--target_pin=	<int, target GPIOPin or NOT_SET>
		$line  = "#device-gpio ";
		$line .= strlen($type)>0? "--type=$type " : "";
		$line .= strlen($pin)>0? "--pin=$pin " : "";
		$line .= strlen($mode)>0? "--mode=$mode " : "";
		$line .= strlen($trigger)>0? "--trigger=$trigger " : "";
		$line .= strlen($target_pin)>0? "--target_pin=$target_pin" : "";
		return $line;
	}
	
	public static function config_device_gpio_collections(Device $device){
		$ENUM = config("kosan.device_io_enum");
		
		//we collect current device io config (@see table device_io).
		$GPIO = [];
		foreach($device->io()->get() as $row){
			
			$GPIO[$row->pin] = self::config_device_gpio(
									$row->pin, 
									$ENUM["type"][$row->type], 
									$ENUM["mode"][$row->mode], 
									$ENUM["trigger"][$row->trigger], 
									$row->target_pin
								);
			
		}
		
		return implode("\n",$GPIO);
		
	}
}
