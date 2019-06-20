
9<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = auth()->user()->hasRole('super_admin');
        if ($roles) {
            return $next($request);
        } else {
            return response()->json('You do not have admin right', 401);
        }

    }
}
