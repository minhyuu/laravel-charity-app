<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleBaseProjectFilter
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
        $user = Auth::user();

        if ($user && $user->role !== 'Manager') {
            if ($user->role == 'Administrator' && $user->category == 'Health') {
                $request->merge(['category' => 'Health']);
            } elseif ($user->role == 'Administrator' && $user->category == 'Environment') {
                $request->merge(['category' => 'Environment']);
            } elseif ($user->role == 'Administrator' && $user->category == 'Education') {
                $request->merge(['category' => 'Education']);
            }
        }
        return $next($request); 
    }
}
