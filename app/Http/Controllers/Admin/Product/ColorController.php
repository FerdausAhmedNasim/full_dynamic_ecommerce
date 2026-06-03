<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Product\ColorService;
use App\Http\Requests\Admin\Product\ColorStoreRequest;
use App\Http\Requests\Admin\Product\ColorUpdateRequest;

class ColorController extends Controller
{
    use ApiResponse;
    private $color_service;

    public function __construct(ColorService $color_service)
    {
        $this->color_service = $color_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->color_service->dataTable();
        }

        return view('admin.pages.product.color.create');
    }

    public function store(ColorStoreRequest $request)
    {
        $result = $this->color_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.color.index')->with('success', $this->color_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->color_service->message);
    }

    public function edit(Color $color, Request $request)
    {
        if ($request->ajax()) {
            return $this->color_service->dataTable();
        }

        return view('admin.pages.product.color.update', [
            'color' => $color,
        ]);
    }

    public function update(Color $color, ColorUpdateRequest $request)
    {
        $result = $this->color_service->update($color, $request->validated());

        if ($result) {
            return redirect()->route('admin.color.index')->with('success', $this->color_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->color_service->message);
    }

    public function destroy(Color $color): RedirectResponse
    {
        abort_unless($color, 404);
        $result = $this->color_service->delete($color);

        if ($result) {
            return redirect()->route('admin.color.index')->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, Color $color)
    {
        $result = $this->color_service->changeStatus($color);

        if ($result) {
            return redirect()->back()->with('success', $this->color_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->color_service->message);
    }
}
