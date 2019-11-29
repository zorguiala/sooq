<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Protocol;

class PasswordReminder extends Notification
{
    use Queueable;

    private $token = '';
    private $email = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
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
        // Generate Link
        $url = htmlspecialchars_decode(Protocol::home().'/auth/password/update?token='.$this->token.'&email='.$this->email);

        return (new MailMessage)
                    ->subject('Password Reminder')
                    ->line('Someone requested that the password be reset for that account.')
                    ->line('If this was a mistake, just ingore this email and nothing will happen.')
                    ->line('To reset your password, visit the following address.')
                    ->action('Reset your password', $url)
                    ->line('Have a great day!');
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
