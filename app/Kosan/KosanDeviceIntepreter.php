<?php

namespace App\Kosan;

use App\Models\Device;

class KosanDeviceIntepreter 
{
	public static function config_device($device_uuid, $location_uuid, $api_token, $api_token_expired){
		$str  = "#dv ";
		$str .= strlen($device_uuid)>0? 		"~d=$device_uuid " : "";
		$str .= strlen($location_uuid)>0? 		"~l=$location_uuid " : "";
		$str .= strlen($api_token)>0? 			"~ta=$api_token " : "";
		$str .= strlen($api_token_expired)>0? 	"~te=$api_token_expired" : "";
		
		//@TODO: 
		//compability only, removed after update device version 0.0.5
		if ($api_token || $api_token_expired){
			$str .= "\n";
			$str .= "#rsvr ";
			$str .= strlen($api_token)>0? 			"~ta=$api_token " : "";
			$str .= strlen($api_token_expired)>0? 	"~te=$api_token_expired" : "";			
		}
		
		return $str;
	}
	
	public static function config_server_remote($host, $port){
		$str  = "#rsvr ";
		$str .= strlen($host)>0? 				"~h=$host " : "";
		$str .= strlen($port)>0? 				"~p=$port " : "";
		
		return $str;
	}
	
	public static function config_device_gpio($type, $pin, $mode, $trigger, $target_pin, $target_signal){
		$line  = "#dvio ";
		$line .= strlen($pin)>0? 			"~p=$pin " : "";
		$line .= strlen($type)>0? 			"~y=$type " : "";
		$line .= strlen($mode)>0? 			"~m=$mode " : "";
		$line .= strlen($trigger)>0? 		"~r=$trigger " : "";
		$line .= strlen($target_pin)>0? 	"~tp=$target_pin " : "";
		$line .= strlen($target_signal)>0? 	"~ts=$target_signal" : "";
		
		return $line;
	}
	
	public static function config_device_gpio_collections(Device $device){
		$ENUM = config("kosan.device_io_enum");
		
		//we collect current device io config (@see table device_io).
		$GPIO = [];
		foreach($device->io()->get() as $row){
			
			$GPIO[$row->pin] = self::config_device_gpio(
									$ENUM["type"][$row->type], 
									$row->pin, 
									$ENUM["mode"][$row->mode], 
									$ENUM["signal"][$row->trigger], 
									$row->target_pin,
									$row->target_signal==NULL? 
										null : 
										$ENUM["signal"][$row->target_signal]
								);
			
		}
		
		return implode("\n",$GPIO);
		
	}
}
