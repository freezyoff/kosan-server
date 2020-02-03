<?php

namespace App\Console\Commands\Kosan;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateRegionTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-system:import-region';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and Import Region Table';

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
		$dir = "/home/admin/kosan/kosan-server-http/resources/python/KemendagriKTP";
		$process = new Process("cd $dir && python $dir/main.py");
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		echo $process->getOutput();
		
    }
}
