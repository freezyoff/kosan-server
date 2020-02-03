<?php

namespace App\Http\Controllers\Services\Web;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Kosan\Service\Resource\RegionService;

class ResourceRegionController extends Controller{
	
	public function provinces(){
		return response()->json(RegionService::provinces());
	}
	
	public function regencies($provinceCode){
		return response()->json(RegionService::regencies($provinceCode));
	}
	
	public function districts($regencyCode){
		return response()->json(RegionService::districts($regencyCode));
	}
	
	public function villages($districtCode){
		return response()->json(RegionService::villages($districtCode));
	}
	
}