<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table    = 'reviews';
	
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
    	'ad_id',
        'user_id',
    	'store_id',
    	'comment',
    	'rating',
    	'is_approved',
    ];
}
