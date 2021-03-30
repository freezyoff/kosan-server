<?php

namespace App\Console\Commands\Mosquitto;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Str;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:add-user 
							{user : mqtt user name} 
							{pwd : mqtt password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add user to mosquitto server';

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
		/*
		$pwdFile = config("kosan.mqtt_password_file");
		$user = $this->argument("user");
		$pwd = $this->argument("pwd");
		
		$process = new Process( "mosquitto_passwd -b $pwdFile $user $pwd" );
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
		
		$this->call('mosquitto:reload', []);
		*/
		
		$user = $this->argument("user");
		$pwd = $this->argument("pwd");
		
		$cmd = "su -c 'mosquitto_passwd -b ? ? ?' < ?";
		$seed = [
			config("kosan.mqtt_password_file"),
			$user,
			$pwd,
			config("kosan.sudoer_password_file")
		];
		$cmd = Str::replaceArray('?', $seed, $cmd);
		
		$process = new Process( $cmd );
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
		$this->call('mosquitto:reload', []);
    }
}
