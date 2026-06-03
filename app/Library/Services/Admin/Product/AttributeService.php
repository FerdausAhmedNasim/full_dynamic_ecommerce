<?php

namespace App\Library\Services\Admin\Product;

use Exception;
use App\Library\Helper;
use App\Models\Attribute;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AttributeService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.attribute.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('attribute_value_create')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.attribute.value', $row->id) . '" ><i class="fa-solid fa-circle-plus"></i> Attribute Values</a>';
            }
            if (Helper::hasAuthRolePermission('attribute_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.attribute.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
            if (Helper::hasAuthRolePermission('attribute_delete')) {
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

        if (Helper::hasAuthRolePermission('attribute_change_status')) {
            $route = "'" . route('admin.attribute.change_status', $row->id) . "'";
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

    private function getValues($row)
    {
        $values = '';
        if ($row?->attributeValues) {
            foreach ($row?->attributeValues as $attributeValue) {
                $values .= '<span class="badge bg-primary mr-2 text-white">'. $attributeValue->value .'</span>';
            }
        }

        return $values;
    }

    public function dataTable()
    {
        $data = Attribute::with('attributeValues', 'operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name ? $row->name : 'N/A';
                })
                ->addColumn('values', function ($row) {
                    return $this->getValues($row);
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
                ->rawColumns(['values', 'status', 'action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = Attribute::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Attribute $attribute, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $attribute->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Attribute $attribute): bool
    {
        try {
            $this->data = $attribute->update(['active' => !$attribute->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Attribute $attribute): bool
    {
        try {
            $attribute->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
