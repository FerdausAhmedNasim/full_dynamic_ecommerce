<?php

namespace App\Http\Controllers\Seller;

use App\Library\Enum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\ReportService;
use App\Models\Category;
use App\Models\SellerCategory;

class ReportController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function stock(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['category', 'fromDate', 'toDate']);

            return $this->reportService->stockDataTable($filterParams);
        }

        $categories = SellerCategory::where('seller_id', authSellerId())->get();

        return view('seller.pages.report.stock', compact('categories'));
    }

    public function order(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['order_status', 'payment_status', 'fromDate', 'toDate']);

            return $this->reportService->orderDataTable($filterParams);
        }

        return view('seller.pages.report.order', [
            'orderStatus'   => Enum::getOrderStatusType(),
            'paymentStatus' => Enum::getPaymentStatusType(),
        ]);
    }

    public function settlement(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['fromDate', 'toDate']);

            return $this->reportService->settlementDataTable($filterParams);
        }

        return view('seller.pages.report.settlement');
    }
}
