<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Jenssegers\Agent\Agent as Agent;
use Protocol;
use Tracker;

class NewSignIn extends Notification
{
    use Queueable;

    /**
     * Get IP
     */
    private $ip = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
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
        // Get User Agent Info
        $agent            = new Agent;

        // Get Browser Name 
        $browserName      = $agent->browser();

        // Get Browser Version 
        $browserVersion   = $agent->version($browserName);

        // Get Platform Name
        $platformName     = $agent->platform();

        // Get Platform Version
        $platformVersion  = $agent->version($platformName);

        // Get Country Name
        $country          = Tracker::ip($this->ip)->country();

        // Get City Name
        $city             = Tracker::ip($this->ip)->city();

        // Get Region
        $region           = Tracker::ip($this->ip)->region();

        return (new MailMessage)
                    ->subject('New sign-in from '.$country.' on '.$platformName.' '.$platformVersion)
                    ->line('Your '.config('app.name').' Account was just used to sign in from '.$country.' / '.$region.' / '.$city.' on '.$platformName.' '.$platformVersion. ' - '.$browserName.' '.$browserVersion)
                    ->action('Don\'t recognize this activity?', Protocol::home().'/auth/login')
                    ->line('Why are we sending this? We take security very seriously and we want to keep you in the loop on important actions in your account. We were unable to determine whether you have used this browser or device with your account before. This can happen when you sign in for the first time on a new computer, phone or browser, when you use your browser\'s incognito or private browsing mode or clear your cookies, or when somebody else is accessing your account.');
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
