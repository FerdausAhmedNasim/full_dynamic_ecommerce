<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\SettlementService;
use App\Models\Settlement;

class SettlementController extends Controller
{
    use ApiResponse;

    private $settlement_service;

    public function __construct(SettlementService $settlementService)
    {
        $this->settlement_service = $settlementService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->settlement_service->dataTable();
        }

        return view('seller.pages.settlement.index');
    }

    public function details(Request $request, Settlement $settlement)
    {
        if ($request->ajax()) {
            return $this->settlement_service->detailsDataTable($settlement);
        }

        return view('seller.pages.settlement.order_details', compact('settlement'));
    }
}
