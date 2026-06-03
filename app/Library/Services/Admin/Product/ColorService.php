<?php

namespace App\Library\Services\Admin\Product;

use Exception;
use App\Models\Color;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class ColorService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.color.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('color_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.color.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('color_delete')) {
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

    private function getColorCode($row)
    {
        return '<div class="custom-color-code">
                    <p class="color-code" style="color: '. $row->color_code .'">'. $row->color_code .'</p>
                    <span class="colorCodeToolTip" style="background-color: '. $row->color_code .' ">'. $row->name. '</span>
                </div>';
    }

    private function getSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.color.change_status', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('color_change_status')) {
            $disabled = 'disabled';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" '. $disabled .'
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Color::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name ? $row->name : 'N/A';
                })
                ->editColumn('color_code', function ($row) {
                    return $row->color_code ? '<p class="color-code" style="color: '. $row->color_code .'" title="'. $row->name. '">'. $row->color_code .'</p>' : 'N/A';
                })
                ->editColumn('color_code', function ($row) {
                    return $this->getColorCode($row);
                })
                ->editColumn('status', function ($row) {
                    return $this->getSwitch($row);
                })
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['color_code', 'status', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = Color::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Color $color, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $color->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Color $color): bool
    {
        try {
            $this->data = $color->update(['active' => !$color->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Color $color): bool
    {
        try {
            $color->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
