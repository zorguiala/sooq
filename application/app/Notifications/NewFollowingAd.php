<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ad;
use Protocol;

class NewFollowingAd extends Notification
{
    use Queueable;

    /**
     * Get Store Ad
     */
    private $ad_id = "";

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
        // Get Ad info
        $ad = Ad::where('ad_id', $ad_id)->first();

        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('View Ad', Protocol::home().'/listing/'.$ad->slug)
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
