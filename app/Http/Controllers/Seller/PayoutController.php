<?php

namespace App\Http\Controllers\Seller;

use App\Models\Payout;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Seller\PayoutService;
use App\Http\Requests\Seller\Payout\StoreRequest;
use App\Http\Requests\Seller\Payout\UpdateRequest;

class PayoutController extends Controller
{
    use ApiResponse;

    private $payout_service;

    public function __construct(PayoutService $payout_service)
    {
        $this->payout_service = $payout_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->payout_service->dataTable();
        }

        return view('seller.pages.payouts.index');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->payout_service->store($request->validated());

        if ($result) {
            return Response::success(__('Successfully created'));
        }

        return Response::error(__('Unable to create'), [], 500);
    }

    public function edit(Payout $payout)
    {
        return $payout;
    }

    public function update(UpdateRequest $request, Payout $payout)
    {
        $result = $this->payout_service->update($payout, $request->validated());

        if ($result) {
            return Response::success(__('Successfully updated'));
        }

        return Response::error(__('Unable to update'), [], 500);
    }

    public function destroy(Payout $payout): RedirectResponse
    {
        abort_unless($payout, 404);

        $result = $this->payout_service->delete($payout);

        if ($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }
}
