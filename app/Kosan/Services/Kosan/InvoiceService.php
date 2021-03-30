<?php

namespace App\Kosan\Services\Kosan;

use Illuminate\Http\Request;
use Auth;
use Str;
use Storage;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

use App\Kosan\Models\Invoice;

class InvoiceService {
	
	protected static function make($type, $infos){
		$invoice = false;
		
		//Room Invoice
		if ($type == 'room'){
			$time = now();
			$invoice = Invoice::create([
				'biller_user_id'	=> $infos['biller_user_id'],
				'issue_date'		=> $time,
				"due_date"			=> $time, 
				
				//TODO: harusnya ditentukan oleh pemilik kosan
				"grace_periode"		=> 30, 
			]);
			
			$invoice->roomDetails()->create([
				"invoice_id" 	=> $invoice->id,
				"room_id"		=> $infos['room_id'],
				"start"			=> $infos['start'], 
				"end"			=> $infos['end'], 
				"grace_periode" => $infos['grace_periode'], 
				"ammount"		=> $infos['ammount'],
				"tax"			=> $infos['tax'],
				"discount"		=> $infos['discount']
			]);
		}
		
		//Device Invoice
		else if ($type == 'device'){
			
		}
		return $invoice;
	}
	
	public static function makeRoomInvoice($infos){
		return self::make("room", $infos);
	}
	
	public static function clearObseleteInvoiceFiles(){
		$maxL = now();
		$path = config('kosan.invoice.storage.path');
		$files = Storage::allfiles($path);
		foreach($files as $f){
			$crL = Carbon::createFromTimestamp(explode("/",$f)[1]);
			if ($crL->lessThan($maxL)){
				Storage::delete($f);
			}
		}
	}
	
	public static function makeProformaInvoice($format){
		self::clearObseleteInvoiceFiles();
		$filepath = storage_path('app/invoices/'.now()->timestamp);
		Browsershot::url(route('web.owner.generate'))
			->showBackground()
			->useCookies($_COOKIE)
			->format($format)
			->waitUntilNetworkIdle()
			->savePdf($filepath);
		return $filepath;
	}
}