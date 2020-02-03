<?php

namespace App\Http\Controllers\My\Web;

use Illuminate\Http\Request;
use Auth;
use Str;

use App\Http\Controllers\Controller;
use App\Models\Location;

class DashboardController extends Controller{
	
	public function accessibilitiesPage(){
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
		
		return view('my.dashboard.sm-accessibilities', [
			'page'=>'accessibilities',
			'locations'=>$locations,
			'cipher_key'=> $key,
			'topics'=> base64_encode(json_encode([
				"pub_auth"=> 				$newEncrypter->encrypt("kosan/user/auth/". Auth::user()->email ."/". Auth::user()->plainPassword()),
				"sub_auth"=> 				$newEncrypter->encrypt("kosan/user/config/". md5(Auth::user()->email)),
				"sub_user_access_state"=> 	$newEncrypter->encrypt("kosan/user/<api_token>/accessibility/<md5_user_accessibility_id>"),
				"pub_access_command"=> 		$newEncrypter->encrypt("kosan/user/<api_token>/accessibility/<md5_user_accessibility_id>/signal/<unsigned_int_signal>"),
			], JSON_HEX_QUOT)),
			'allKeys'=> $this->accessibilitiesByLocation(),
		]);
	}
	
	public function accessibilitiesByLocation($locationID = false){
		// no $locationID provided
		// return all
		if (!$locationID) {
			$result = "";
			foreach(Auth::user()->accessibilities()->get() as $acc){
				$result .= view('my.dashboard.accessibilities.sm-key',[
					'accessibility'=>$acc
				])->render();
			}
			return $result;
		}
		
		$location = Location::find($locationID);
		if (!$location) return "";
			
		//assume has location id
		$result = "";
		foreach(Auth::user()->accessibilities()->get() as $acc){
			if ($acc->isExpired()){
				continue;
			}
			
			$devAcc = $acc->deviceAccessibility()->first();
			$dev	= $devAcc->device()->first();
			$loc   	= $dev->location()->first();
			
			if ($loc->id != $locationID){
				continue;
			}
			
			$result .= view('my.dashboard.accessibilities.sm-key',[
				'accessibility'=>$acc
			])->render();
		}
		
		return $result;
	}
	
	public function settingPage(){
		return view('my.dashboard', [
			'page'=>'setting',
		]);
	}
	
}
