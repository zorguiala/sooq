<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Protocol;
use App\Models\Ad;

class SendToFriend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Get Message Details
     */
    protected $details = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Get Details
        $ad_id          = $this->details['ad_id'];
        $senderEmail    = $this->details['senderEmail'];
        $friendEmail    = $this->details['friendEmail'];
        $messageContent = $this->details['messageContent'];
        
        // Get Ad title
        $title          = Ad::where('ad_id', $ad_id)->select('title')->first();
        
        // Generate URL
        $url            = Protocol::home().'/vi/'.$ad_id;
        
        $logo           = Protocol::home().'/application/public/uploads/settings/logo/logo.png';
        $css            = null;
        $unsubscribe    = null;

        return $this->subject($title->title)
                    ->from($senderEmail)
                    ->view('emails.send_to_friend')
                    ->with([
                        'ad_id'          => $ad_id,
                        'senderEmail'    => $senderEmail,
                        'friendEmail'    => $friendEmail,
                        'messageContent' => $messageContent,
                        'url'            => $url,
                        'logo'           => $logo,
                        'css'            => $css,
                        'unsubscribe'    => $unsubscribe,
                    ]);
    }
}
