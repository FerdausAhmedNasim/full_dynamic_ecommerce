<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\Area;
use App\Models\Thana;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Area\AreaService;
use App\Http\Requests\Admin\AreaSettings\Area\StoreRequest;
use App\Http\Requests\Admin\AreaSettings\Thana\UpdateRequest;

class AreaController extends Controller
{
    use ApiResponse;

    private $area_service;

    public function __construct(AreaService $area_service)
    {
        $this->area_service = $area_service;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->area_service->areaDataTable();
        }

        return view('admin.pages.config.area_settings.area.index');
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
    
    public function create()
    {
        return view('admin.pages.config.area_settings.area.create', [
            'divisions' => Division::active()->get(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->area_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.area.settings.area.index')->with('success', $this->area_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->area_service->message);
    }

    public function edit(Area $area)
    {
        abort_unless($area, 404);

        return view('admin.pages.config.area_settings.area.update', [
            'area'      => $area,
            'divisions' => Division::active()->get(),
            'districts' => District::active()->where('division_id', $area?->thana?->district?->division?->id)->get(),
            'thanas'    => Thana::active()->where('district_id', $area?->thana?->district?->id)->get(),
        ]);
    }

    public function update(Area $area, UpdateRequest $request)
    {
        abort_unless($area, 404);

        $result = $this->area_service->update($area, $request->validated());

        if ($result) {
            return redirect()->route('admin.area.settings.area.index')->with('success', $this->area_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->area_service->message);
    }

    public function destroy(Area $area)
    {
        abort_unless($area, 404);

        $area->delete();

        if ($area) {
            return redirect()->route('admin.area.settings.area.index')->with("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Area $area, Request $request)
    {
        $result = $this->area_service->changeStatus($area);

        if ($result) {
            return redirect()->back()->with('success', $this->area_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->area_service->message);
    }
}
