<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\CourierPricingPlan;
use Yajra\DataTables\Facades\DataTables;

class CourierPricingPlanService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.courier_pricing_plan.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('courier_pricing_plan_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.courier_pricing_plan.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('courier_pricing_plan_delete')) {
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
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.courier_pricing_plan.change_status', $row->id) . "'";

        $disabled = "disabled";
        if (Helper::hasAuthRolePermission('courier_pricing_plan_change_status')) {
            $disabled = '';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input" '. $disabled .'
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = CourierPricingPlan::with('operator')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->editColumn('pickup_location', function ($row) {
                    return Enum::getCourierPickupAndDeliveryLocation($row->pickup_location) ?? 'N/A';
                })
                ->editColumn('delivery_location', function ($row) {
                    return Enum::getCourierPickupAndDeliveryLocation($row->delivery_location) ?? 'N/A';
                })
                ->addColumn('weight', function ($row) {
                    return $row->min_weight . ' - ' . $row->max_weight . ' Kg';
                })
                ->editColumn('price', function ($row) {
                    return getFormattedAmount($row->price);
                })
                ->editColumn('delivery_time', function ($row) {
                    return $row->delivery_time;
                })
                ->editColumn('active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action', 'operator', 'active'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $data['delivery_time'] = 'Standard Delivery';
            $this->data = CourierPricingPlan::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(CourierPricingPlan $courierPricingPlan, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $courierPricingPlan->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(CourierPricingPlan $courierPricingPlan): bool
    {
        try {
            $this->data = $courierPricingPlan->update(['active' => !$courierPricingPlan->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

}