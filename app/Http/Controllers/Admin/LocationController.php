<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\View\View;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\LocationService;
use App\Http\Requests\Admin\Location\LocationStoreRequest;
use App\Http\Requests\Admin\Location\LocationUpdateRequest;

class LocationController extends Controller
{
    use ApiResponse;

    private $location_service;

    public function __construct(LocationService $location_service)
    {
        $this->location_service = $location_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->location_service->dataTable();
        }

        return view('admin.pages.config.location.index');
    }

    public function showCreateForm(): View
    {
        return view('admin.pages.config.location.create');
    }

    public function create(LocationStoreRequest $request): RedirectResponse
    {
        $result = $this->location_service->create($request->validated());

        if($result) {
            return redirect()->route('admin.config.more_settings.location.index')->with('success', $this->location_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->location_service->message);
    }

    public function showUpdateForm(Location $location)
    {
        abort_unless($location, 404);

        return view('admin.pages.config.location.update', [
            'location' => $location,
        ]);
    }

    public function update(Location $location, LocationUpdateRequest $request)
    {
        abort_unless($location, 404);

        $result = $this->location_service->update($location, $request->validated());

        if($result) {
            return redirect()->route('admin.config.more_settings.location.index')->with('success', $this->location_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->location_service->message);
    }

    public function show(Location $location)
    {
        return Response::success(__('Successfully'), $location);
    }

    public function delete(Location $location)
    {
        abort_unless($location, 404);
        $location->delete();

        if($location) {
            return $this->response("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }
}
