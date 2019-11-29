<?php

namespace App\Notifications\Payments\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Protocol;
use App\User;

class NewAccountPayment extends Notification
{
    use Queueable;

    private $details = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($get_details)
    {
        $this->details = $get_details;
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
        // Check payment Type
        if ($this->details['type'] == 'ad') {
            $payments_details = Protocol::home().'/dashboard/payments/ads';
        }else{
            $payments_details = Protocol::home().'/dashboard/payments/accounts';
        }

        // check payment method
        if ($this->details['method'] == 'credit') {
            $method = 'Credit Card';
        }else{
            $method = 'PayPal';
        }

        // Get User Details
        $user = User::where('id', $this->details['user_id'])->first();

        return (new MailMessage)
                    ->subject('New payment has been received! #'.$this->details['transaction_id'])
                    ->line('You just received new payment via '.$method)
                    ->line($user->username.' upgrade his account')
                    ->action('View Payments', $payments_details);
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
