<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Stats extends Model

{



    protected $table = 'stats';



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */
     public $primaryKey  = 'id';

    protected $fillable = [

        'ad_id', 

        'owner', 

        'ip_address', 

        'country',

        'region',

        'city',

        'browserName',

        'browserVersion',

        'platformName',

        'platformVersion',

        'deviceName',

        'isPhone',

        'isDesktop',

        'isRobot',

        'robotName',

        'referrer',

        'referrer_keyword',

        'first_visit',

        'last_visit',

    ];



    public $timestamps = false;

}

