<?php

namespace App\Console\Commands\Kosan\Device;

use Illuminate\Console\Command;
use App\Kosan\Models\Device;

class Replace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-device:replace {targetMac} {newMac}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace target Kosan Device (by MAC) with New one';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $targetMac = $email = $this->argument('targetMac');
		$targetMacHash = md5($email = $this->argument('targetMac'));
		
		$newMac = $email = $this->argument('newMac');
		
		$cDevice = Device::findByMacHash($targetMacHash);
		if (!$cDevice){
			$this->info('Device not found.');
		}
		
		//remove mosquitto user
		\Artisan::call('mosquitto:remove-user', [
			'user' 	  => str_replace(":","",$targetMac)
		]);
		
		\Artisan::call('mosquitto:add-user', [
			'user' 	  => str_replace(":","",$newMac),
			'pwd' 	  => $cDevice->uuid
		]);
		
		//set target mac to new mac
		$cDevice->mac = $newMac;
		$cDevice->save();
		
		
    }
}
