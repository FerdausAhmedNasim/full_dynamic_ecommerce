<?php

namespace App\Library\Services\Seller;

use App\Library\Enum;
use App\Models\BalanceHistory;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class BalanceHistoryService extends BaseService
{
    public function dataTable()
    {
        $query = BalanceHistory::with('operator')->where('seller_id', authSellerId());

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('type', function ($row) {
                return ucwords(str_replace('_', ' ', $row->type));
            })
            ->editColumn('amount', function ($row) {
                return getFormattedAmount($row?->amount);
            })

            ->editColumn('dr_cr', function ($row) {
                return $row?->dr_cr == 'dr' ? 'Debit' : 'Credit';
            })

            ->editColumn('date', function ($row) {
                return  getFormattedDate($row->created_at);
            })

            ->editColumn('sent_by', function ($row) {
                return $row->type == Enum::BALANCE_HISTORY_STATUS_SEND_MONEY ? $row?->operator?->full_name : 'N/A';
            })

            ->editColumn('received_by', function ($row) {
                return $row->type == Enum::BALANCE_HISTORY_STATUS_TOP_UP ? $row?->operator?->full_name : 'N/A';
            })

            ->rawColumns(['note'])
            ->make(true);
    }
}
