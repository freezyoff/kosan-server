<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChipsetOS extends Model
{
    protected $table = "chipset_os";
	
	protected $fillable = [
		"chipset_id",
		"version",
		"firmware_size",
		"firmware_hash",
		"firmware_bin",
		"filesystem_size",
		"filesystem_hash",
		"filesystem_bin"
	];
	
	protected $protected = [
		"firmware_bin",
		"filesystem_bin"
	];
	
	private const TYPE_FIRMWARE = 0;
	private const TYPE_FILESYSTEM = 100;
	
	public function chipset(){
		return $this->belongsTo("App\Models\Chipset", "chipset_id", "id");
	}
	
	public function download($mode){
		$filename = 'update/'. md5(\Illuminate\Support\Str::random(16)).'.bin';
		
		if ($mode == self::TYPE_FILESYSTEM){
			$fileContent = $this->filesystem_bin;
		}
		else{
			$fileContent = $this->firmware_bin;
		}
		
		if ($fileContent){
			\Storage::put($filename, $fileContent);
			$headers = [ "version-hash" => $this->firmware_hash ];
			return response()->download(
					storage_path("app/$filename"), 
					$this->version.'.bin', $headers
				)->deleteFileAfterSend();
		}
		
		return false;
	}
	
	public static function latest($chipset_id){
		return self::where("chipset_id", $chipset_id)->orderBy("created_at", "desc")->first();
	}
}
