<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\PayoutService;
use App\Models\Payout;
use Illuminate\Http\Request;

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

        return view('admin.pages.payout.index');
    }
    public function changeStatus(Request $request, Payout $payout)
    {
        $result = $this->payout_service->changeStatus($payout, $request->status, $request->note);

        if ($result) {
            return redirect()->back()->with('success', $this->payout_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->payout_service->message);
    }

    public function getMessage(Payout $payout)
    {
        return $payout;
    }

}
