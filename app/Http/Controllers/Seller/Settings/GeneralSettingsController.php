<?php

namespace App\Http\Controllers\Seller\Settings;

use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
    public function index()
    {
        return view('seller.pages.config.general_settings.system_details');
    }

}
