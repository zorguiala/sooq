<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayPalPayment extends Model
{

    protected $table = 'paypal_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'payment_id', 
        'token', 
        'payer_id',
        'amount',
        'is_accepted',
        'ends_at',
    ];

}
