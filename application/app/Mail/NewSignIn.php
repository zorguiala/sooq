<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tracker;

class NewSignIn extends Mailable
{
    use Queueable, SerializesModels;

    private $_ip = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ip)
    {
        $this->_ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $get_ip = $this->_ip;

        return $this->subject('New sign in from '.Tracker::ip($get_ip)->country())->view('emails.auth.new_signin')->with('get_ip', $get_ip);
    }
}
