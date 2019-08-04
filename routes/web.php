<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$apiVersion = config("kosan.api_version");

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("test")
	->group(function() use ($apiVersion){
		
		Route::get('device/monitor', function() use($apiVersion){
			return view("$apiVersion.web.test.device.monitor");
		});
		
		Route::post('device/monitor', function() use($apiVersion){
			$mac = request('device-mac');
			$json = [];
			if ($mac){
				$device = \App\Models\Device::findByMAC($mac);
				if ($device){
					$json = [
						"state"=> $device->state,
						"config"=> $device->config,
						"lastUpdate"=> \Carbon\Carbon::parse($device->updated_at)->format("Y-m-d H:i:s")
					];
				}
			}
			
			return response()->json($json);
		});
		
		Route::post('device/shell', function(){
			$shellCommand = request("shell");
			$mac = request('device-mac');
			$json = [];
			
			if ($mac){
				$device = \App\Models\Device::findByMAC($mac);
				if ($device){
					$device->shell_queueCommand(1, $shellCommand);
					return response()->json(["code"=>200]);
				}
			}
			return response()->json(["code"=>401, "message"=>"isi Device MAC"]);
		});
		
	});
