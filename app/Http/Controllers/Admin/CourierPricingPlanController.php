<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\CourierPricingPlan;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\CourierPricingPlanService;
use App\Http\Requests\Admin\CourierPricingPlan\StoreRequest;
use App\Http\Requests\Admin\CourierPricingPlan\UpdateRequest;

class CourierPricingPlanController extends Controller
{
    use ApiResponse;

    private $courier_pricing_plan_service;

    public function __construct(CourierPricingPlanService $courier_pricing_plan_service)
    {
        $this->courier_pricing_plan_service = $courier_pricing_plan_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->courier_pricing_plan_service->dataTable();
        }

        return view('admin.pages.courier.index');
    }

    public function create(): View
    {
        return view('admin.pages.courier.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->courier_pricing_plan_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.courier_pricing_plan.index')->with('success', $this->courier_pricing_plan_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->courier_pricing_plan_service->message);
    }

    public function edit(CourierPricingPlan $courierPricingPlan)
    {
        abort_unless($courierPricingPlan, 404);

        return view('admin.pages.courier.update', [
            'courierPricingPlan' => $courierPricingPlan,
        ]);
    }

    public function update(CourierPricingPlan $courierPricingPlan, UpdateRequest $request)
    {
        abort_unless($courierPricingPlan, 404);

        $result = $this->courier_pricing_plan_service->update($courierPricingPlan, $request->validated());

        if ($result) {
            return redirect()->route('admin.courier_pricing_plan.index')->with('success', $this->courier_pricing_plan_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->courier_pricing_plan_service->message);
    }

    public function destroy(CourierPricingPlan $courierPricingPlan)
    {
        abort_unless($courierPricingPlan, 404);

        $courierPricingPlan->delete();

        if ($courierPricingPlan) {
            return redirect()->route('admin.courier_pricing_plan.index')->with("success", "Successfully Deleted");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(CourierPricingPlan $courierPricingPlan, Request $request)
    {
        $result = $this->courier_pricing_plan_service->changeStatus($courierPricingPlan);

        if ($result) {
            return redirect()->back()->with('success', $this->courier_pricing_plan_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->courier_pricing_plan_service->message);
    }
}
