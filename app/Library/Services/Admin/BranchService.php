<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\Branch;
use App\Library\Helper;
use App\Models\EmployeeBranch;
use Yajra\DataTables\Facades\DataTables;

class BranchService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.branch.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('branch_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.branch.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('branch_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.branch.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('branch_delete') && $row->id != 1) {
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
        $is_check = $row->is_active ? "checked" : "";
        $route = "'" . route('admin.branch.change_status', $row->id) . "'";

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
        $data = Branch::with('manager.employee', 'location', 'operator', 'balance')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('manager_id', function ($row) {
                    $name = $row?->manager?->full_name;

                    if ($row?->manager?->employee) {
                        return Helper::hasAuthRolePermission('employee_show') ? '<a href="' . route('admin.user.employee.show', $row?->manager?->employee->id) . '" class="text-success pr-2">' . $name . '</a>' : 'N/A';
                    } else {
                        return $name;
                    }
                })
                ->editColumn('name', function ($row) {
                    return Helper::hasAuthRolePermission('branch_show') ? '<a href="' . route('admin.branch.show', $row->id) . '" class="text-success pr-2">' . $row->name . '</a>' : $row->name;
                })
                ->editColumn('location_id', function ($row) {
                    return $row?->location?->name ?? 'N/A';
                })
                ->editColumn('phone', function ($row) {
                    return $row->phone ? $row->phone : 'N/A';
                })
                ->editColumn('email', function ($row) {
                    return $row->email ? $row->email : 'N/A';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ? $row->address : 'N/A';
                })
                ->editColumn('operator', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->editColumn('is_active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('balance', function ($row) {
                    return getFormattedAmount($row->balance->sum('amount'));
                })
                ->rawColumns(['action','operator', 'is_active', 'manager_id', 'name'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = Branch::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Branch $branch, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            $this->data = $branch->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Branch $branch): bool
    {
        try {
            $this->data = $branch->update(['is_active' => !$branch->is_active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Branch $branch): bool
    {
        abort_if($branch->id == 1, '403', 'System needs at least 1 branch to run!');

        try {
            $branch->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function createEmployeeBranch(Branch $branch, array $data): bool
    {
        try {
            $data['branch_id'] = $branch->id;
            $data['operator_id'] = auth()->id();

            EmployeeBranch::create($data);

            $this->message = __('Successfully Created');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateEmployeeBranch(EmployeeBranch $employeeBranch, array $data): bool
    {
        // dd($data);

        try {
            $data['operator_id'] = auth()->id();

            $employeeBranch->update($data);

            $this->message = __('Successfully Created');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
