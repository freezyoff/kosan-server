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
		
		Route::prefix("chipset")
			->group(function() use ($apiVersion){
				
				Route::get("os/add", function() use ($apiVersion){
					return view("$apiVersion.web.test.chipset.os.add",[
						"chipsets"=>\App\Models\Chipset::all()		
					]);
				});
				
				Route::post("os/add", function(\Illuminate\Http\Request $request){
					$keys = [
						"chipset_id"=>$request->input("chipset_id"),
						"version"=>$request->input("version"),
					];
					
					$chipset_os = \App\Models\ChipsetOS::firstOrCreate($keys);
					
					if ($request->hasFile("firmware_bin")){
						$chipset_os->firmware_size = $request->file("firmware_bin")->getSize();
						$chipset_os->firmware_bin = file_get_contents($request->file("firmware_bin")->getRealPath());
						$chipset_os->firmware_hash = md5($chipset_os->firmware_bin);
						$result["firmware"] = [
							"size"=>$chipset_os->firmware_size,
							"hash"=>$chipset_os->firmware_hash,
						];
					}
					
					if ($request->hasFile("spiffs_bin")){
						$chipset_os->filesystem_size = $request->file("spiffs_bin")->getSize();
						$chipset_os->filesystem_bin = file_get_contents($request->file("spiffs_bin")->getRealPath());
						$chipset_os->filesystem_hash = md5($chipset_os->filesystem_bin);
						$result["filesystem"] = [
							"size"=>$chipset_os->filesystem_size,
							"hash"=>$chipset_os->filesystem_hash,
						];
					}
					
					$chipset_os->save();
					return $result;
				});
				
			});
		
		Route::prefix("device")
			->group(function() use ($apiVersion){
				Route::get('monitor', function() use($apiVersion){
					return view("$apiVersion.web.test.device.monitor");
				});
				
				Route::post('monitor', function() use($apiVersion){
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
				
				Route::post('shell', function(){
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
				
				Route::get('button/{mac}/{pin}/{signal}', function($mac, $pin, $signal){
					if ($mac){
						$device = \App\Models\Device::findByMAC($mac);
						if ($device){
							$device->shell_queueCommand(1, "#iotr ~p=$pin ~s=$signal");
							return response()->json(["code"=>200]);
						}
					}
				});
			});		
	});
