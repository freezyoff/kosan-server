<?php 
namespace App\Kosan\Models\Contracts;

trait FindByPlainOrHashIdentifier {
	
	public static function find2($idPlainOrHash){
		return self::whereRaw("MD5(`id`) = '$idPlainOrHash' or `id` = '$idPlainOrHash'")->first();
	}
	
	public static function findByHash($hash){
		return self::whereRaw("MD5(`id`) = '$hash'")->first();
	}
}