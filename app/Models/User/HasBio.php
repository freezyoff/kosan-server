<?php namespace App\Models\User;

trait HasBio{
	public function bio(){
		return $this->hasOne("\App\Models\UserBio", "user_id", "id");
	}
	
	public function bio_fullname(){
		$bio = $this->bio()->first();
		if ($bio){
			return strtoupper($bio->name_first) ." ". 
					strtoupper($bio->name_middle) ." ". 
					strtoupper($bio->name_last);
		}
		return false;
	}
	
	public function bio_address(){
		$bio = $this->bio()->first();
		if ($bio){
			return $bio->address;
		}
		return false;
	}
	
	public function bio_postcode(){
		$bio = $this->bio()->first();
		if ($bio){
			return $bio->postcode;
		}
		return false;
	}
	
	public function bio_phones(){
		$bio = $this->bio()->first();
		if ($bio){
			return [$bio->phone1, $bio->phone2];
		}
		return false;
	}
}