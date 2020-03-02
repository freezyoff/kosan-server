<?php

namespace App\Console\Commands\Mosquitto;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Str;

class Reload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload Mosquitto Server Service';

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
        $cmd = "su -c 'systemctl reload mosquitto' < ?";
		$cmd = Str::replaceArray('?', [config("kosan.sudoer_password_file")], $cmd);
		
		$process = new Process( $cmd );
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
    }
}
