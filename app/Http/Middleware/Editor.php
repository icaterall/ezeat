<?php

namespace App\Http\Middleware;

use Closure;

class Editor
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
        if (auth()->guest()) {
            return redirect()->route('user.login');
        } elseif ((null != auth()->user()->roles()->where('name', 'editor')->first()) and (1 == auth()->user()->status)) {
            return $next($request);
        }

        return redirect()->intended('/')->withSuccess('You do not have access permission');
    }
}
