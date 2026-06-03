<?php

namespace App\Library\Services\Admin\User;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class CustomerService extends BaseService
{
    private function filter(array $params)
    {
        $query = User::with('operator')->where('users.user_type', Enum::USER_TYPE_CUSTOMER);

        if ($params['is_deleted'] == 1) {
            $query->onlyTrashed();
            $query->whereNotNull('deleted_at');
        } elseif (isset($params['status']) && (int)($params['status']) != -1) {
            $query->where('status', $params['status']);
            $query->whereNull('deleted_at');
        } elseif (isset($params['status']) && (int)($params['status']) == -1) {
            $query->withTrashed();
        }

        return $query->get();
    }

    private function actionHtml($row, $user_role)
    {
        $actionHtml = '';

        if (Helper::hasAuthRolePermission('user_restore') && $row->deleted_at) {
            $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreMember, ' . $row->id . ', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
        } elseif ($row->id && !$row->deleted_at) {
            if (Helper::hasAuthRolePermission('customer_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.user.customer.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('customer_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.user.customer.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
        } else {
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    private function statusHtml($row)
    {
        $class = '';

        if ($row->deleted_at != null) {
            $class = 'badge-danger';
        } elseif ($row->status == Enum::USER_STATUS_PENDING) {
            $class = 'badge-secondary';
        } elseif ($row->status == Enum::USER_STATUS_ACTIVE) {
            $class = 'badge-success';
        } elseif ($row->status == Enum::USER_STATUS_SUSPENDED) {
            $class = 'badge-warning';
        } else {
            $class = 'badge-secondary';
        }
        $status = $row->deleted_at != null ? 'Deleted' : Enum::getUserStatus($row->status);

        return '<div class="badge ' . $class . '">' . $status . '</div>';
    }

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);
        $user_role = User::getAuthUserRole();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) use ($user_role) {
                $name = $row?->full_name;

                return !Helper::hasAuthRolePermission('customer_show') || $row->deleted_at || $row->id == null ? $name : '<a href="' . route('admin.user.customer.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
            })
            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })
            ->addColumn('operator', function ($row) {
                return $row?->operator?->full_name;
            })
            ->addColumn('dob', function ($row) {
                return getFormattedDate($row->dob);
            })
            ->addColumn('status', function ($row) {
                return $this->statusHtml($row);
            })
            ->editColumn('customer_type', function ($row) {
                return ucwords($row->customer_type);
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }

    public function createMember(array $data): bool
    {
        try {
            // User
            $user_data = $data;
            $user_data['first_name'] = $data['full_name'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = auth()->id();
            $user_data['status'] = Enum::USER_STATUS_ACTIVE;
            $user_data['user_type'] = Enum::USER_TYPE_CUSTOMER;
            $user_data['password'] = bcrypt('12345678');

            if (isset($data['avatar'])) {
                $user_data['avatar'] = Helper::uploadImage($data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            User::create($user_data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateMember(User $user, array $data)
    {
        try {
            // User
            $user_data = $data;
            $user_data['first_name'] = explode(" ", $data['full_name'])[0];
            $user_data['last_name'] = explode($user_data['first_name'], $data['full_name'])[1];
            $user_data['phone'] = $data['phone'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = auth()->id();

            if (isset($data['avatar'])) {
                deleteFile($user->avatar);
                $user_data['avatar'] = Helper::uploadImage($data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            $user->update($user_data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
