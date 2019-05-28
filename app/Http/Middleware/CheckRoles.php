<?php

namespace App\Http\Middleware;

use App\Models\Trust\Role;
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
        $roles = auth()->user()->hasRole(Role::SUPER_ADMIN);
        if ($roles) {
            //dd('ok');
            return $next($request);
        } else {
            return response('You do not have admin right', 400);
        }

    }
}
