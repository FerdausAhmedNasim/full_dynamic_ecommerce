<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\User;
use App\Library\Enum;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Product\ProductService;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Http\Requests\Admin\Product\ProductUpdateRequest;

class SellerProductController extends Controller
{
    private $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function index(Request $request, User $user)
    {
        if ($request->ajax()) {
            return $this->product_service->sellerProductDataTable($user->id);
        }

        return view('admin.pages.user.seller.product.index', compact('user'));
    }

    public function create(Request $request)
    {
        $categories = Category::whereNull('parent_id')
                                ->with('childrenCategories')
                                ->with('childrenCategories.childrenCategories')
                                ->with('childrenCategories.childrenCategories.childrenCategories')
                                ->get();
        $brands = getDropdown(Enum::CONFIG_DROPDOWN_AMS_BRAND);
        $units = getDropdown(Enum::CONFIG_DROPDOWN_UNIT);

        return view('admin.pages.product.create', compact('categories', 'brands', 'units'));
    }

    public function store(ProductStoreRequest $request)
    {
        $result = $this->product_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.product.index')->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function show(Product $product)
    {
        return view('admin.pages.product.show', compact('product'));
    }

    public function edit(Request $request, Product $product)
    {
        $categories = Category::whereNull('parent_id')
                                ->with('childrenCategories')
                                ->with('childrenCategories.childrenCategories')
                                ->with('childrenCategories.childrenCategories.childrenCategories')
                                ->get();
        $brands = getDropdown(Enum::CONFIG_DROPDOWN_AMS_BRAND);
        $units = getDropdown(Enum::CONFIG_DROPDOWN_UNIT);

        return view('admin.pages.product.edit', compact('categories', 'brands', 'units', 'product'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        abort_unless($product, 404);
        $result = $this->product_service->update($product, $request->validated());

        if ($result) {
            return redirect()->route('admin.product.index', $product->id)->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function destroy(Request $request, Product $product)
    {
        if (count($product->stocks)) {
            return back()->with('error', 'Unable to delete now! This product is already used.');
        }

        deleteFile($product->image);

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', __('Successfully Deleted'));
    }

    public function changeStatus(Request $request, Product $product)
    {
        $result = $this->product_service->changeStatus($product);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function changeFeature(Request $request, Product $product)
    {
        $result = $this->product_service->changeFeature($product);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }
}
