<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{

    protected $table = 'card_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'payment_id', 
        'balance_transaction', 
        'card_number',
        'exp_month',
        'exp_year',
        'last_four',
        'brand',
        'country',
        'amount',
        'currency',
        'is_accepted',
        'ends_at',
    ];

}
