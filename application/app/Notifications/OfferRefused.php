<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;
use Protocol;

class OfferRefused extends Notification
{
    use Queueable;

    /**
     * Get Offer ID
     */
    protected $offer_id = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer_id)
    {
        $this->offer_id = $offer_id;
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
        // Get Offer
        $offer = DB::table('offers')->where('id', $this->offer_id)->first();

        $url   = Protocol::home().'/vi/'.$offer->ad_id;

        return (new MailMessage)
                    ->subject('Your offer has been refused.')
                    ->line('Your recent offer for #'.$offer->ad_id.' has been refused.')
                    ->action('View Ad', $url)
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
