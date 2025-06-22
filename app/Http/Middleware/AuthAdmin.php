<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
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
        // if (auth()->user()->role == 'Administrator' || (auth()->user()->role == 'Manager')) {
        //     return $next($request);
        // }
        // return redirect('/')->with('message', "You don't have authority to access this page.");

        $user = auth()->user();

        if (!$user) {
            return redirect('/')->with('message', "You don't have authority to access this page.");
        }

        if ($user->role == 'Donator' ) {
            return redirect('/')->with('message', "You don't have authority to access this page.");
        }

        if ($user && ($user->role == 'Administrator' || $user->role == 'Manager')) {
            return $next($request);
        }
    }
}
