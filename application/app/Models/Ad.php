<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    protected $table = 'ads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ad_id', 
        'slug', 
        'user_id', 
        'category', 
        'negotiable',
        'is_used',
        'title',
        'description',
        'country',
        'city',
        'state',
        'price',
        'currency',
        'status',
        'is_new',
        'is_featured',
        'is_archived',
        'photos_number',
        'images_host',
        'youtube',
        'ends_at',
    ];

}
