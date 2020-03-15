<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;

use App\Kosan\Models\Device;


class DevicesController extends Controller{
	
    public function landing(){
		return view("owner.material-dashboard.devices", [
			'devices' => Auth::user()->devices()
		]);
	}
	
	public function landingListener(){
		return response()->json([
			'port'=> 	 9883,//8883,
			'host'=> 	 'mqtt.kosan.co.id',
			'username'=> 'kosan-reloader',//Auth::user()->email,
			'password'=> 'kosan-reloader',//Auth::user()->password,
			'ca'=>		 Storage::get('cert/mqtt.kosan.co.id.crt')
		]);
	}
	
	public function device($macHash){
		$device = Device::findByMacHash($macHash);
		if (!$device) abort(404);
		return view("owner.material-dashboard.device-detail",[
			'device'=>$device,
			'update'=>$device->chipset->latestChipsetOS()
		]);
	}
	
}
