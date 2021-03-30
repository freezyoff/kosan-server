<?php

namespace App\Http\Controllers\Owner\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

use App\Kosan\Services\Kosan\InvoiceService;
use App\Kosan\Models\Invoice;

class InvoicesController extends Controller{

	public function landing(Request $r){
		return view('owner.material-dashboard.invoices', [
			'invoices'=> Invoice::all()
		]);
	}
	
	public function previewPdf(){
		return response()->file(
			InvoiceService::makeProformaInvoice("A4")
		);
	}
	
	public function generate(){
		return view('owner.material-dashboard.invoices');
	}
	
}