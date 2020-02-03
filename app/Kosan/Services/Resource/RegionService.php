<?php 
namespace App\Kosan\Service\Resource;

use App\Kosan\Models\Region;

class RegionService{
	
	public static function provinces(){
		return Region::provinces()->get();
	}
	
	public static function regencies($provinceCode){
		$target = Region::where("code", $provinceCode)->first();
		if ($target && $target->isProvince()){
			return $target->regencies()->get();
		}
		return false;
	}
	
	public static function districts($regencyCode){
		$target = Region::where("code", $regencyCode)->first();
		if ($target && $target->isRegency()){
			return $target->districts()->get();
		}
		return false;
	}
	
	public static function villages($districtCode){
		$target = Region::where("code", $districtCode)->first();
		if ($target && $target->isDistrict()){
			return $target->villages()->get();
		}
		return false;
	}
	
}