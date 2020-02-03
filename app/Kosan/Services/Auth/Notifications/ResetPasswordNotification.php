<?php

namespace App\Kosan\Services\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

	/**
     * Credentials to be used in email
     * 	[
	 *		"token"=> reset password token
	 *	]
	 *
     */
	protected $credentials = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->credentials = ['token'=>$token];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
			->subject('Atur Ulang Sandi')
			->markdown('notifications.email.resetPwd', $this->credentials);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'email'=> $this->credentials['email'],
			'url'=> $this->credentials['url']
        ];
    }
}
