<?php

namespace App\Kosan\Supports;

class Str extends \Illuminate\Support\Str{
	
	public static $HTML_ID = [];
	protected static $JS_VAR = [];
	
	public static function htmlId($key = false){
		if (!$key){
			return "";
		}
		
		if (array_key_exists($key, self::$HTML_ID)){
			return self::$HTML_ID[$key];
		}
		else{
			self::$HTML_ID[$key] = "_".self::random(6);
			return self::$HTML_ID[$key];
		}
		
	}
	
	public static function jsVar($key = false){
		if (!$key){
			return "";
		}
		
		if (!isset(self::$JS_VAR[$key])){
			self::$JS_VAR[$key] = "_".self::random(4);
		}
		
		return self::$JS_VAR[$key];
	}
	
}