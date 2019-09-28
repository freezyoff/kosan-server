<?php

namespace App\Console\Commands\Kosan\Migrations;

use Illuminate\Console\Command;
use Config;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-migrate:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install database schema';

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
			$this->call('migrate', array('--database' => $name, '--path' => 'database/migrations/' . $name));
		}
    }
}
