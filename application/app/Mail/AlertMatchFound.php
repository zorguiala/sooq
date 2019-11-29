<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Protocol;

class AlertMatchFound extends Mailable
{
    use Queueable, SerializesModels;

    public $ad_id = "";
    public $title = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ad_id, $title)
    {
        $this->ad_id = $ad_id;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $logo        = Protocol::home().'/application/public/uploads/settings/logo/logo.png';
        $css         = null;
        $unsubscribe = null;
        $ad_id       = $this->ad_id;
        $title       = $this->title;
        $url         = Protocol::home().'/vi/'.$ad_id;
        
        // Send data
        $data        = array(
            'ad_id'       => $ad_id, 
            'url'         => $url, 
        );
        
        return $this->subject('['.config('app.name').'] New alert found - '.$title)->markdown('emails.alert_found')->with($data);
    }
}
