<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Str;
use Storage;

use App\Kosan\Models\Device;
use App\Kosan\Models\Location;
use App\Kosan\Models\Relations\AccessControl;

use App\Kosan\Services\Kosan\DeviceService;


class DevicesController extends Controller{
	
	public function getDeviceListener($targetDeviceMacHash = false){
		$emailHash = md5(Auth::user()->email);
		$topic = "kosan/owner/?/device/?/state/?";
		$subscribes = [];
		if ($targetDeviceMacHash){
			$device = Device::findByMacHash($targetDeviceMacHash);
			if ($device){				
				$subscribes[] = Str::replaceArray("?", [$emailHash, md5($device->mac), "+"], $topic);
			}
		}
		else{
			foreach(Auth::user()->devices()->get() as $device){
				$subscribes[] = Str::replaceArray("?", [$emailHash, md5($device->mac), "os"], $topic);
			}
		}
		
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
			'subscribes'=>	$subscribes
		]);
	}
	
    public function landing(Request $request){
		$viewData = [];
		$viewData['devices'] = Auth::user()->devices();
		
		$locationFilter = $request->get("location");
		if ($locationFilter){
			$locationRecord = Location::findByHash($locationFilter);
			$viewData['location'] = $locationRecord->name;
			$viewData['devices']->where('location_id', $locationRecord->id);
		}
		
		//render
		return view("owner.material-dashboard.devices", $viewData);
	}
	
	public function device($macHash){
		$device = Device::findByMacHash($macHash);
		if (!$device) abort(404);
		return view("owner.material-dashboard.device-detail",[
			'device'=>$device
		]);
	}
	
	public function devicePost(Request $req){
		$device = Device::findByMacHash($req->device);
		$type = $req->type;
		switch($type){
			case 'device-alias':
				$device->alias = $req->alias;
				$device->save();
				return redirect(url()->current());
		}
		
		return $type;
	}
	
	public function accessControl($macHash){
		$device = Device::findByMacHash($macHash);
		
		//check if device already have access controls. 
		//if don't have yet, make it
		if ($device->accessControls()->count() <= 0){
			DeviceService::makeBlankAccessControl($device);
		}
		
		return view("owner.material-dashboard.access-control",[
			"device"=>$device,
			"accessControls"=>$device->accessControls
		]);
	}
	
	public function accessControlChangeName(Request $request){
		//try to find access-control
		$accessCtrl = AccessControl::findByHash($request->input("accessCtrl"));
		DeviceService::changeAccessControlName($accessCtrl, $request->input("name"));
		return redirect()->route("web.owner.access-control", ["macHash"=>$request->input("device")]);
	}
	
	public function accessControlChangeRoom(Request $request){
		$accessCtrl = AccessControl::findByHash($request->input("accessCtrl"));
		DeviceService::changeAccessControlRoom($accessCtrl, $request->input("room"));
		return redirect()->route("web.owner.access-control", ["macHash"=>$request->input("device")]);
	}
	
	public function accessControlDisconnectRoom(Request $request){
		$accessCtrl = AccessControl::findByHash($request->input("accessCtrl"));
		DeviceService::disconnectAccessControlRoom($accessCtrl);
		return redirect()->route("web.owner.access-control", ["macHash"=>$request->input("device")]);
	}
	
	public function accessControlCreateRoom(Request $request){
		$accessCtrl = AccessControl::findByHash($request->input("accessCtrl"));
		DeviceService::createAccessControlRoom($accessCtrl, $request->input("roomAttr"));
		return redirect()->route("web.owner.access-control", ["macHash"=>$request->input("device")]);
	}
}
