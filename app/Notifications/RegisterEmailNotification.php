<?php

namespace App\Notifications;

use App\Kosan\Services\Auth\Notifications\RegisterEmailNotification as Base;

class RegisterEmailNotification extends Base {
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($credentials)
    {
        parent::__construct($credentials);
    }
}
