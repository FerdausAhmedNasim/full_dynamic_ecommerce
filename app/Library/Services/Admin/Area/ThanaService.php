<?php

namespace App\Library\Services\Admin\Area;

use Exception;
use App\Models\Thana;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class ThanaService extends BaseService
{
    private function getSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.area.settings.thana.change_status', $row->id) . "'";

        $disabled = Helper::hasAuthRolePermission('thana_change_status') ? '' : 'disabled';

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input" ' . $disabled . '
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    private function getSubrubsSwitch($row)
    {
        $is_check = $row->suburb ? "checked" : "";
        $route = "'" . route('admin.area.settings.thana.suburb', $row->id) . "'";
        
        $disabled = Helper::hasAuthRolePermission('thana_suburbs') ? '' : 'disabled';

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeThanaSubrubs(event, ' . $route . ')"
                        class="custom-control-input" ' . $disabled . '
                        id="primaryThanaSubrubsSwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primaryThanaSubrubsSwitch_' . $row->id . '"></label>
                </div>';
    }

    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.area.settings.thana.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('thana_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.area.settings.thana.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('thana_delete')) {
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

    public function dataTable()
    {
        $data = Thana::with('district')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('en_name', function ($row) {
                    return $row->en_name;
                })
                ->editColumn('district_id', function ($row) {
                    return $row?->district?->en_name;
                })
                ->editColumn('suburb', function ($row) {
                    return $this->getSubrubsSwitch($row);
                })
                ->editColumn('active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['active', 'suburb', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['created_by'] = auth()->id();
            $this->data = Thana::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Thana $thana, array $data): bool
    {
        try {
            $data['updated_by'] = auth()->id();
            $this->data = $thana->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Thana $thana): bool
    {
        try {
            $this->data = $thana->update(['active' => !$thana->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function suburbs(Thana $thana): bool
    {
        try {
            $this->data = $thana->update(['suburb' => !$thana->suburb]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}