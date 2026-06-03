<?php

namespace App\Http\Controllers\Public;

use App\Models\Page;
use App\Library\Enum;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function AboutUs()
    {
        $page = Page::with('languages')->where('link', 'about-us')->first();

        return view('public.pages.about-us.index', [
            'about' => $page->languages[0],
            'page'  => $page,
        ]);
    }

    public function ReturnAndRefundPolicy()
    {
        $page = Page::where('link', Enum::REFUND_POLICY)->first();

        return view('public.pages.return_and_refund.index', [
            "page" => $page
        ]);
    }


    public function show(string $link)
    {
        $page = Page::where('link', $link)->first();

        return view('public.pages.show', [
            "page" => $page
        ]);
    }
}
