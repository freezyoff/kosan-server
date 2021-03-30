<?php

namespace App\Console\Commands\Kosan\user;

use Illuminate\Console\Command;
use App\Kosan\Models\User;

class Register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-user:register {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new User';

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
		$name = $this->argument('name');
		$email = $this->argument('email');
		$password = $this->argument('password');
		
        $user = new User();
		$user->name = $name;
		$user->email = $email;
		$user->password = $this->argument('password');
		$user->email_verified_at = now();
		$user->save();
		
		\Artisan::call('mosquitto:add-user', [
			'user' 	  => strtolower($user->email),
			'pwd' 	  => $password
		]);
		
		\Artisan::call('mosquitto:reload', []);
		
    }
}
