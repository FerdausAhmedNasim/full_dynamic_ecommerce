<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\HomeService;

class HomeController extends Controller
{
    use ApiResponse;

    private $home_service;

    public function __construct(HomeService $home_service)
    {
        $this->home_service = $home_service;
    }

    public function dashboard(Request $request)
    {
        $data = $this->home_service->index($request);

        return view('seller.pages.home.dashboard', $data);
    }
}
