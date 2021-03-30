<?php 

namespace App\Http\Controllers\Services\Web;

use App\Http\Controllers\Controller;
use Auth;

class RedirectorController extends Controller{
	
	public function redirect(){
		//if previous url is redirector, do nothing and just redirect to dashboard
		if (url()->previous() === route("web.service.redirector")){
			return $this->intended( request("url", false) );
		}
		
		$hasOwnedLocations = Auth::user()->hasOwnedLocations();
		$hasRoomSubscriptions = Auth::user()->hasRoomSubscriptions();
		
		//check if user own a location and subscribe rooms
		//we show the options where he wanna go
		if ($hasOwnedLocations && $hasRoomSubscriptions){
			return $this->bridge();
		}
		
		$target = request("url", false);
		
		//user own a location or more, show owner dashboard
		if ($hasOwnedLocations){
			return $this->intended($target? $target : route('web.owner.dashboard'));
		}
		
		//user subcribe rooms, show room dashboard
		else{
			
			//TODO: my.dashboard has no ssl certificate installed
			//return $this->intended($target? $target : route('web.my.dashboard'));
			return $this->intended($target? $target : route('web.my.dashboard'));
		}
	}
	
	public function intended($target){
		return view('service.redirector',[
			"type"=>0,
			"target"=> $target,
			"message"=> request("message", false)
		]);
	}
	
	public function bridge(){
		return view('service.redirector',[
			"type"=>1,
		]);
	}
}