<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Helper;
use App\Models\Discount;
use Yajra\DataTables\Facades\DataTables;

class DiscountService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.config.more_settings.discount.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('config_discount_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.config.more_settings.discount.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('config_discount_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
            }
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
        $route = "'" . route('admin.config.more_settings.discount.change_status', $row->id) . "'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Discount::with('operator')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->editColumn('amount', function ($row) {
                    return $row->amount ? getFormattedAmount($row->amount) : 'N/A';
                })
                ->editColumn('start_date', function ($row) {
                    return $row->start_date ? getFormattedDate($row->start_date) : 'N/A';
                })
                ->editColumn('end_date', function ($row) {
                    return $row->end_date ? getFormattedDate($row->end_date) : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->editColumn('is_active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->rawColumns(['action', 'operator', 'is_active'])
                ->make(true);
    }

    public function storeDiscount(array $data): bool
    {
        // try {
        $data['operator_id'] = auth()->id();
        $this->data = Discount::create($data);

        return $this->handleSuccess('Successfully Created');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public function updateDiscount(Discount $discount, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $discount->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Discount $discount): bool
    {
        try {
            $this->data = $discount->update(['is_active' => !$discount->is_active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

}
