<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthManager
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
        $user = auth()->user();

        if (!$user) {
            return redirect('/')->with('message', "You don't have authority to access this page.");
        }

        if ($user->role == 'Donator' || $user->role == 'Administrator' ) {
            return redirect('/')->with('message', "You don't have authority to access this page.");
        }

        if ($user && ($user->role == 'Manager')) {
            return $next($request);
        }
    }
}
