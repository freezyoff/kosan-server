<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = 'kosan_system';
	protected $table = "regions";
    protected $fillable = [
		"id",
		"country",
		"code",
		"name",
		"parent"
	];
	
	public static function findByName($name){
		return self::where("name", $name)->first();
	}
	
	public function isProvince(){
		return (strlen($this->attributes["code"]) == 2) && 
				(strlen($this->attributes["parent"]) <= 0);
				
	}
	
	public function isRegency(){
		return (strlen($this->attributes["code"]) == 2+2+1) && 
				(strlen($this->attributes["parent"]) == 2);
	}
	
	public function isDistrict(){
		return (strlen($this->attributes["code"]) == 2+2+2+2) && 
				(strlen($this->attributes["parent"]) == 2+2+1);
	}
	
	public function isVillage(){
		return (strlen($this->attributes["code"]) == 2+2+2+4+3) && 
				(strlen($this->attributes["parent"]) == 2+2+2+2);
	}
	
	public static function provinces(){
		return self::where("parent", "");
	}
	
	public function regencies(){
		if ($this->isProvince()){
			return self::where("parent", $this->attributes["code"]);
		}
		return false;
	}
	
	public function districts(){
		if ($this->isRegency()){
			return self::where("parent", $this->attributes["code"]);
		}
		return false;
	}
	
	public function villages(){
		if ($this->isDistrict()){
			return self::where("parent", $this->attributes["code"]);
		}
		return false;
	}
}
