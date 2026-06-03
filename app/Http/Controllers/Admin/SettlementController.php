<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Settlement;
use Illuminate\Http\Request;
use App\Models\BalanceHistory;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\SettlementService;

class SettlementController extends Controller
{
    use ApiResponse;

    private $settlement_service;

    public function __construct(SettlementService $settlement_service)
    {
        $this->settlement_service = $settlement_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->settlement_service->dataTable();
        }

        return view('admin.pages.settlement.index');
    }

    public function details(Request $request, $settlementDate)
    {
        if ($request->ajax()) {
            return $this->settlement_service->detailsDataTable($settlementDate);
        }

        return view('admin.pages.settlement.details', compact('settlementDate'));
    }

    public function orderDetails(Request $request, Settlement $settlement)
    {
        if ($request->ajax()) {
            return $this->settlement_service->orderDetailsDataTable($settlement);
        }

        return view('admin.pages.settlement.order_details', compact('settlement'));
    }

    public function moneySent(Request $request, Settlement $settlement)
    {
        if (!$settlement->money_sent) {
            BalanceHistory::create([
                'seller_id' => $settlement->seller_id,
                'settlement_id' => $settlement->id,
                'amount' => $settlement->amount,
                'type' => 'settlement',
                'dr_cr' => 'cr',
            ]);

            $settlement->money_sent = true;
            $settlement->save();

            $user = User::find($settlement->seller_id);
            $user->balance -= $settlement->amount;
            $user->save();

            return back()->with(['success' => 'Successfully updated!']);
        }

        $settlement->money_sent = false;
        $settlement->save();

        BalanceHistory::where([
            'type' => 'settlement',
            'seller_id' => $settlement->seller_id,
            'settlement_id' => $settlement->id,
        ])->delete();

        $user = User::find($settlement->seller_id);
        $user->balance += $settlement->amount;
        $user->save();

        return back()->with(['success' => 'Successfully updated!']);
    }
}
