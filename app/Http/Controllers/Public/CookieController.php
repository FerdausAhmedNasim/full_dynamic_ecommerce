<?php

namespace App\Http\Controllers\Public;

use Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public function setCookie()
    {
        $response = response('Test Cookie');
        // $response->withCookie(cookie('cookie_content', Str::uuid(), 1));
        Cookie::queue(Cookie::make('cookie_content', Str::uuid(), 1));

        return redirect()->back();
    }

    public function getCookie()
    {
        return request()->cookie('cookie_content');
    }

    public function deleteCookie()
    {
        Cookie::queue(Cookie::forget('cookie_content'));

        return redirect()->route('public.home');
    }
}
