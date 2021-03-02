<?php

/*namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{*/
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    //protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    /*protected $except = [
       // 'stripe/*',
       // 'http://example.com/foo/bar',
        'https://spoongate.com/check_active'
    ];
}*/



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
         'checkout/kiple_check_payment_status/*',
        'checkout/kiple_check_payment_status',
        'checkout_app/kiple_check_payment_status',
        'checkout/check_payment_status/*',

        
        'https://spoongate.com/checkout/check_payment_status',
        'http://127.0.0.1:8000/checkout/check_payment_status',
        'checkout/check_App_payment_status',

        'checkout_check/update_after_payment/*',
        'https://spoongate.com/checkout_check/update_after_payment',
        'http://127.0.0.1:8000/checkout_check/update_after_payment',   

        'kiple_checkout_check/update_after_payment/*',
        'https://spoongate.com/kiple_checkout_check/update_after_payment',
        'http://127.0.0.1:8000/kiple_checkout_check/update_after_payment', 
    ];
}