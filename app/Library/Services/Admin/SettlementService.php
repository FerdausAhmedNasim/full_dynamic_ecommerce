<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Settlement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettlementService extends BaseService
{
    private function actionHtml($row)
    {
        if (Helper::hasAuthRolePermission('payout_index')) {
            return '<a class="btn btn2-secondary btn-sm" href="'. route('admin.settlement.details', $row->settlement_date) .'">
                    <i class="fas fa-eye"></i> Details
                </a>';
        }
    }

    private function detailsActionHtml($row)
    {
        if (Helper::hasAuthRolePermission('payout_index')) {
            return '<a class="btn btn2-secondary btn-sm" href="'. route('admin.settlement.details', $row->id) .'">
                    <i class="fas fa-eye"></i> Details
                </a>';
        }
    }

    public function dataTable()
    {
        $data = Settlement::with('seller')
                            ->select(DB::raw('COUNT(seller_id) as total_seller'),
                            DB::raw('SUM(total_sale) as total_sale'),
                            DB::raw('SUM(amount) as total_amount'),
                            DB::raw('SUM(commission) as commission'),
                            DB::raw('SUM(ad_cost) as ad_cost'),
                            DB::raw('DATE(date) as settlement_date'),
                            DB::raw('DATE(start_date) as settlement_start_date'),
                            DB::raw('DATE(end_date) as settlement_end_date'))
                            ->groupBy('settlement_date', 'settlement_start_date', 'settlement_end_date')
                            ->get();

        return Datatables::of($data)
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
                return $this->actionHtml($row);
            })
            ->rawColumns(['settlement_number', 'money_sent', 'action'])
            ->make(true);
    }

    private function getStatus($row)
    {
        $route = "'" . route('admin.settlement.money_sent', $row->id) . "'";

        $isChecked = $row->money_sent ? "checked" : "";

        return $this->getSwitch($row, $route, $isChecked);
    }

    private function getSwitch($row, $route, $isChecked)
    {
        return  '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ' )"
                        class="custom-control-input" id="seller_product_auto_approve_ ' . $row->id . '"
                        ' . $isChecked . '>
                    <label class="custom-control-label" for="seller_product_auto_approve_ ' . $row->id . '"></label>
                </div>';
    }

    public function detailsDataTable($settlementDate)
    {
        $data = Settlement::with('seller')->where('date', $settlementDate)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('settlement_date', function ($row) {
                return $row->date;
            })
            ->editColumn('seller', function ($row) {
                return '<a href="'. route('admin.user.seller.show', $row->seller_id) .'">' . $row->seller->full_name . '</a>';
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
            ->addColumn('current_balance', function ($row) {
                return getFormattedAmount($row->seller->balance);
            })
            ->addColumn('money_sent', function ($row) {
                return $this->getStatus($row);
            })
            ->editColumn('action', function ($row) {
                return '<a class="btn btn2-secondary btn-sm" href="'. route('admin.settlement.order.details', $row->id) .'"> Details </a>';
            })
            ->rawColumns(['seller', 'money_sent', 'action'])
            ->make(true);
    }

    public function orderDetailsDataTable($settlement)
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

    private function statusHtml($status)
    {
        $statusClassMapping = [
            Enum::SETTLEMENT_STATUS_PAID => 'badge-success',
            Enum::SETTLEMENT_STATUS_UNPAID => 'badge-danger',
            Enum::SETTLEMENT_STATUS_PARTIAL_PAID  => 'badge-warning',
        ];

        $class = $statusClassMapping[$status] ?? 'badge-secondary';

        return '<div class="badge ' . $class . '">' . Enum::getSettlementStatusType($status) . '</div>';
    }

    public function changeStatus(Settlement $settlement, $status, $note): bool
    {
        try {
            $this->data = $settlement->update(['status' => $status, 'note' => $note]);
            Settlement::where('id', $settlement->id)->update(['approved_by'=> authUser()->id]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function getNote($row)
    {
        $html = '';
        $note = substr($row->note, 0, 30);
        $html .= "<span>$note</span>";
        $html .= '.....<button type="button" class="btn p-0 text-success" onClick=(showNote((\'' . $row->id . '\')))> <i class="fa-solid fa-eye"></i> </button>';
        return $html;
    }

    public function orderByRange($range, $query)
    {
        if (!$range) {
            return $query;
        }

        switch ($range) {
            case 'latest_on_top':
                return $query->orderByDesc('id');

                break;
            case 'oldest_on_top':
                return $query->orderBy('id');

                break;
            case 'total_low_high':
                return $query->orderBy('total_amount');

                break;
            case 'total_high_low':
                return $query->orderByDesc('total_amount');

                break;
            case 'quantity_low_high':
                return $query->orderBy('quantity');

                break;
            case 'quantity_high_low':
                return $query->orderByDesc('quantity');

                break;
            default:
                return $query;
        }
    }
}
