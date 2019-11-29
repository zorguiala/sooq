<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Cache;
use Auth;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'first_name', 
        'last_name', 
        'email', 
        'password',
        'avatar',
        'country_code',
        'state',
        'city',
        'gender',
        'phone',
        'phonecode',
        'phone_hidden',
        'account_type',
        'is_admin',
        'is_moderator',
        'status',
        'has_store',
        'facebook_id',
        'twitter_id',
        'google_id',
        'instagram_id',
        'pinterest_id',
        'linkedin_id',
        'vk_id',
        'identifyme_id',
        'is_2fa',
        'last_login_ip',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret', 'api_token'
    ];

    /**
     * Check if user online
     */
    public static function isOnline($id)
    {
        return Cache::has('user-online-'.$id);
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->phonecode.$this->phone;
    }

    public function hasStore()
    {
        return $this->hasOne('App\Models\Store', 'owner_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite', 'user_id', 'id');
    }
    
}
