<?php

namespace App\Http\Controllers\My\Web\Dashboard;

use Auth;
use Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\DeviceAccessibility;
use App\Kosan\Service\PicService;

class DeviceManagerController extends Controller
{
    public function deviceManagerPage(){	
		//generate locations
		$locations = [];
		foreach(Auth::user()->accessibilities()->get() as $acc){
			if ($acc->isExpired()){
				continue;
			}
			$devAcc = $acc->deviceAccessibility()->first();
			$dev	= $devAcc->device()->first();
			$loc   	= $dev->location()->first();
			$locations[$loc->id] = $loc;
		}
		
		// creating custom encrypter
		$key = Str::random(32);
		$newEncrypter = new \Illuminate\Encryption\Encrypter( $key, config( 'app.cipher' ) );
		
		return view('my.dashboard.sm-device-manager', [
			'page'=>'device-manager',
			'locations'=>$locations,
			'items'=> $this->deviceManagerByLocation(),
			'cipher_key'=> $key,
			"topics"=> base64_encode( json_encode([
				"pub_auth"=> $newEncrypter->encrypt( "kosan/user/auth/". Auth::user()->email ."/". Auth::user()->plainPassword() ),
				"sub_auth"=> $newEncrypter->encrypt( "kosan/user/config/". md5(Auth::user()->email) ),
				"sub_state"=> $newEncrypter->encrypt( "kosan/user/<api_token>/owner/<md5_device_uuid>/<md5_device_accessibility_id>/<os|io|config>" ),
			], JSON_HEX_QUOT)),
		]);
	}
	
	public function deviceManagerByLocation($locationID = false){
		$result = "";
		
		// no $locationID provided
		// return all
		if (!$locationID){
			foreach(Auth::user()->ownedLocations()->get() as $location){
				foreach($location->devices()->get() as $device){
					$result .= view('my.dashboard.device-manager.sm-item',[
						'location'=>$location,
						'device'=>$device
					])->render();				
				}
			}
			return $result;
		}
		
		foreach(Auth::user()->ownedLocations()->get() as $location){
			
			// continue loop if not desired location
			if ($location->id != $locationID){
				continue;
			}
			
			foreach($location->devices()->get() as $device){
				
				$result .= view('my.dashboard.device-manager.sm-item',[
					'location'=>$location,
					'device'=>$device,
				])->render();
			}
		}
		return $result;
	}
	
	public function invitePIC(Request $request){
		PicService::invite($request->locationID, $request->name, $request->email);
	}
}
