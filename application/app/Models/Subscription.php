<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'plan', 
        'brand', 
        'transaction_id',
        'card_number',
        'exp_year',
        'exp_month',
        'cvv',
        'card_last_four',
        'amount',
        'currency',
        'is_accepted',
        'ends_at',
    ];

}
