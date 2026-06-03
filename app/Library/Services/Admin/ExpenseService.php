<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Helper;
use App\Models\Expense;
use Yajra\DataTables\Facades\DataTables;

class ExpenseService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.expense.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('expense_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.expense.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('expense_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
            }
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

    public function dataTable()
    {
        $data = Expense::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->editColumn('amount', function ($row) {
                    return getFormattedAmount($row->amount);
                })
                ->editColumn('created_at', function ($row) {
                    return getFormattedDateTime($row->created_at);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action','operator'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = Expense::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Expense $expense, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $expense->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Expense $expense): bool
    {
        try {
            $expense->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
