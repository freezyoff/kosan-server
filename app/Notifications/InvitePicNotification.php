<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Location;

class InvitePicNotification extends Notification
{
    use Queueable;

	protected $vars = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($locationID, $picName, $picEmail)
    {
		$this->vars = [
			"locationID"=> $locationID,
			"picName"=> $picName,
			"picEmail"=> $picEmail
		];
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
		//find location name 
		$this->vars["location"] = Location::find($this->vars["locationID"]);
        return (new MailMessage)->markdown('notifications.email.invite_pic', $this->vars);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->vars;
    }
}
