<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
        'category_slug',
        'is_sub',
        'parent_category',
    ];

    public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'category', 'id');
    }
}