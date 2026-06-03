<?php

namespace App\Library\Services\Seller;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Address;
use App\Models\Employee;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class ModeratorService extends BaseService
{
    private function filter(array $params)
    {
        $query = User::select('employees.id as employee_id', 'employees.*', 'users.*')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->whereIn('users.user_type', [Enum::USER_TYPE_MODERATOR])
            ->where('users.parent_id', authSellerId());

        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
            $query->whereNotNull('employees.deleted_at');
        } elseif (isset($params['status'])) {
            $query->where('status', $params['status']);
            $query->whereNull('employees.deleted_at');
        }

        return $query->get();
    }

    private function actionHtml($row)
    {
        if (is_null($row->employee_id)) {
            return '';
        }

        $actionHtml = '';

        if ($row->deleted_at) {
            if (Helper::hasAuthRolePermission('seller_moderator_restore')) {
                $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="confirmModal(restoreEmployee, ' . $row->id . ', \'Are you sure to restore operation?\')" ><i class="fas fa-trash-restore-alt"></i> Restore</a>';
            }
        } elseif ($row->employee_id && !$row->deleted_at) {
            if (Helper::hasAuthRolePermission('seller_moderator_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('seller.moderator.show', $row->employee_id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('seller_moderator_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('seller.moderator.update', $row->employee_id) . '" ><i class="far fa-edit"></i> Edit</a>';
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

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                $name = $row?->full_name;

                return '<a href="' . route('seller.moderator.show', $row->employee_id) . '" class="text-success pr-2">' . $name . '</a>';
            })

            ->addColumn('dob', function ($row) {
                return getFormattedDate($row->dob);
            })
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->rawColumns(['name', 'action', 'emp_type', 'dob'])
            ->make(true);
    }

    public function create(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();

            // User
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = $data['operator_id'];
            $user_data['status'] = Enum::USER_STATUS_PENDING;
            $user_data['password'] = bcrypt($user_data['password']);
            $user_data['user_type'] = Enum::USER_TYPE_MODERATOR;
            $user_data['parent_id'] = authSellerId();

            if (isset($user_data['avatar'])) {
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            unset($data['user']);
            $user = User::create($user_data);

            // Employee
            $employee_data = $data['employee'];
            $employee_data['user_id'] = $user->id;
            $employee_data['operator_id'] = $data['operator_id'];

            unset($data['employee']);
            Employee::create($employee_data);

            // Address
            $address_data = $data['address'];
            $address_data['user_id'] = $user->id;
            $address_data['operator_id'] = $data['operator_id'];

            unset($data['address']);
            Address::create($address_data);

            // Emergency Contact
            $emergency_data = $data['emergencyContact'];
            $emergency_data['user_id'] = $user->id;
            $emergency_data['created_by'] = $data['operator_id'];
            // $emergency_data['mobile_number'] = $data['emergency_mobile'];

            unset($data['emergencyContact']);
            EmergencyContact::create($emergency_data);

            // Roles
            if (isset($data['role_id'])) {
                $user->roles()->attach($data['role_id']);
            }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function updateEmployee(Employee $employee, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();

            // User
            $user = $employee->user;
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = $data['operator_id'];
            $user_data['status'] = Enum::USER_STATUS_PENDING;

            if (isset($user_data['avatar'])) {
                deleteFile($user->avatar);
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            // if ($data['user']['user_type'] == Enum::USER_TYPE_EMPLOYEE) {
            //     $user->roles()->detach();
            //     unset($data['role_id']);
            // }

            unset($data['user']);
            $user->update($user_data);

            if (isset($data['role_id'])) {
                $user->roles()->sync($data['role_id']);
            }

            // Employee
            $employee_data = $data['employee'];
            $employee_data['user_id'] = $user->id;
            $employee_data['operator_id'] = $data['operator_id'];

            unset($data['employee']);
            $employee->update($employee_data);

            DB::commit();

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function updateStatus(User $user, int $data)
    {
        try {
            $user->update(['status' => $data]);

            return $this->handleSuccess('Successfully updated');

        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updatePassword(User $user, array $data)
    {
        try {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function deleteUser(User $user)
    {
        DB::beginTransaction();

        try {
            $user->employee()->delete();
            deleteFile([$user->avatar]);
            $user->emergency()->delete();
            $user->userAddress()->delete();
            $user->attachments()->delete();
            $user->delete();
            DB::commit();

            return $this->handleSuccess('Successfully Deleted');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        abort_unless($user, 404, 'Not found');

        DB::beginTransaction();

        try {
            $user->restore();
            $user->employee()->restore();

            DB::commit();

            return $this->handleSuccess('Successfully Restored');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public static function updateByDesignation(string $designation, array $data)
    {
        return Employee::where('designation', $designation)->update($data);
    }

    public function createEmergencyContact(Employee $employee, array $data): bool
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }

            $data['employee_id'] = $employee->id;
            $data['created_by'] = auth()->id();
            $this->data = EmergencyContact::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateEmergencyContact(EmergencyContact $emergency, array $data): bool
    {
        try {
            $data['created_by'] = auth()->id();

            if (isset($data['image'])) {
                deleteFile($emergency->image);
                $data['image'] = Helper::uploadImage($data['image'], Enum::EMPLOYEE_CONTACT_PERSION_IMAGE, 200, 200);
            }

            $this->data = $emergency->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    // public function acceptStock(StockAssign $assign)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $data['received_by'] = auth()->id();
    //         $data['received_at'] = now();
    //         $data['acknowledgement_status'] = 1;
    //         $assign->update($data);

    //         // Do some extra staff if stock type is bulk
    //         $stock = $assign->stock;

    //         // Update product stock
    //         $product = $assign->stock->product;
    //         $product->stock -= $assign->quantity;
    //         $product->save();

    //         // Store stock history
    //         $assign['assign_id'] = $assign->id;
    //         $assign['location'] = $assign->stock->location;
    //         $assign['id'] = $assign->stock_id;
    //         $assign['action_status'] = 'Accepted';

    //         event(new StockHistoryEvent($assign));

    //         DB::commit();

    //         return $this->handleSuccess('Successfully Accepted');
    //     } catch (Exception $e) {
    //         Log::error($e->getMessage());
    //         DB::rollBack();

    //         return $this->handleException($e);
    //     }
    // }

    // public function stockStatusChange(Stock $stock, array $data)
    // {
    //     DB::beginTransaction();

    //     $findProduct = Product::where('id', $stock->product_id)->first();
    //     $quantity = 0;
    //     $status = '';
    //     $changeStatus = '';

    //     try {
    //         $types = $stock->categoryType->entry_type;

    //         if ($types == Enum::CATEGORY_INDIVIDUAL) {

    //             $status = $data['status'];
    //             $changeStatus = $status == Enum::STOCK_RETURN ? Enum::STOCK_AVAILABLE : $status;

    //             if ($status == Enum::STOCK_RETURN) {
    //                 $quantity = 1;
    //             }

    //             $stock->update([
    //                 'status' => $changeStatus,
    //             ]);

    //             $findAssignStock->update([
    //                 'status' => $status,
    //             ]);

    //             $findProduct->update([
    //                 'stock' => $findProduct->stock + $quantity,
    //             ]);
    //         } elseif ($types == Enum::CATEGORY_BULK) {

    //             $quantity = $data['quantity'];

    //             if ($data['status'] == Enum::STOCK_RETURN) {
    //                 $stock->update([
    //                     'status'   => $stock->quantity + $quantity == 0 ? Enum::STOCK_OUT : $stock->status,
    //                     'quantity' => $stock->quantity + $quantity,
    //                 ]);

    //                 $findProduct->update([
    //                     'stock' => $findProduct->stock + $quantity,
    //                 ]);
    //             }

    //             $findAssignStock->update([
    //                 'status'   => $findAssignStock->quantity - $quantity == 0 ? Enum::STOCK_OUT : $findAssignStock->status,
    //                 'quantity' => $findAssignStock->quantity - $quantity,
    //             ]);
    //         }

    //         $history = $stock;
    //         $history['assign_id'] = $findAssignStock->id;
    //         $history['status'] = $data['status'];
    //         $history['note'] = $data['note'];
    //         $history['type'] = $stock->product->category->categoryType->name;
    //         $history['quantity'] = $types == Enum::CATEGORY_BULK ? $data['quantity'] : $stock->quantity;

    //         $history['action_status'] = $this->actionStatus($data['status']);

    //         event(new StockHistoryEvent($history));

    //         DB::commit();
    //         $this->message = __('Successfully created');

    //         return $findAssignStock;
    //     } catch (Exception $e) {
    //         Helper::log($e);
    //         DB::rollBack();

    //         return $this->handleException($e);
    //     }
    // }

    public function actionStatus($status)
    {
        foreach (Enum::getStockStatus() as $key => $val) {
            if ($key == $status) {
                return $val;
            }
        }
    }

}
