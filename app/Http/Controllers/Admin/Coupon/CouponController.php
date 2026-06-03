<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Library\Enum;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Library\Services\Admin\Coupon\CouponService;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    use ApiResponse;

    private $coupon_service;

    public function __construct(CouponService $coupon_service)
    {
        $this->coupon_service = $coupon_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->coupon_service->dataTable();
        }

        return view('admin.pages.coupon.index');
    }

    public function create(): View
    {
        return view('admin.pages.coupon.create', [
            'couponTypes' => Enum::getCouponType(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->coupon_service->store($request->validated());
        
        if ($result) {
            return redirect()->route('admin.coupon.index')->with('success', $this->coupon_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->coupon_service->message);
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.pages.coupon.edit', [
            'coupon'    => $coupon,
            'couponTypes' => Enum::getCouponType(),
        ]);
    }

    public function update(UpdateRequest $request, Coupon $coupon): RedirectResponse
    {
        $result = $this->coupon_service->update($coupon, $request->validated());

        if($result) {
            return redirect()->route('admin.coupon.index')->with('success', $this->coupon_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->coupon_service->message);
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        abort_unless($coupon, 404);

        $result = $this->coupon_service->delete($coupon);

        if($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }
}
