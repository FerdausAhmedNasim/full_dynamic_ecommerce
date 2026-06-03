<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\BalanceHistoryService;

class BalanceHistoryController extends Controller
{
    use ApiResponse;

    private $balanceHistoryService;

    public function __construct(BalanceHistoryService $balanceHistoryService)
    {
        $this->balanceHistoryService = $balanceHistoryService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->balanceHistoryService->dataTable();
        }

        return view('seller.pages.balance_history.index');
    }
}
