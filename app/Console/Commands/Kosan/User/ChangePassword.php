<?php

namespace App\Console\Commands\Kosan\User;

use Illuminate\Console\Command;
use App\Kosan\Models\User;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kosan-user:change-password {email} {newPassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password';

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
		$email = $this->argument('email');
		$newPassword = $this->argument('newPassword');
        
		//find user with email
		$user = User::where("email", $email)->first();
		if (!$user) {
			$this->error('User not found.');
			return;
		}
		
		$user->password = $newPassword;
		$user->save();
		
		\Artisan::call('mosquitto:add-user', [
			'user' 	  => strtolower($user->email),
			'pwd' 	  => $newPassword
		]);
		
		\Artisan::call('mosquitto:reload', []);
		
		$this->info( md5(strtolower($user->email)) );
		$this->info('Password changed.');
    }
}
