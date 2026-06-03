<?php

namespace App\Http\Controllers\Admin\Area;

use App\Models\Thana;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Area\ThanaService;
use App\Http\Requests\Admin\AreaSettings\Thana\StoreRequest;
use App\Http\Requests\Admin\AreaSettings\Thana\UpdateRequest;

class ThanaController extends Controller
{
    use ApiResponse;

    private $thana_service;

    public function __construct(ThanaService $thana_service)
    {
        $this->thana_service = $thana_service;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->thana_service->dataTable();
        }

        return view('admin.pages.config.area_settings.thana.index');
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
    
    public function create()
    {
        return view('admin.pages.config.area_settings.thana.create', [
            'divisions' => Division::active()->get(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->thana_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.area.settings.thana.index')->with('success', $this->thana_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->thana_service->message);
    }

    public function edit(Thana $thana)
    {
        abort_unless($thana, 404);

        return view('admin.pages.config.area_settings.thana.update', [
            'thana'     => $thana,
            'divisions' => Division::active()->get(),
            'districts' => District::active()->where('division_id', $thana?->district?->division?->id)->get(),
        ]);
    }

    public function update(Thana $thana, UpdateRequest $request)
    {
        abort_unless($thana, 404);

        $result = $this->thana_service->update($thana, $request->validated());

        if ($result) {
            return redirect()->route('admin.area.settings.thana.index')->with('success', $this->thana_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->thana_service->message);
    }

    public function destroy(Thana $thana)
    {
        abort_unless($thana, 404);

        $thana->delete();

        if ($thana) {
            return redirect()->route('admin.area.settings.thana.index')->with("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Thana $thana, Request $request)
    {
        $result = $this->thana_service->changeStatus($thana);

        if ($result) {
            return redirect()->back()->with('success', $this->thana_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->thana_service->message);
    }

    public function suburb(Thana $thana, Request $request)
    {
        $result = $this->thana_service->suburbs($thana);

        if ($result) {
            return redirect()->back()->with('success', $this->thana_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->thana_service->message);
    }
}
