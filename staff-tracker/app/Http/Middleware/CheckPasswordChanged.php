<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // prevent redirect loops !!
            if (!$request->routeIs('password.change') && !$request->routeIs('password.change.post')) {
                if (is_null(Auth::user()->password_changed_at)) {
                    return redirect()->route('password.change');
                }
            }
        }


        return $next($request);
    }
}
