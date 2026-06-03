<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Helper;
use App\Models\Location;
use Yajra\DataTables\Facades\DataTables;

class LocationService extends BaseService
{
    private function actionHtml($row, $user_role)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('config_location_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="javascript:void(0)" onclick="showLocationDetails(' . $row->id . ')" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('config_location_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.config.more_settings.location.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('config_location_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmModal(deleteLocation, ' . $row->id . ', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-alt"></i> Delete</a>';
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

    public function dataTable()
    {
        $data = Location::with('operator')->get();

        $user_role = User::getAuthUserRole();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->editColumn('ip', function ($row) {
                    return $row?->ip ?? 'N/A';
                })
                ->addColumn('action', function ($row) use ($user_role) {
                    return $this->actionHtml($row, $user_role);
                })
                ->addColumn('details', function ($row) {
                    return $row->details ? substr($row->details, 0, 50) : 'N/A';
                })
                ->rawColumns(['action', 'operator'])
                ->make(true);
    }

    public function create(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = Location::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Location $location, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $location->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

}
