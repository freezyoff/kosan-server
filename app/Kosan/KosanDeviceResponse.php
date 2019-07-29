<?php 
namespace App\Kosan;

class KosanDeviceResponse{
	public static function render($exception){
		return response($exception->getMessage(), $exception->getStatusCode())
			->header("Content-Type", "text/plain");
	}
	
	public static function response($code, String $plainText){
		return response($plainText, $code)
			->header("Content-Type", "text/plain");
	}
}