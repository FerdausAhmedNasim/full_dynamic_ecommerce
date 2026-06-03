<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\Product\AttributeService;
use App\Http\Requests\Admin\Product\AttributeStoreRequest;
use App\Http\Requests\Admin\Product\AttributeUpdateRequest;
use App\Library\Services\Admin\Product\AttributeValueService;
use App\Http\Requests\Admin\Product\AttributeValueStoreRequest;

class AttributeController extends Controller
{
    use ApiResponse;

    private $attribute_service;
    private $attribute_value_service;

    public function __construct(AttributeService $attribute_service, AttributeValueService $attribute_value_service)
    {
        $this->attribute_service = $attribute_service;
        $this->attribute_value_service = $attribute_value_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->attribute_service->dataTable();
        }

        return view('admin.pages.product.attribute.create');
    }

    public function store(AttributeStoreRequest $request)
    {
        $result = $this->attribute_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.attribute.index')->with('success', $this->attribute_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_service->message);
    }

    public function edit(Attribute $attribute, Request $request)
    {
        if ($request->ajax()) {
            return $this->attribute_service->dataTable();
        }

        return view('admin.pages.product.attribute.update', [
            'attribute' => $attribute,
        ]);
    }

    public function update(Attribute $attribute, AttributeUpdateRequest $request)
    {
        $result = $this->attribute_service->update($attribute, $request->validated());

        if ($result) {
            return redirect()->route('admin.attribute.index')->with('success', $this->attribute_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_service->message);
    }

    public function destroy(Attribute $attribute): RedirectResponse
    {
        abort_unless($attribute, 404);
        $result = $this->attribute_service->delete($attribute);

        if ($result) {
            return redirect()->route('admin.attribute.index')->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, Attribute $attribute)
    {
        $result = $this->attribute_service->changeStatus($attribute);

        if ($result) {
            return redirect()->back()->with('success', $this->attribute_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_service->message);
    }

    public function attributeValue(Attribute $attribute, Request $request)
    {
        if ($request->ajax()) {
            return $this->attribute_value_service->dataTable($attribute->id);
        }

        return view('admin.pages.product.attribute.attributeValue', [
            'attribute' => $attribute,
        ]);
    }

    public function attributeValueStore(Attribute $attribute, AttributeValueStoreRequest $request)
    {
        $result = $this->attribute_value_service->store($request->validated());

        if ($result) {
            return back()->with('success', $this->attribute_value_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->attribute_value_service->message);
    }
}
