<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class OfferAccepted extends Mailable
{
    use Queueable, SerializesModels;

    private $offer_id = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->offer_id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Get offer
        $offer = DB::table('offers')->where('id', $this->offer_id)->first();

        return $this->subject('Offer Accepted')->view('emails.offers.accept')->with('offer', $offer);
    }
}
