<?php

namespace App\Library\Services\Seller;

use App\Library\Enum;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Settlement;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class ReportService extends BaseService
{
    public function stockDataTable($params)
    {
        $query = Product::with('productStocks')->where('seller_id', authSellerId());

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
        $seller = authSeller();

        $query = Order::whereHas('sellerOrders', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        });

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
            ->editColumn('customer_id', function ($row) {
                return $row?->customer?->full_name ?? 'N/A';
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
            ->editColumn('order_status', function ($row) {
                return Enum::getOrderStatusType($row->order_status);
            })
            ->editColumn('payment_status', function ($row) {
                return Enum::getPaymentStatusType($row->payment_status);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['operator_id'])
            ->make(true);
    }

    public function settlementDataTable($params)
    {
        $data = Settlement::with('seller')->where('seller_id', authSellerId())->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('settlement_number', function ($row) {
                $date = Carbon::parse($row->settlement_date);
                return $date->format('d') < 15 ? '1st settlement of ' . $date->format('F, Y') : '2nd settlement of ' . $date->format('F, Y');
            })
            ->editColumn('settlement_date', function ($row) {
                return $row->date;
            })
            ->editColumn('total_sale', function ($row) {
                return getFormattedAmount($row->total_sale);
            })
            ->editColumn('commission', function ($row) {
                return getFormattedAmount($row->commission);
            })
            ->editColumn('ad_cost', function ($row) {
                return getFormattedAmount($row->ad_cost);
            })
            ->editColumn('amount', function ($row) {
                return getFormattedAmount($row->amount);
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date;
            })
            ->editColumn('end_date', function ($row) {
                return $row->end_date;
            })
            ->make(true);
    }
}
