<?php

namespace App\Http\Controllers\Public\Auth;

use App\Http\Controllers\Controller;
use App\Library\Enum;
use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callBack()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();

            if(!$user) {
                $new_user = User::create([
                    'first_name' => $google_user->getName(),
                    'email'      => $google_user->getEmail(),
                    'phone'      => mt_rand(1000000000, 9999999999),
                    'password'   => 12345678,
                    'user_type'  => Enum::USER_TYPE_CUSTOMER,
                ]);

                Auth::login($new_user);

                return redirect()->intended('dashboard');
            } else {
                Auth::login($user);

                return redirect()->intended('dashboard');
            }

        } catch(\Throwable $th) {
            logger($th);
        }

    }
}
