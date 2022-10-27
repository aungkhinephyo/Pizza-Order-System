<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $current_url = url()->current();
        $login_url = route('auth#loginPage');
        $register_url = route('auth#registerPage');

        if (!empty(Auth::user())) {

            if ($current_url == $login_url || $current_url == $register_url) {
                return back();
            }
        }

        return $next($request);
    }
}
