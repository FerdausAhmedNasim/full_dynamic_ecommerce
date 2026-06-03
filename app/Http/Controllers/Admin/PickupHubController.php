<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Thana;
use App\Models\Address;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\PickupHub\StoreRequest;
use App\Http\Requests\Admin\PickupHub\UpdateRequest;
use App\Library\Services\Admin\PickupHubService;

class PickupHubController extends Controller
{
    use ApiResponse;

    private $pickup_hub_service;

    public function __construct(PickupHubService $pickup_hub_service)
    {
        $this->pickup_hub_service = $pickup_hub_service;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->pickup_hub_service->dataTable();
        }

        return view('admin.pages.config.general_settings.pickupHub.index');
    }

    public function divisionWiseDistrict(Request $request)
    {
        $districts = District::where('division_id', (int)$request->division_id)->where('active', true)->get();
        $options = '';

        if (count($districts) > 0) {
            $options = '<option value="" disabled selected="">Choose Your District</option>';

            foreach ($districts as $district) {
                $options .= '<option value="' . $district->id . '">
                                ' . $district->en_name . '
                            </option>';
            }
        }

        return json_encode($options);
    }

    public function districtWiseThana(Request $request)
    {
        $thanas = Thana::where('district_id', (int)$request->district_id)->where('active', true)->get();
        $options = '';

        if (count($thanas) > 0) {
            $options = '<option value="" disabled selected="">Choose Your Thana</option>';

            foreach ($thanas as $thana) {
                $options .= '<option value="' . $thana->id . '">
                                ' . $thana->en_name . '
                            </option>';
            }
        }

        return json_encode($options);
    }

    public function thanaWiseArea(Request $request)
    {
        $areas = Area::where('thana_id', (int)$request->thana_id)->where('active', true)->get();
        $options = '';

        if (count($areas) > 0) {
            $options = '<option value="" disabled selected="">Choose Your Area</option>';

            foreach($areas as $area) {
                $options .= '<option value="' . $area->id . '">
                                ' . $area->en_name . '
                            </option>';
            }
        }

        return json_encode($options);
    }
    
    public function create()
    {
        return view('admin.pages.config.general_settings.pickupHub.create', [
            'divisions' => Division::active()->get(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->pickup_hub_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.config.general_settings.pickup_hub.index')->with('success', $this->pickup_hub_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->pickup_hub_service->message);
    }

    public function edit(Address $pickupHub)
    {
        abort_unless($pickupHub, 404);

        return view('admin.pages.config.general_settings.pickupHub.update', [
            'pickupHub' => $pickupHub,
            'divisions' => Division::active()->get(),
            'districts' => District::active()->where('division_id', $pickupHub?->thana?->district?->division?->id)->get(),
            'thanas'    => Thana::active()->where('district_id', $pickupHub?->thana?->district?->id)->get(),
            'areas'     => Area::active()->where('thana_id', $pickupHub->thana_id)->get(),
        ]);
    }

    public function update(Address $pickupHub, UpdateRequest $request)
    {
        abort_unless($pickupHub, 404);

        $result = $this->pickup_hub_service->update($pickupHub, $request->validated());

        if ($result) {
            return redirect()->route('admin.config.general_settings.pickup_hub.index')->with('success', $this->pickup_hub_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->pickup_hub_service->message);
    }

    public function destroy(Address $pickupHub)
    {
        abort_unless($pickupHub, 404);

        $pickupHub->delete();

        if ($pickupHub) {
            return redirect()->route('admin.config.general_settings.pickup_hub.index')->with("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }
}

