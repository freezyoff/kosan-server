<?php
namespace App\Kosan\Models\Contracts;

trait DateValidityTrait {
	
	public function isValid(){
		return now()->isBetween($this->valid_after, $this->valid_before);
	}
	
	public function isInGracePeriode(){
		return now()->greaterThan($this->valid_before);
	}
	
}