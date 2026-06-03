<?php

namespace App\Library\Services\Admin\Area;

use Exception;
use App\Library\Helper;
use App\Models\District;
use App\Models\Division;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AreaSettingsService extends BaseService
{
    // Global Status Switch Button
    private function getSwitch($row, $route, $disabled)
    {
        $is_check = $row->active ? "checked" : "";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input" ' . $disabled . '
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    // Division Start
    public function divisionDataTable()
    {
        $data = Division::with('createdBy', 'updatedBy')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('en_name', function ($row) {
                    return $row->en_name;
                })
                ->editColumn('active', function ($row) {
                    $route = "'" . route('admin.area.settings.division_change_status', $row->id) . "'";

                    $disabled = Helper::hasAuthRolePermission('division_change_status') ? '' : 'disabled';

                    return $this->getSwitch($row, $route, $disabled);
                })
                ->rawColumns(['active'])
                ->make(true);
    }

    public function divisionChangeStatus(Division $division): bool
    {
        try {
            $this->data = $division->update(['active' => !$division->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    // District Start
    private function getSubrubsSwitch($row)
    {
        $is_check = $row->suburb ? "checked" : "";
        $route = "'" . route('admin.area.settings.district_suburb', $row->id) . "'";

        $disabled = Helper::hasAuthRolePermission('thana_suburbs') ? '' : 'disabled';

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeDistrictSubrubs(event, ' . $route . ')"
                        class="custom-control-input" ' . $disabled . '
                        id="primarySubrubsSwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySubrubsSwitch_' . $row->id . '"></label>
                </div>';
    }

    public function districtDataTable()
    {
        $data = District::with('division')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('en_name', function ($row) {
                    return $row->en_name;
                })
                ->editColumn('division_id', function ($row) {
                    return $row?->division?->en_name;
                })
                ->editColumn('suburb', function ($row) {
                    return $this->getSubrubsSwitch($row);
                })
                ->editColumn('active', function ($row) {
                    $route = "'" . route('admin.area.settings.district_change_status', $row->id) . "'";

                    $disabled = Helper::hasAuthRolePermission('district_change_status') ? '' : 'disabled';

                    return $this->getSwitch($row, $route, $disabled);
                })
                ->rawColumns(['active', 'suburb'])
                ->make(true);
    }

    public function districtChangeStatus(District $district): bool
    {
        try {
            $this->data = $district->update(['active' => !$district->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function districtSuburbs(District $district): bool
    {
        try {
            $this->data = $district->update(['suburb' => !$district->suburb]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
    // District End
}