<?php

namespace App\Library\Services\Admin\Product;

use Exception;
use App\Library\Helper;
use App\Models\AttributeValue;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AttributeValueService extends BaseService
{
    private function filter($attribute_id)
    {
        $query = AttributeValue::with('attribute', 'operator');

        if (isset($attribute_id)) {
            $query->where('attribute_id', $attribute_id);
        }

        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.attributeValue.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('attribute_value_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.attributeValue.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
            if (Helper::hasAuthRolePermission('attribute_value_delete')) {
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

    private function getSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "";
        $disabled = "";

        if (Helper::hasAuthRolePermission('attribute_value_change_status')) {
            $route = "'" . route('admin.attributeValue.change_status', $row->id) . "'";
        } else {
            $disabled = "disabled";
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" ' . $disabled . '
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '>
                    <span class="tooltiptext">Change Status</span>
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable($attribute_id = null)
    {
        $data = $this->filter($attribute_id);

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('attribute', function ($row) {
                    return $row->attribute_id ? $row?->attribute?->name : 'N/A';
                })
                ->editColumn('value', function ($row) {
                    return $row->value ? $row->value : 'N/A';
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
                ->rawColumns(['attribute', 'status', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = AttributeValue::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(AttributeValue $attributeValue, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $attributeValue->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(AttributeValue $attributeValue): bool
    {
        try {
            $this->data = $attributeValue->update(['active' => !$attributeValue->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(AttributeValue $attributeValue): bool
    {
        try {
            $attributeValue->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
