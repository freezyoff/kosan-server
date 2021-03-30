<?php

namespace App\Kosan\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $connection = 'kosan_system';
	protected $table = "user_profiles";
    protected $fillable = [
		'id_number',
		'gender',
		'address_province',
		'address_regency',
		'address_district',
		'address_village',
		'address_address',
		'address_postcode',
		'phone_region',
		'phone_number',
		'picture_profile',
		'picture_idcard'
	];
	
	public static function findByIdNumber($idNumber){
		return self::where("id_number",$idNumber)->first();
	}
	
	public static function findByHash($hash){
		return self::whereRaw("MD5(id) = '$hash'")->first();
	}
	
	//
	// User Relation
	//
	public function user(){
		return $this->belongsTo("App\Kosan\Models\User", "id", "id");
	}
}
