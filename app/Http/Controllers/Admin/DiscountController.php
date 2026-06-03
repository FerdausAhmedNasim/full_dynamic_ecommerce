<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discount;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\DiscountService;
use App\Http\Requests\Admin\Discount\StoreRequest;
use App\Http\Requests\Admin\Discount\UpdateRequest;

class DiscountController extends Controller
{
    use ApiResponse;

    private $discount_service;

    public function __construct(DiscountService $discount_service)
    {
        $this->discount_service = $discount_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->discount_service->dataTable();
        }

        return view('admin.pages.config.discount.index');
    }

    public function create(): View
    {
        return view('admin.pages.config.discount.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->discount_service->storeDiscount($request->validated());

        if($result) {
            return redirect()->route('admin.config.more_settings.discount.index')->with('success', $this->discount_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->discount_service->message);
    }

    public function edit(Discount $discount)
    {
        abort_unless($discount, 404);

        return view('admin.pages.config.discount.update', [
            'discount' => $discount,
        ]);
    }

    public function update(Discount $discount, UpdateRequest $request)
    {
        abort_unless($discount, 404);

        $result = $this->discount_service->updateDiscount($discount, $request->validated());

        if($result) {
            return redirect()->route('admin.config.more_settings.discount.index')->with('success', $this->discount_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->discount_service->message);
    }

    public function delete(Discount $discount)
    {
        abort_unless($discount, 404);
        $discount->delete();

        if($discount) {
            return redirect()->route('admin.config.more_settings.discount.index')->with("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Discount $discount, Request $request)
    {
        $result = $this->discount_service->changeStatus($discount);

        if($result) {
            return redirect()->back()->with('success', $this->discount_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->discount_service->message);
    }
}
