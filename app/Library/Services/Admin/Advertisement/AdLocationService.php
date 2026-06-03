<?php

namespace App\Library\Services\Admin\Advertisement;

use Exception;
use App\Library\Helper;
use App\Models\AdvertiseLocation;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AdLocationService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.ad.location.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('ad_location_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ad.location.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('ad_location_delete')) {
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
        $data = AdvertiseLocation::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('location', function ($row) {
                    return ucwords(str_replace('_', ' ', $row->location));
                })
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->editColumn('amount', function ($row) {
                    return getFormattedAmount($row->amount);
                })
                ->editColumn('active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action','operator', 'active'])
                ->make(true);
    }

    private function getSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.ad.location.change_status', $row->id) . "'";
        $disabled = "";

        if (! Helper::hasAuthRolePermission('ad_location_change_status')) {
            $disabled = "disabled";
        }

        return '<div class="custom-switch">
                    <input type="checkbox" ' . $disabled . '
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function changeStatus(AdvertiseLocation $ad_location): bool
    {
        try {
            $this->data = $ad_location->update(['active' => !$ad_location->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = AdvertiseLocation::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(AdvertiseLocation $ad_location, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $ad_location->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(AdvertiseLocation $ad_location): bool
    {
        try {
            $ad_location->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
