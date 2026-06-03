<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Product\AttributeValueService;
use App\Http\Requests\Admin\Product\AttributeValueStoreRequest;
use App\Http\Requests\Admin\Product\AttributeValueUpdateRequest;

class AttributeValueController extends Controller
{
    use ApiResponse;
    private $attribute_value_service;

    public function __construct(AttributeValueService $attribute_value_service)
    {
        $this->attribute_value_service = $attribute_value_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->attribute_value_service->dataTable();
        }

        return view('admin.pages.product.attributeValue.create', [
            'attributes' => Attribute::active()->get(),
        ]);
    }

    public function store(AttributeValueStoreRequest $request)
    {
        $result = $this->attribute_value_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.attributeValue.index')->with('success', $this->attribute_value_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_value_service->message);
    }

    public function edit(AttributeValue $attributeValue, Request $request)
    {
        if ($request->ajax()) {
            return $this->attribute_value_service->dataTable();
        }

        return view('admin.pages.product.attributeValue.update', [
            'attributes'     => Attribute::active(),
            'attributeValue' => $attributeValue,
        ]);
    }

    public function update(AttributeValue $attributeValue, AttributeValueUpdateRequest $request)
    {
        $result = $this->attribute_value_service->update($attributeValue, $request->validated());

        if ($result) {
            return redirect()->route('admin.attributeValue.index')->with('success', $this->attribute_value_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_value_service->message);
    }

    public function destroy(AttributeValue $attributeValue): RedirectResponse
    {
        abort_unless($attributeValue, 404);
        $result = $this->attribute_value_service->delete($attributeValue);

        if ($result) {
            return redirect()->route('admin.attributeValue.index')->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, AttributeValue $attributeValue)
    {
        $result = $this->attribute_value_service->changeStatus($attributeValue);

        if ($result) {
            return redirect()->back()->with('success', $this->attribute_value_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_value_service->message);
    }
}
