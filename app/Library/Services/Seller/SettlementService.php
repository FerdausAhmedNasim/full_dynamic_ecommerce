<?php

namespace App\Library\Services\Seller;

use Carbon\Carbon;
use App\Models\Settlement;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class SettlementService extends BaseService
{
    public function dataTable()
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
            ->editColumn('seller', function ($row) {
                return $row->seller->full_name;
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
            ->editColumn('action', function ($row) {
                return '<a class="btn btn2-secondary btn-sm" href="'. route('seller.settlement.details', $row->id) .'"> Details </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detailsDataTable($settlement)
    {
        $data = $settlement->orders->load('sellerOrder.order');

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('settlement_date', function ($row) {
                return getFormattedDate($row->created_at);
            })
            ->editColumn('order', function ($row) {
                return '<a href="'. route('admin.user.seller.order.show', $row->seller_order_id) .'">' . $row->sellerOrder->order->invoice_id . '</a>';
            })
            ->rawColumns(['order'])
            ->make(true);
    }
}
