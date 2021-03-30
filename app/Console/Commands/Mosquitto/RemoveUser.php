<?php

namespace App\Console\Commands\Mosquitto;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RemoveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:remove-user {user : mqtt user name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove mosquitto user';

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
        $pwdFile = config("kosan.mqtt_password_file");
		$user = $this->argument("user");
		
		$process = new Process( "mosquitto_passwd -D $pwdFile $user" );
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
		
		$this->call('mosquitto:reload', []);
    }
}
