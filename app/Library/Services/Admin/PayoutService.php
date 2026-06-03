<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Payout;
use App\Library\Helper;
use App\Models\BalanceHistory;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PayoutService extends BaseService
{
    private function actionHtml($row)
    {
        if ($row->id) {
            if (Helper::hasAuthRolePermission('payout_index')) {
            return $row->status != Enum::PAYOUT_STATUS_PENDING ? "<h4 class='text-center m-0 text-gray'>N/A</h4>" : '<button class="btn btn2-secondary btn-sm" type="button" onclick="clickUpdateStatus(' . $row->id . ')">
                    <i class="fas fa-power-off"></i> Change Status
                </button>';
            }
        }
    }

    public function dataTable()
    {
        $data = Payout::with('seller', 'approvedBy')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('seller_name', function ($row) {
                return $row?->seller?->full_name ?? 'N/A';
            })
            ->editColumn('date', function ($row) {
                return $row?->created_at->format('d-m-y') ?? 'N/A';
            })
            ->editColumn('amount', function ($row) {
                return $row?->amount ?? 'N/A';
            })
            ->editColumn('status', function ($row) {
                return $this->statusHtml($row->status) ?? 'N/A';
            })
            ->editColumn('operator', function ($row) {
                return $row->approvedBy->full_name ?? 'N/A';
            })
            ->editColumn('note', function ($row) {
                return $this->getNote($row) ?? 'N/A';
            })
            ->editColumn('action', function ($row) {
                return $this->actionHtml($row) ?? 'N/A';
            })
            ->rawColumns(['status', 'note', 'action'])
            ->make(true);
    }

    private function statusHtml($status)
    {
        $statusClassMapping = [
            Enum::PAYOUT_STATUS_APPROVED => 'badge-success',
            Enum::PAYOUT_STATUS_REJECTED => 'badge-danger',
            Enum::PAYOUT_STATUS_PENDING  => 'badge-info',
        ];

        $class = $statusClassMapping[$status] ?? 'badge-secondary';
        $statusText = Enum::getPayoutStatusType($status);

        return '<div class="badge ' . $class . '">' . $statusText . '</div>';
    }

    public function changeStatus(Payout $payout, $status, $note): bool
    {
      DB::beginTransaction();

        try {
            $payout->update(['status' => $status, 'note' => $note, 'approved_by' => authUser()->id]);

            if ($payout->status == Enum::PAYOUT_STATUS_APPROVED) {
                $user = User::find($payout->seller_id);

                BalanceHistory::create([
                    'seller_id' => $payout->seller_id,
                    'amount' => $payout->amount,
                    'type' => 'payout',
                    'dr_cr' => 'dr'
                ]);

                $user->balance -= $payout->amount;
                $user->save();
            }

           DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            DB::rollBack();

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
