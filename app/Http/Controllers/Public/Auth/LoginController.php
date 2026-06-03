<?php

namespace App\Http\Controllers\Public\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Enum;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (session()->has('product_slug')) {
            session(['url.intended' => session('product_slug')]);
            session()->forget('product_slug');
        }

        if (str_contains(url()->previous(), 'cart')) {
            session(['url.intended' => url()->previous()]);
        }

        return view('public.auth.login');
    }

    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (User::where('phone', $request->phone)->first()?->status == Enum::USER_STATUS_SUSPENDED) {
            throw ValidationException::withMessages([
                $this->username() => 'Your account has been suspended.',
            ]);
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request)
    {
        $user = User::getAuthUser();
        // event(new LoggedEvent(true, $user));

        // Check if there's an intended URL in the session
        if (session()->has('url.intended')) {
            session()->forget('url.intended');

            return redirect()->route('checkout');
        }

        // Fallback to the default redirect path
        return redirect()->intended($this->redirectPath());

    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = (object) $request->only(['phone', 'password']);
        // event(new LoggedEvent(false, $user));

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
