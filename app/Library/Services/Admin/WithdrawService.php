<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Helper;
use App\Models\Withdraw;
use Yajra\DataTables\Facades\DataTables;

class WithdrawService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.withdraw.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.withdraw.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
        } else {
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    private function getSwitch($row)
    {
        $is_check = $row->is_active ? "checked" : "";
        $route = "'" . route('admin.withdraw.change_status', $row->id) . "'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Withdraw::with('operator', 'branch')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('branch_id', function ($row) {
                    return $row->branch ? $row->branch->name : 'N/A';
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->editColumn('amount', function ($row) {
                    return getFormattedAmount($row->amount);
                })
                ->rawColumns(['action', 'is_active', 'withdraw_type_id'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = Withdraw::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Withdraw $withdraw, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $withdraw->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
