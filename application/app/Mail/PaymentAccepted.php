<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Protocol;

class PaymentAccepted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        
        // Send data
        $data        = array(
            'unsubscribe' => $unsubscribe, 
            'logo'        => $logo, 
            'css'         => $css, 
        );

        return $this->view('emails.payments.accepted')->with($data);
    }
}
