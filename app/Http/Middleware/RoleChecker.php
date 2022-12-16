<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DataFalseResource;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = Auth::check() ? Auth::user()->roles : '';
        if (trim($roles) == trim($role)) {
            return $next($request);
        }
        return new DataFalseResource(trans('messages.auth.permission_not_grant'), config('constants.validation_codes.unauthorized'));
    }
}
