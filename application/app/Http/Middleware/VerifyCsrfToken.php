<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'tools/report',
        'tools/report/comment',
        'comments/pin',
        'account/favorite/search/add',
        'account/favorite/ads/add',
        'store/*/follow',
        'checkout/cashu/callback',
        'checkout/cashu/failed',
        'checkout/paytm/callback',
        'checkout/interkassa/callback',
    ];
}
