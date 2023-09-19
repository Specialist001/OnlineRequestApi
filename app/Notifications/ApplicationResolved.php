<?php

namespace App\Notifications;

use App\Models\Application;

class ApplicationResolved extends \Illuminate\Notifications\Notification
{

    /**
     * @param Application $application
     */
    public function __construct(public Application $application)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Request resolved')
            ->line('Your request was resolved by moderator_id: ' . $this->application->moderator_id)
            ->line('Comment: ' . $this->application->comment);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
