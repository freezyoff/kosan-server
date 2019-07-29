<?php 
namespace App\Kosan;

class KosanDeviceResponse{
	public static function render($exception){
		return response($exception->getMessage(), $exception->getStatusCode())
			->header("Content-Type", "text/plain");
	}
}