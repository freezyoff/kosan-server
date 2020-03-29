<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Str;
use Storage;

use App\Kosan\Models\Device;


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
		
		
		return response()->json([
			'port'=> 	 	9883,//8883,
			'host'=> 	 	'mqtt.kosan.co.id',
			'username'=> 	Auth::user()->email,
			'password'=> 	Auth::user()->created_at->format('Y-m-d H:i:s'),
			'ca'=>		 	Storage::get('cert/mqtt.kosan.co.id.crt'),
			'subscribes'=>	$subscribes
		]);
	}
	
    public function landing(){
		return view("owner.material-dashboard.devices", [
			'devices' => Auth::user()->devices()
		]);
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
}
