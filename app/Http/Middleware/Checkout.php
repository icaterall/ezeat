<?php

namespace App\Http\Middleware;

use Closure;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (1 == auth()->user()->status) {
            return $next($request);
        }

        return redirect()->intended('verify_account')->withSuccess('Please verify your mobile number to continue');
    }
}
