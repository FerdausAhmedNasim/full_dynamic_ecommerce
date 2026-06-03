<?php

namespace App\Library\Services\Admin\User;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\BalanceHistory;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use Illuminate\Validation\ValidationException;

class SendMoneyService extends BaseService
{
    public function getNote($row)
    {
        $html = '';
        $note = substr($row->note, 0, 50);
        $html .= "<span>$note</span>";
        $html .= '.....<button type="button" class="btn p-0 text-success" onClick=(showText((\'' . $row->id . '\')))> <i class="fa-solid fa-eye"></i> </button>';

        return $html;
    }

    public function dataTable($id = null)
    {
        $query = BalanceHistory::with('operator')->where('type', Enum::BALANCE_HISTORY_STATUS_SEND_MONEY);

        if($id) {
            $query->where('seller_id', $id);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('amount', function ($row) {
                return getFormattedAmount($row?->amount);
            })

            ->editColumn('note', function ($row) {
                return strlen($row->note) > 50 ? $this->getNote($row) : $row->note;
            })

            ->editColumn('date', function ($row) {
                return  getFormattedDate($row->created_at);
            })

            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->rawColumns(['note'])
            ->make(true);
    }

    public function store(array $data, $user_id): bool
    {
        $user = User::find($user_id);

        if ($data['amount'] > $user->balance) {
            throw ValidationException::withMessages(['amount' => 'Send money amount can not be more than current balance']);
        }

        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['seller_id'] = $user_id;
            $data['type'] = Enum::BALANCE_HISTORY_STATUS_SEND_MONEY;
            $data['dr_cr'] = 'dr';
            $balanceHistory = BalanceHistory::create($data);

            $user->balance -= $data['amount'];
            $user->save();

            $this->data = $balanceHistory;

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            DB::rollback();

            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
