<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Allows multiple roles to be checked.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $user = Auth::user();
    
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->withErrors(['Your account has been disabled.']);
        }
    
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
    
        abort(403, 'Unauthorized action.');
        
        return $next($request);
    }
}
