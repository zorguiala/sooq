<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'followers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'store',
    	'followed_by'
    ];

}
