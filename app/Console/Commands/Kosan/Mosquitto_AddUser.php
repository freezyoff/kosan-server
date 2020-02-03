<?php

namespace App\Console\Commands\Kosan;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Str;

class Mosquitto_AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan:mqtt-add-user 
							{pwdfile : mqtt pwd file} 
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
		$pwdFile = $this->argument("pwdfile");
		$user = $this->argument("user");
		$pwd = $this->argument("pwd");
		
		$process = new Process( "mosquitto_passwd -b $pwdFile $user $pwd" );
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
    }
}
