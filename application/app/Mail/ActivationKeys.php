<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Protocol;

class ActivationKeys extends Mailable
{
    use Queueable, SerializesModels;

    public $_activation_key = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activation_key)
    {
        $this->_activation_key = $activation_key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Get Activation code
        $code        = Protocol::home().'/auth/activation?key='.$this->_activation_key;
        $logo        = Protocol::home().'/application/public/uploads/settings/logo/logo.png';
        $css         = null;
        $unsubscribe = null;
        
        // Send data
        $data        = array(
            'code'        => $code, 
            'unsubscribe' => $unsubscribe, 
            'logo'        => $logo, 
            'css'         => $css, 
        );

        return $this->subject('Everest Activation Key')->view('emails.activation')->with($data);
    }
}
