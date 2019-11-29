<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Protocol;

class AdDeleted extends Notification
{
    use Queueable;

    private $ad_title = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title)
    {
        $this->ad_title = $title;
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
                    ->subject('Your Ad Has Been Removed.')
                    ->line('One of your ads has been removed.')
                    ->line($this->ad_title)
                    ->line('For more information please contact us.')
                    ->action('Contact us', Protocol::home().'/contact')
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}
