<?php

namespace App\Library\Services\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Expense;
use App\Models\Product;
use App\Models\SellerOrder;
use App\Models\Withdraw;
use App\Models\Settlement;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportService extends BaseService
{
    public function stockDataTable($params)
    {
        $query = Product::with('productStocks');

        if (isset($params['category']) && $params['category']) {
            $query->where('category_id', [$params['category']]);
        }

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function ($row) {
                return $row?->getTranslation('title');
            })
            ->editColumn('stock', function ($row) {
                if (! $row->has_variant) {
                    return $row?->current_stock;
                }

                return $row->productStocks->map(function ($stock) {
                    return '<span>'. $stock->name . ': ' . $stock->current_stock .'</span> <br />';
                })->implode(' ');
            })
            ->rawColumns(['stock'])
            ->make(true);
    }

    public function orderDataTable($params)
    {
        $query = Order::with('customer', 'operator');

        if (isset($params['order_status']) && count($params['order_status'])) {
            $query->whereIn('order_status', $params['order_status']);
        }

        if (isset($params['payment_status']) && count($params['payment_status'])) {
            $query->whereIn('payment_status', $params['payment_status']);
        }

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('invoice_id', function ($row) {
                return $row?->invoice_id ?? 'N/A';
            })
            ->editColumn('customer_id', function ($row) {
                return $row->customer?->full_name ?? 'N/A';
            })
            ->editColumn('sub_total_amount', function ($row) {
                return getFormattedAmount($row->sub_total_amount);
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row->total_amount);
            })
            ->editColumn('discount_amount', function ($row) {
                return getFormattedAmount($row->discount_amount);
            })
            ->editColumn('shipping_cost', function ($row) {
                return getFormattedAmount($row->shipping_cost);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['operator_id'])
            ->make(true);
    }

    public function sellerOrderDataTable($params)
    {
        $query = SellerOrder::with('order.customer', 'operator', 'seller');

        if (isset($params['seller_id']) && count($params['seller_id'])) {
            $query->whereIn('seller_id', $params['seller_id']);
        }

        if (isset($params['order_status']) && count($params['order_status'])) {
            $query->whereIn('order_status', $params['order_status']);
        }

        if (isset($params['payment_status']) && count($params['payment_status'])) {
            $query->whereIn('payment_status', $params['payment_status']);
        }

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('invoice_id', function ($row) {
                return $row?->order->invoice_id ?? 'N/A';
            })
            ->editColumn('customer_id', function ($row) {
                return $row->order->customer?->full_name ?? 'N/A';
            })
            ->editColumn('seller_id', function ($row) {
                return $row->seller?->full_name ?? 'N/A';
            })
            ->editColumn('sub_total_amount', function ($row) {
                return getFormattedAmount($row->sub_total_amount);
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row->total_amount);
            })
            ->editColumn('discount_amount', function ($row) {
                return getFormattedAmount($row->discount_amount);
            })
            ->editColumn('shipping_cost', function ($row) {
                return getFormattedAmount($row->shipping_cost);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['operator_id'])
            ->make(true);
    }

    public function expenseDataTable($params)
    {
        $query = Expense::with('operator');

        if (isset($params['category']) && count($params['category'])) {
            $query->whereIn('category', $params['category']);
        }

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('amount', function ($row) {
                return getFormattedAmount($row->amount);
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['operator_id'])
            ->make(true);
    }

    public function withdrawDataTable($params)
    {
        $query = Withdraw::with('operator');

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('amount', function ($row) {
                return getFormattedAmount($row->amount);
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['operator_id'])
            ->make(true);
    }

    public function userDataTable($params)
    {
        $query = User::with('employee', 'operator')
            ->whereNotIn('user_type', [Enum::USER_TYPE_SUPER_ADMIN, Enum::USER_TYPE_ADMIN]);

        if (isset($params['type']) && count($params['type'])) {
            $query->whereIn('user_type', $params['type']);
        }

        if (isset($params['status']) && count($params['status'])) {
            if (count($params['status']) == 1 && in_array(5, $params['status'])) {
                $query->onlyTrashed();
            } elseif (in_array(5, $params['status'])) {
                $query->withTrashed();
            }
            $query->whereIn('status', $params['status']);
        }

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->full_name;
            })
            ->addColumn('job_title', function ($row) {
                return $row->isEmployee() ? $row?->employee?->job_title : 'N/A';
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? 'N/A';
            })
            ->addColumn('employment_type', function ($row) {
                return $row->isEmployee() ? $row?->employee?->employment_type : 'N/A';
            })
            ->addColumn('user_type', function ($row) {
                return Enum::getUserType($row->user_type);
            })
            ->addColumn('entitlement_to_work', function ($row) {

                return $row->isEmployee() ? $row->employee->entitlement_to_work ?? 'N/A' : 'N/A';
            })
            ->addColumn('employee_id', function ($row) {

                return $row->isEmployee() ? $row->employee->id ?? 'N/A' : 'N/A';
            })
            ->addColumn('dob', function ($row) {

                return getFormattedDate($row->dob);
            })
            ->addColumn('operator', function ($row) {

                return $row?->operator?->full_name;
            })
            ->editColumn('status', function ($row) {

                return $this->statusHtml($row);
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function settlementDataTable($params)
    {
        $query = Settlement::with('seller')
                            ->select(DB::raw('COUNT(seller_id) as total_seller'),
                            DB::raw('SUM(total_sale) as total_sale'),
                            DB::raw('SUM(amount) as total_amount'),
                            DB::raw('SUM(commission) as commission'),
                            DB::raw('SUM(ad_cost) as ad_cost'),
                            DB::raw('DATE(date) as settlement_date'),
                            DB::raw('DATE(start_date) as settlement_start_date'),
                            DB::raw('DATE(end_date) as settlement_end_date'))
                            ->groupBy('settlement_date', 'settlement_start_date', 'settlement_end_date');

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        return Datatables::of($query->get())
            ->addIndexColumn()
            ->editColumn('settlement_number', function ($row) {
                $date = Carbon::parse($row->settlement_date);
                $settlement_number = $date->format('d') < 15 ? '1st settlement of ' . $date->format('F, Y') : '2nd settlement of ' . $date->format('F, Y');
                return '<a href="'. route('admin.settlement.details', $row->settlement_date) .'">' . $settlement_number . '</a>';
            })
            ->editColumn('total_seller', function ($row) {
                return $row->total_seller;
            })
            ->editColumn('settlement_date', function ($row) {
                return $row->settlement_date;
            })
            ->editColumn('total_sale', function ($row) {
                return getFormattedAmount($row->total_sale);
            })
            ->editColumn('commission', function ($row) {
                return getFormattedAmount($row?->commission);
            })
            ->editColumn('ad_cost', function ($row) {
                return getFormattedAmount($row?->ad_cost);
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row?->total_amount);
            })
            ->editColumn('start_date', function ($row) {
                return $row->settlement_start_date;
            })
            ->editColumn('end_date', function ($row) {
                return $row->settlement_end_date;
            })
            ->editColumn('action', function ($row) {
                return $this->settlementActionHtml($row);
            })
            ->rawColumns(['settlement_number', 'action'])
            ->make(true);
    }

    private function settlementActionHtml($row)
    {
        if (Helper::hasAuthRolePermission('payout_index')) {
            return '<a class="btn btn2-secondary btn-sm" href="'. route('admin.settlement.details', $row->settlement_date) .'">
                    <i class="fas fa-eye"></i> Details
                </a>';
        }
    }

    private function statusHtml($row)
    {
        $class = [
            Enum::USER_STATUS_PENDING   => 'badge-warning',
            Enum::USER_STATUS_ACTIVE    => 'badge-success',
            Enum::USER_STATUS_SUSPENDED => 'badge-danger',
        ];

        return '<div class="text-capitalize badge ' . $class[$row->status] . '">' . Enum::getUserStatus($row->status) . '</div>';
    }

    public function profit($request) 
    {
        if ($request->from && $request->to) {
            $from = $request->from;
            $to = $request->to;
        } else {
            $from = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $to = Carbon::parse()->addDays(1)->format("Y-m-d");
        }

        $sellerOrders = SellerOrder::getOrdersByDate($from, $to)->with('sellerOrderDetails', 'return');
        $totalShippingCost = SellerOrder::getOrdersByDate($from, $to)->sum('shipping_cost');
        $totalSalesAmount = $sellerOrders->sum('total_amount') - $totalShippingCost; // Total Sales

        $totalPurchaseAmountByOrder = $this->getTotalPurchaseAmount($sellerOrders);
        $totalPurchase = $totalPurchaseAmountByOrder['totalPurchase']; // Total Purchase
        
        $getReturnAmountByOrder = $this->getReturnOrder($sellerOrders);
        $totalReturn = $getReturnAmountByOrder['totalReturn']; // Total Return 

        $getReturnPurchase = $this->getReturnPurchase($sellerOrders);
        $totalReturnPurchase = $getReturnPurchase['totalReturnPurchase'];
        
        $profitMargin = $totalSalesAmount - ($totalPurchase - $totalReturnPurchase); // Profit Margin
        $netProfit = $profitMargin - $totalReturn; // Net Profit

        $data = [
            'sellerOrders'          => $sellerOrders->orderBy('id', 'desc')->get(),
            'totalSales'            => $totalSalesAmount,
            'totalPurchase'         => $totalPurchase,
            'totalReturn'           => $totalReturn,
            'totalReturnPurchase'   => $totalReturnPurchase,
            'netProfit'             => $netProfit,
            'returnByOrder'         => $getReturnAmountByOrder,
            'returnPurchaseByOrder' => $getReturnPurchase,
            'purchaseByOrder'       => $totalPurchaseAmountByOrder,
            'date_range'            => $request->from && $request->to ? Helper::dateRange($request->from, $request->to) : null,
        ];

        return $data;
    }

    private function getTotalPurchaseAmount($sellerOrders)
    {
        $data = [];
        $totalPurchase = 0;
        
        $orders = $sellerOrders->get();

        foreach ($orders as $order) {
            $totalPurchaseByOrder = 0;

            foreach ($order->sellerOrderDetails->load('product') as $orderDetail) {
                $productPrice = $orderDetail->quantity * $orderDetail->product->purchase_price;
                $totalPurchaseByOrder += $productPrice;
            }

            $data[$order->id] = $totalPurchaseByOrder;

            $totalPurchase += $totalPurchaseByOrder;
        }

        $data['totalPurchase'] = $totalPurchase;

        return $data;
    }

    private function getReturnOrder($sellerOrders)
    {
        $data = [];
        $total = 0;

        $orders = $sellerOrders->get();

        foreach ($orders as $order) {
            $orderTotal = 0;

            if ($order?->return) {
                $returnOrder = $order->return;

                if ($returnOrder->status == Enum::RETURN_STATUS_APPROVED) {
                    $returnAmount = $returnOrder->total_amount;

                    $orderTotal += $returnAmount;
                }
                
            }

            $total += $orderTotal;

            $data[$order->id] = $orderTotal;
        }

        $data['totalReturn'] = $total;

        return $data;
    }

    private function getReturnPurchase($sellerOrders)
    {
        $data = [];
        $total = 0;

        $orders = $sellerOrders->get();

        foreach ($orders as $order) {
            $returnPurchaseTotal = 0;

            if ($order?->return) {
                $returnOrder = $order->return;

                if ($returnOrder->status == Enum::RETURN_STATUS_APPROVED) {
                    if ($returnOrder?->returnDetails) {
                        foreach ($returnOrder?->returnDetails as $detail) {
                            $purchaseCost = $detail->product->purchase_price;

                            $returnPurchaseTotal += $purchaseCost;
                        }
                    }
                }
                
            }

            $total += $returnPurchaseTotal;

            $data[$order->id] = $returnPurchaseTotal;
        }

        $data['totalReturnPurchase'] = $total;

        return $data;
    }
}
