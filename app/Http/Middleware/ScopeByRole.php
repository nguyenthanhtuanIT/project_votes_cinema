<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Trust\Role;
use Illuminate\Database\Eloquent\Builder;

class ScopeByRole
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
        $user = currentUser();
        switch (true) {
            case $user->hasRole(Role::SALON_OWNER):
                \App\Models\Salon::addGlobalScope(function (Builder $builder) use ($user) {
                    $builder->whereHas('owners', function ($q) use ($user) {
                        $q->where('salon_owners.user_id', $user->id);
                    });
                });
                \App\Models\Order::addGlobalScope(function (Builder $builder) use ($user) {
                    $ids = $user->salons()->pluck('salon_owners.salon_id');
                    $builder->whereIn('salon_id', $ids);
                });

                return $next($request);
            case $user->hasRole(Role::MEMBER):
                \App\Models\Order::addGlobalScope('user_id', function (Builder $builder) use ($user) {
                    $builder->where('user_id', $user->id);
                });

                return $next($request);
            case $user->hasRole(Role::SUPER_ADMIN):
                return $next($request);
            default:
                \App\Models\Order::addGlobalScope('user_id', function (Builder $builder) {
                    $builder->where('user_id', -1);
                });

                return $next($request);
        }
    }
}
