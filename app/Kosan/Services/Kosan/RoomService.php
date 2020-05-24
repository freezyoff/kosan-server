<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Kosan\Services\Kosan\UserService;

use App\Kosan\Models\Location;
use App\Kosan\Models\Room;
use App\Kosan\Models\User;
use App\Kosan\Models\Invoice;

class RoomService {
	
	public static function make(Location $location, Array $roomAttr){
		$roomAttr['location_id'] = $location->id;
		
		$room = new Room($roomAttr);
		$room->save();
		
		return $room;
	}
	
	public static function change(Room $room, Array $attr){
		if (!$room){
			return false;
		}
		$room->fill($attr);
		$room->save();
		return true;
	}
	
	public static function lease(Room $room, $userInfo){
		//we required email
		if (!array_key_exists('email', $userInfo){
			return false;
		}
		
		//find user by email
		$user = User::findByEmail($userInfo['email']);
		
		//create user if not registered yet
		if (!$user)}{
			$user = UserService::make($userInfo['name'], $userInfo['email'], Str::random(8));
		}
		
		//create invoice data
		$cdate = now();
		$invoice = new Invoice;
		$invoice->biller_user_id = $user->id;
		$invoice->issue_date = $cdate;
		$invoice->due_date = $cdate;
		$invoice->grace_periode = $cdate->addDays(config('kosan.invoice.grace_periode'));
		$invoice->notes = "";
		$invoice->save();
		
		//notify user
		//TODO:
	}
	
}