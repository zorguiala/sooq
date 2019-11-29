<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Helper;
use Protocol;

class EmailActivation extends Notification
{
    use Queueable;

    private $key      = '';
    private $username = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($key, $username)
    {
        $this->key      = $key;
        $this->username = $username;
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
        // Get auth settings
        $settings_auth = Helper::settings_auth();

        // Get Verify URL
        $verify_url    = Protocol::home().'/auth/activation?key='.$this->key;

        return (new MailMessage)
                    ->subject('Account Activation')
                    ->line('Hi '.$this->username.', just one more step!')
                    ->line('We just need to to verify your email address to complete your signup.')
                    ->action('Verify Your Email', $verify_url)
                    ->line('Please note that this link will expire in '.$settings_auth->activation_expired_time.' minutes.')
                    ->line('If you have not signed up. Please ignore this email.');
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
