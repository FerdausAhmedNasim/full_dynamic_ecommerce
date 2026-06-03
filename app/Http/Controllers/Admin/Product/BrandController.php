<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Product\BrandService;
use App\Http\Requests\Admin\Product\Brand\BrandStoreRequest;
use App\Http\Requests\Admin\Product\Brand\BrandUpdateRequest;

class BrandController extends Controller
{
    use ApiResponse;

    private $brand_service;

    public function __construct(BrandService $brand_service)
    {
        $this->brand_service = $brand_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->brand_service->dataTable();
        }

        return view('admin.pages.product.brand.index');
    }

    public function store(BrandStoreRequest $request)
    {
        $result = $this->brand_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.brand.index')->with('success', $this->brand_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->brand_service->message);
    }

    public function edit(Brand $brand)
    {
        abort_unless($brand, 404);

        return view('admin.pages.product.brand.edit', [
            'brand' => $brand,
        ]);
    }

    public function update(Brand $brand, BrandUpdateRequest $request)
    {
        abort_unless($brand, 404);
        $result = $this->brand_service->update($brand, $request->validated());

        if ($result) {
            return redirect()->route('admin.brand.index', $brand->id)->with('success', $this->brand_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->brand_service->message);
    }

    public function destroy(Brand $brand)
    {
        abort_unless($brand, 404);

        if ($brand->products()->count()) {
            return redirect()->back()->with('error', "Could not deleted! This brand has products.");
        }
        $result = $this->brand_service->delete($brand);

        if ($result) {
            return redirect()->route('admin.brand.index', $brand->id)->with('success', $this->brand_service->message);
        }

        return back()->with('error', $this->brand_service->message);
    }

    public function changeStatus(Request $request, Brand $brand)
    {
        abort_unless($brand, 404);
        $result = $this->brand_service->changeStatus($brand);

        if ($result) {
            return redirect()->route('admin.brand.index')->with('success', $this->brand_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->brand_service->message);
    }

    public function changeFeatured(Request $request, Brand $brand)
    {
        abort_unless($brand, 404);
        $result = $this->brand_service->changeFeatured($brand);

        if ($result) {
            return redirect()->route('admin.brand.index')->with('success', $this->brand_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->brand_service->message);
    }
}
