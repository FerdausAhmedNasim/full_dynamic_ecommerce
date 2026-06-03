<?php

namespace App\Http\Controllers\Seller\Coupon;

use App\Library\Enum;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Seller\Coupon\StoreRequest;
use App\Http\Requests\Seller\Coupon\UpdateRequest;
use App\Library\Services\Seller\Coupon\CouponService;

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

        return view('seller.pages.coupon.index');
    }

    public function create(): View
    {
        return view('seller.pages.coupon.create', [
            'couponTypes' => Enum::getCouponType(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->coupon_service->store($request->validated());

        if ($result) {
            return redirect()->route('seller.coupon.index')->with('success', $this->coupon_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->coupon_service->message);
    }

    public function edit(Coupon $coupon): View
    {
        return view('seller.pages.coupon.edit', [
            'coupon'    => $coupon,
            'couponTypes' => Enum::getCouponType(),
        ]);
    }

    public function update(UpdateRequest $request, Coupon $coupon): RedirectResponse
    {
        $result = $this->coupon_service->update($coupon, $request->validated());

        if($result) {
            return redirect()->route('seller.coupon.index')->with('success', $this->coupon_service->message);
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
