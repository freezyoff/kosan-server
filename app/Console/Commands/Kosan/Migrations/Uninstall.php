<?php

namespace App\Console\Commands\Kosan\Migrations;

use Illuminate\Console\Command;
use Config;

class Uninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-migrate:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uninstall database migrations';

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
        foreach (Config::get('database.connections') as $name => $details)
		{
			$this->info('Running migration for "' . $name . '"');
			$this->call('migrate:rollback', array('--database' => $name, '--path' => 'database/migrations/' . $name));
		}
    }
}
