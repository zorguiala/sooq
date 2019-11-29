<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Protocol;

class AdWillExpireSoon extends Notification
{
    use Queueable;

    private $ad_id = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ad)
    {
        $this->ad_id = $ad;
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
        // Generate URL
        $url = Protocol::home().'/account/ads/upgrade/'.$this->ad_id;

        return (new MailMessage)
                    ->subject('Your ad will expire soon.')
                    ->line('One of your ads will expire soon.')
                    ->line('Upgrade now and get full features.')
                    ->action('Upgrade Ad', $url)
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
