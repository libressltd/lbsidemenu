<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class DPRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user())
        {
            return view("errors.503");
        }

        if (!Auth::user()->hasRole($role))
        {
            return view("errors.503");
        }
        return $next($request);
    }
}
