<?php namespace App\Models\User;

trait HasDocs{
	
	public function docs(){
		return $this->hasMany("\App\Models\UserDoc", "user_id", "id");
	}
	
	public function doc_hasAnyVerified(){
		foreach($this->docs()->get() as $doc){
			if ($doc->verified){
				return true;
			}
		}
		
		return false;
	}
}