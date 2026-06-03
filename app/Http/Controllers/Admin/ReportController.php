<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\ReportService;

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

        $categories = Category::active()->get();

        return view('admin.pages.report.stock', compact('categories'));
    }

    public function order(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['order_status', 'payment_status', 'fromDate', 'toDate']);

            return $this->reportService->orderDataTable($filterParams);
        }

        return view('admin.pages.report.order', [
            'orderStatus'   => Enum::getOrderStatusType(),
            'paymentStatus' => Enum::getPaymentStatusType(),
        ]);
    }

    public function sellerOrder(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['order_status', 'payment_status', 'seller_id', 'fromDate', 'toDate']);

            return $this->reportService->sellerOrderDataTable($filterParams);
        }

        return view('admin.pages.report.seller_order', [
            'orderStatus'   => Enum::getOrderStatusType(),
            'paymentStatus' => Enum::getPaymentStatusType(),
            'shops' => Store::with('seller')->get(),
        ]);
    }

    public function expense(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['category', 'fromDate', 'toDate']);

            return $this->reportService->expenseDataTable($filterParams);
        }

        return view('admin.pages.report.expense', [
            'categories' => getDropdown(Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY),
        ]);
    }

    public function withdraw(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['branch_id', 'fromDate', 'toDate']);

            return $this->reportService->withdrawDataTable($filterParams);
        }

        return view('admin.pages.report.withdraw');
    }

    public function users(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['type', 'status', 'fromDate', 'toDate']);

            return $this->reportService->userDataTable($filterParams);
        }

        return view('admin.pages.report.user');
    }

    public function settlement(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['fromDate', 'toDate']);

            return $this->reportService->settlementDataTable($filterParams);
        }

        return view('admin.pages.report.settlement');
    }

    public function profit(Request $request)
    {        
        $data = $this->reportService->profit($request);

        return view('admin.pages.report.profit', [
            'data' => $data
        ]);
    }
}
