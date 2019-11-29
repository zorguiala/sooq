<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Protocol;

class NewComment extends Notification
{
    use Queueable;

    /**
     * Get Ad ID
     */
    private $ad_id = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ad_id)
    {
        $this->ad_id = $ad_id;
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
                    ->subject('You have new comment on #'.$this->ad_id )
                    ->line('You just received new comment on your ad')
                    ->action('Read Comment', Protocol::home().'/vi/'.$this->ad_id)
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
