<?php

namespace App\Http\Controllers\Admin\Advertisement;

use App\Library\Enum;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\AdvertiseLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Advertisement\AdLocationService;
use App\Http\Requests\Admin\Advertisement\Location\StoreRequest;
use App\Http\Requests\Admin\Advertisement\Location\UpdateRequest;

class AdLocationController extends Controller
{
    use ApiResponse;

    private $ad_location_service;

    public function __construct(AdLocationService $ad_location_service)
    {
        $this->ad_location_service = $ad_location_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ad_location_service->dataTable();
        }

        return view('admin.pages.advertisement.location.index');
    }

    public function create(): View
    {
        return view('admin.pages.advertisement.location.create', [
            'locations' => Enum::getAdLocation(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->ad_location_service->store($request->validated());

        if($result) {
            return redirect()->route('admin.ad.location.index')->with('success', $this->ad_location_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_location_service->message);
    }

    public function edit(AdvertiseLocation $ad_location): View
    {
        return view('admin.pages.advertisement.location.edit', [
            'adLocation'    => $ad_location,
            'locations' => Enum::getAdLocation(),
        ]);
    }

    public function update(UpdateRequest $request, AdvertiseLocation $ad_location): RedirectResponse
    {
        $result = $this->ad_location_service->update($ad_location, $request->validated());

        if($result) {
            return redirect()->route('admin.ad.location.index')->with('success', $this->ad_location_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_location_service->message);
    }

    public function destroy(AdvertiseLocation $ad_location): RedirectResponse
    {
        abort_unless($ad_location, 404);

        $result = $this->ad_location_service->delete($ad_location);

        if($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, AdvertiseLocation $ad_location)
    {
        $result = $this->ad_location_service->changeStatus($ad_location);

        if ($result) {
            return redirect()->back()->with('success', $this->ad_location_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_location_service->message);
    }
}
