<?php

namespace App\Library\Services\Admin\Area;

use Exception;
use App\Models\Area;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AreaService extends BaseService
{
    private function getSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.area.settings.area.change_status', $row->id) . "'";

        $disabled = Helper::hasAuthRolePermission('area_change_status') ? '' : 'disabled';

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input" '. $disabled .'
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.area.settings.area.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('area_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.area.settings.area.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('area_delete')) {
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

    public function areaDataTable()
    {
        $data = Area::with('division', 'district', 'thana')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('en_name', function ($row) {
                    return $row->en_name;
                })
                ->editColumn('division_id', function ($row) {
                    return $row?->division?->en_name;
                })
                ->editColumn('district_id', function ($row) {
                    return $row?->district?->en_name;
                })
                ->editColumn('thana_id', function ($row) {
                    return $row?->thana?->en_name;
                })
                ->editColumn('active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['active', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['created_by'] = auth()->id();
            $this->data = Area::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Area $area, array $data): bool
    {
        try {
            $data['updated_by'] = auth()->id();
            $this->data = $area->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Area $area): bool
    {
        try {
            $this->data = $area->update(['active' => !$area->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}