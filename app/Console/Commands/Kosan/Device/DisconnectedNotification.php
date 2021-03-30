<?php

namespace App\Console\Commands\Kosan\Device;

use Illuminate\Console\Command;

class DisconnectedNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-notification:device-disconnected';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to owner and pic kosan that device disconnected';

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
        //@TODO: implement this
    }
}
