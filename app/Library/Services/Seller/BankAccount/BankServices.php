<?php

namespace App\Library\Services\Seller\BankAccount;

use Exception;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Models\BankAccount;

class BankServices extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.bankAccount.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_bank_account_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('seller.bankAccount.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('seller_bank_account_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('seller.bankAccount.show', $row->id) . '" ><i class="far fa-eye"></i> Show</a>';
            }

            if (Helper::hasAuthRolePermission('seller_bank_account_delete')) {
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
        $sellerId = authSellerId();
        $data = BankAccount::where('seller_id', $sellerId)->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('bank_name', function ($row) {
                    return $row->bank_name;
                })
                ->editColumn('branch_name', function ($row) {
                    return $row->branch_name;
                })
                ->editColumn('account_name', function ($row) {
                    return $row->account_name;
                })
                ->editColumn('account_number', function ($row) {
                    return $row->account_number;
                })
                ->editColumn('routing_number', function ($row) {
                    return $row->routing_number;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
       try {
            $data['seller_id'] = authSellerId();

            $this->data = BankAccount::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(BankAccount $bank, array $data): bool
    {
        try {
            $data['seller_id'] = authSellerId();

            $this->data = $bank->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(BankAccount $bank): bool
    {
        try {
            $bank->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
