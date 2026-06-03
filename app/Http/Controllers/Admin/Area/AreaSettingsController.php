<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Area\AreaSettingsService;

class AreaSettingsController extends Controller
{

    use ApiResponse;

    private $area_settings_service;

    public function __construct(AreaSettingsService $area_settings_service)
    {
        $this->area_settings_service = $area_settings_service;
    }
    
    // Division Start
    public function division(Request $request)
    {
        if ($request->ajax()) {
            return $this->area_settings_service->divisionDataTable();
        }

        return view('admin.pages.config.area_settings.division');
    }

    public function divisionChangeStatus(Division $division, Request $request)
    {
        $result = $this->area_settings_service->divisionChangeStatus($division);

        if ($result) {
            return redirect()->back()->with('success', $this->area_settings_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->area_settings_service->message);
    }
    // Division End

    // District Start
    public function district(Request $request)
    {
        if ($request->ajax()) {
            return $this->area_settings_service->districtDataTable();
        }

        return view('admin.pages.config.area_settings.district');
    }

    public function districtChangeStatus(District $district, Request $request)
    {
        $result = $this->area_settings_service->districtChangeStatus($district);

        if ($result) {
            return redirect()->back()->with('success', $this->area_settings_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->area_settings_service->message);
    }

    public function districtSuburb(District $district, Request $request)
    {
        $result = $this->area_settings_service->districtSuburbs($district);

        if ($result) {
            return redirect()->back()->with('success', $this->area_settings_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->area_settings_service->message);
    }
    // District End
}
