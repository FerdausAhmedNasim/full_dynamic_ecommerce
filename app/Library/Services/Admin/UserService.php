<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public function updatePassword(User $user, array $data)
    {
        $this->checkRolePermission($user, 'user_update_password');

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

    public function updateStatus(User $user, int $data)
    {
        $this->checkRolePermission($user, 'user_update_status');

        try {
            $user->update(['status' => $data]);

            // if($user->isSeller()) {
            //     $user->store->update(['active' => $data == 2 ? true : false]);
            // }

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
        if ($user->isEmployee()) {
            $user->employee()->delete();
        } elseif ($user->isCustomer()) {
            $user->delete();
        }
        // elseif ($user->isSeller()) {
        //     // $user->store->storeLanguage->delete();

        //     if(count($user->Products) >= 1) {
        //         return $this->handleFailed('Unable To Delete Seller has Product');
        //     }
        //     $user->store->delete();
        // }

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

        $this->checkRolePermission($user, 'user_restore');

        DB::beginTransaction();

        try {
            $user->restore();

            if ($user->isEmployee()) {
                $user->employee()->restore();
            } 
            // elseif ($user->isSeller()) {
            //     // $user->store->storeLanguage->delete();
            //     $user->store()->restore();
            // }

            DB::commit();

            return $this->handleSuccess('Successfully Restored');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function checkRolePermission(User $user, string $permission_suffix)
    {
        $auth_role = User::getAuthUser()->role();

        if ($user->isEmployee() || $user->isAdmin()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.user.employee.index');
        } elseif ($user->isMember()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.user.customer.index');
        } 
        // elseif ($user->isSeller()) {
        //     abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
        //     $redirect = route('admin.user.seller.index', $user->id);
        // }

        //This redirect variable will be used only for delete operation
        return $redirect;
    }

    //==================----- For User Profile -----=====================//
    public function updateProfile($data)
    {
        DB::beginTransaction();

        //try {
        $user = User::getAuthUser();
        $operator_id = auth()->id();

        // User
        $user_data = $data['user'];
        $user_data['dob'] = $data['dob'];
        $user_data['operator_id'] = $operator_id;

        if (isset($user_data['avatar'])) {
            deleteFile($user->avatar);
            $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
        }

        $data['operator_id'] = $operator_id;

        $user->update($user_data);
        unset($data['user']);

        // Address
        $address_data = $data['address'];
        $address_data['user_id'] = $user->id;
        $address_data['operator_id'] = $operator_id;

        if($user->address) {
            $user->address->update($address_data);
        } else {
            Address::create($address_data);
        }
        unset($data['address']);

        DB::commit();

        return $this->handleSuccess('Successfully Updated');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public function updateProfilePassword($data)
    {
        DB::beginTransaction();

        try {
            $user = User::getAuthUser();
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully Password Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
