<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Kosan\Services\Kosan\LocationService;
use App\Kosan\Services\Kosan\BankService;
use Auth;

class ProfileController extends Controller{
	
    public function landing(){
		//find locations
		
		return view('owner.material-dashboard.profile',[
			'locations'=> LocationService::userLocations(),
			'bankAccounts'=> BankService::getUserAccounts()
		]);
	}
	
	public function changeLocationName(Request $r){
		LocationService::updateByLocationHash($r->location, ['name'=>$r->name]);
		return redirect(url()->previous());
	}
	
	public function addBankAccount(Request $req){
		$account = BankService::makeAccount($req->input('user'), $req->input('acc'));
		return redirect(url()->previous());
	}
	
	public function editBankAccount(Request $req){
		$account = BankService::changeAccount($req->input('acc'));
		return redirect(url()->previous());
	}
	
	public function deleteBankAccount(Request $req){
		$account = BankService::deleteAccount($req->input('id'));
		return redirect(url()->previous());
	}
}
