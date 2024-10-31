<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'bank/*/endpoint',
        'webhook_telegram',
        'paypal/callback',
        'api/vcb/get',
        'nowpayment/callback',
        '/perfectmoney/callback'
    ];
}
