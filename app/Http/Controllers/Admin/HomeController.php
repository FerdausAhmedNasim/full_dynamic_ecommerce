<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\HomeService;

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

        return view('admin.pages.home.dashboard', $data);
    }
}
