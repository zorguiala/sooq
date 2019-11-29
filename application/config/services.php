<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'nexmo' => [
        'key'      => '',
        'secret'   => '',
        'sms_from' => '',
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    '2checkout' => [
        'seller_id'       => '',
        'publishable_Key' => '',
        'private_key'     => '',
        'currency'        => 'USD',
        'account_price'   => '2.50',
        'ad_price'        => '0.70'
    ],

    'facebook' => [
        'client_id'     => '712001885657930',
        'client_secret' => 'a9589786f130c2273f54ce854b2f2a65',
        'redirect'      => 'https://sooqwatheq.co/auth/facebook/callback',
    ],

    'twitter' => [
        'client_id'     => '',
        'client_secret' => '',
        'redirect'      => 'https://sooqwatheq.co/auth/twitter/callback',
    ],

    'google' => [
        'client_id'     => '718136463722-9toq6fbjei1uumfds04885de9aphls5c.apps.googleusercontent.com',
        'client_secret' => '0x3uP-JkuUSkVCMTegorkECc',
        'redirect'      => 'https://sooqwatheq.co/auth/google/callback',
    ],

    'instagram' => [
        'client_id'     => '30400f46186e42e59ca267b48ef69453',
        'client_secret' => 'e74a376fecee47c78bd63ab2586736e0',
        'redirect'      => 'https://sooqwatheq.co/auth/instagram/callback',  
    ], 

    'pinterest' => [
        'client_id'     => '',
        'client_secret' => '',
        'redirect'      => 'https://sooqwatheq.co/auth/pinterest/callback',  
    ], 

    'linkedin' => [
        'client_id'     => '',
        'client_secret' => '',
        'redirect'      => 'https://sooqwatheq.co/auth/linkedin/callback',  
    ], 

    'vkontakte' => [
        'client_id'     => '',
        'client_secret' => '',
        'redirect'      => 'https://sooqwatheq.co/auth/vk/callback',  
    ], 

    'paypal' => [
        'client_id'     => 'ARAWXCdeJHvxBpl9jrrcaur7UTqE1iILQfpefqQIROercm9nCpMa78YM8FLdmT3nXxQbFeGmU-YYjSoC',
        'secret'        => 'EOPGsc0D9sKii7pp-MzqNv6VIy8pVpLK6E-hfxgbumJTFWSs9LniK5xOtvGOgtKh-BdB-TfXL3a-7zKZ',
        'currency'      => 'USD',
        'account_price' => '1',
        'ad_price'      => '1'
    ],

    'stripe' => [
        'secret'        => '',
        'currency'      => 'USD',
        'account_price' => '1.90',
        'ad_price'      => '0.80'
    ],

    'mollie' => [
        'client_id'     => '',
        'client_secret' => '',
        'redirect'      => 'http://localhost/everest/checkout/mollie/callback',
        'account_price' => '0.30',
        'ad_price'      => '0.04',
        'currency'      => 'EUR'
    ],

    'barion' => [
        'pos_key'       => '',
        'account_price' => '80',
        'ad_price'      => '10',
        'currency'      => 'HUF'
    ],

    'smscru' => [
        'login'  => '',
        'secret' => '',
        'sender' => 'John_Doe'
    ],

    'paytm-wallet' => [
        'env'              => 'local', // values : (local | production)
        'merchant_id'      => '',
        'merchant_key'     => '',
        'merchant_website' => '',
        'channel'          => '',
        'industry_type'    => '',
        'account_price'    => '0.30',
        'ad_price'         => '0.04'
    ],

];
