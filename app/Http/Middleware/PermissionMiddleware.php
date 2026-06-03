<?php

namespace App\Http\Middleware;

use Closure;
use App\Library\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard()->user();

        if(($user->user_type == Enum::USER_TYPE_SUPER_ADMIN || 
        $user->user_type == Enum::USER_TYPE_ADMIN || 
        // $user->user_type == Enum::USER_TYPE_SELLER ||
        $user->user_type == Enum::USER_TYPE_EMPLOYEE
        // || $user->user_type == Enum::USER_TYPE_MODERATOR
        ) && $user->can($permission)) {
            return $next($request);
        }

        abort(403, 'Permission denied');
    }
}
