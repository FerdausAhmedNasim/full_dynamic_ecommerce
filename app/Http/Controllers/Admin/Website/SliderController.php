<?php

namespace App\Http\Controllers\Admin\Website;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Website\SliderService;
use App\Http\Requests\Admin\Website\Slider\SliderStoreRequest;
use App\Http\Requests\Admin\Website\Slider\SliderUpdateRequest;

class SliderController extends Controller
{
    use ApiResponse;

    private $slider_service;

    public function __construct(SliderService $slider_service)
    {
        $this->slider_service = $slider_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->slider_service->dataTable();
        }

        return view('admin.pages.website.slider.index');
    }

    public function store(SliderStoreRequest $request)
    {
        $result = $this->slider_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.website.slider.index')->with('success', $this->slider_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->slider_service->message);
    }

    public function edit(Slider $slider)
    {
        abort_unless($slider, 404);

        return view('admin.pages.website.slider.edit', [
            'slider' => $slider,
        ]);
    }

    public function update(Slider $slider, SliderUpdateRequest $request)
    {
        abort_unless($slider, 404);
        $result = $this->slider_service->update($slider, $request->validated());

        if ($result) {
            return redirect()->route('admin.website.slider.index', $slider->id)->with('success', $this->slider_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->slider_service->message);
    }

    public function destroy(Slider $slider)
    {
        abort_unless($slider, 404);
        $result = $this->slider_service->delete($slider);

        if ($result) {
            return redirect()->route('admin.website.slider.index', $slider->id)->with('success', $this->slider_service->message);
        }

        return back()->with('error', $this->slider_service->message);
    }

    public function changeStatus(Request $request, Slider $slider)
    {
        abort_unless($slider, 404);
        $result = $this->slider_service->changeStatus($slider);

        if ($result) {
            return redirect()->route('admin.website.slider.index')->with('success', $this->slider_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->slider_service->message);
    }
}
