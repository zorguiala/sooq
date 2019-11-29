<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'username',
        'title',
        'short_desc',
        'long_desc',
        'category',
        'logo',
        'cover',
        'country',
        'state',
        'city',
        'address',
        'fb_page',
        'tw_page',
        'yt_page',
        'go_page',
        'website',
        'status',
        'ends_at',
    ];
}
