<?php

namespace App\Http\Middleware;

use Closure;
use App\Library\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class RoleMiddleware
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
        $guard = Auth::guard();
        if ($guard->check() && $guard->user()->user_type != Enum::USER_TYPE_SUPER_ADMIN && $guard->user()->status != Enum::USER_STATUS_ACTIVE) {
            $this->logoutAndThrowValidationException(true);
        }

        if ($this->userHasPermission($guard, $role)) {
            $this->setRolePermissions($guard);
            return $next($request);
        } elseif ($guard->check()) {
            $this->logoutAndThrowValidationException();
        } else {
            return $this->redirectToLogin($role);
        }
    }

    private function userHasPermission($guard, $role)
    {
        if ($guard->check() && (
            $guard->user()->user_type === $role ||
            (($guard->user()->user_type === Enum::USER_TYPE_SUPER_ADMIN || $guard->user()->user_type === Enum::USER_TYPE_EMPLOYEE) && $role == 'admin' || ($guard->user()->user_type === Enum::USER_TYPE_MODERATOR && $role == 'seller'))
        )) {
            return true;
        }

        return false;
    }

    private function setRolePermissions($guard)
    {
        $permissions = $this->getUserPermissions($guard);
        
        Config::set('auth.role_permissions', $permissions);
    }

    private function getUserPermissions($guard)
    {
        $data = [];

        foreach ($guard->user()->roles as $item) {
            $data[] = $item->permissions()->pluck('slug')->toArray();
        }

        return array_merge(...$data);
    }

    private function logoutAndThrowValidationException($inActive = false)
    {
        Auth::logout();

        if ($inActive) {
            throw ValidationException::withMessages([
                'inactive' => ['Inactive User.'],
            ]);

            return;
        }

        throw ValidationException::withMessages([
            'wrong_portal' => ['The provided credentials are incorrect.'],
        ]);
    }

    private function redirectToLogin($role)
    {
        $routeName = 'admin.login';

        return redirect()->route($routeName);
    }
}
