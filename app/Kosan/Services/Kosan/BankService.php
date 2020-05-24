<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;
use Arr;

use App\Kosan\Models\User;
use App\Kosan\Models\Bank;
use App\Kosan\Models\BankAccount;

class BankService {
	
	public static function bankCodes($flatten=false){
		$banks = Bank::all();
		$results = [];
		foreach($banks as $b){
			$results[] = $b->code;
		}
		
		return $flatten? implode(",", $results) : $results;
	}
	
	public static function getUserAccounts(){
		$user = Auth::user();
		if ($user){
			return $user->bankAccounts();
		}
		return false;
	}
	
	
	public static function makeAccount($userID, $bankCredentials){
		if (!$userID) return false;
		
		$user = User::findByHash($userID);
		
		//$name, $bankCode, $bankAccount, $bankHolder
		$acc = new BankAccount();
		$acc->owner_user_id = $user->id;
		$acc->fill($bankCredentials);
		$acc->save();
		
		return $acc;
	}
	
	public static function changeAccount($bankCredentials){
		if (!$bankCredentials['id']) return false;
		
		//check if exists in database
		$acc = BankAccount::findByHash($bankCredentials['id']);
		if (!$acc) return false;
		
		$acc->fill( Arr::except($bankCredentials, ['id']) );
		$acc->save();
		
		return $acc;
	}
	
	public static function deleteAccount($bankAccountID){
		if (!$bankAccountID) return false;
		
		//check if exists in database
		$acc = BankAccount::findByHash($bankAccountID);
		if (!$acc) return false;
		
		$acc->delete();
		return $acc;
	}
	
}