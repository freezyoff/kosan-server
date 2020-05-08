<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;

use App\Kosan\Services\Kosan\RoomService;

use App\Kosan\Models\Device;
use App\Kosan\Models\Room;
use App\Kosan\Models\Relations\AccessControl;

class DeviceService{
	
	/**
	 *	make access control records with blank room id
	 */
	public static function makeBlankAccessControl(Device $device){
		$usedIO = $device->chipset->used_io/2;
		for($i=0; $i<$usedIO; $i++){
			$acc = new AccessControl();
			$acc->fill([
				"name"=>"Kanal ".($i+1),
				"device_id"=>$device->id,
				"chanel"=>$i+1
			]);
			$acc->save();
		}
	}
	
	public static function changeAccessControlName(AccessControl $accessCtrl, $newName){
		if ($accessCtrl && $newName) {
			$accessCtrl->name = $newName;
			$accessCtrl->save();
			return true;
		}
		return false;
	}
	
	public static function changeAccessControlRoom(AccessControl $accessCtrl, $roomId){
		//try to find room
		$room = Room::findByHash($roomId);
		
		if ($accessCtrl && $room) {
			$accessCtrl->room_id = $room->id;
			$accessCtrl->save();
			return true;
		}
		return false;
	}
	
	public static function createAccessControlRoom(AccessControl $accessCtrl, $roomAttr){
		//make room
		$room = RoomService::make($accessCtrl->device->location, $roomAttr);
		if ($accessCtrl && $room){
			$accessCtrl->room_id = $room->id;
			$accessCtrl->save();
			return true;
		}
		return false;
	}
}