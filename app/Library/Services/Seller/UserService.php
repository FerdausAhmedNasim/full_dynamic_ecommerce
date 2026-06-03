<?php

namespace App\Library\Services\Seller;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Store;
use App\Library\Helper;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use App\Library\Services\Admin\BaseService;

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
                $user->employee()->trainings()->delete();
                $user->employee()->attachments()->delete();
                $user->employee()->delete();
            } elseif ($user->isMember()) {
                $user->member()->attachments()->delete();
                $user->member()->delete();
            }

            deleteFile([$user->avatar, $user->photo_id, $user->emergency->image]);

            $user->emergency()->delete();
            $user->houseHold()->delete();
            $user->health()->delete();
            $user->address()->delete();
            $user->attachments()->delete();
            //$user->assigns()->delete();
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

            if ($user->isMember()) {
                $user->member()->restore();
            } elseif ($user->isEmployee()) {
                $user->employee()->restore();
            }

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

        if ($user->isEmployee()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.user.employee.index');
        } elseif ($user->isMember()) {
            abort_unless($auth_role->hasPermission($permission_suffix), 401, 'Permission denied');
            $redirect = route('admin.user.customer.index');
        }

        //This redirect variable will be used only for delete operation
        return $redirect;
    }

    //==================----- For User Profile -----=====================//
    public function updateProfile($data)
    {
        DB::beginTransaction();

        try {
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
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateProfilePassword($data)
    {
        try {
            authUser()->update([
                'password' => bcrypt($data['password']),
            ]);

            return $this->handleSuccess('Successfully Password Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateShop(array $data)
    {
        DB::beginTransaction();

        try {
            $user = authUser();
            // Store
            $store_lan = $data['store_lan'];

            $store_data = $data['store'];
            $store_data['slug'] = generateUniqueSlug($store_lan['store_name'], Store::class);

            unset($data['store']);
            $user->store->update($store_data);

            if (isset($store_data['logo'])) {
                $this->deleteFile($user->store, Enum::ATTACHMENT_TYPE_THUMBNAIL);
                attachmentStore($store_data['logo'], $user->store, Enum::STORE_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            if (isset($store_data['banner'])) {
                $this->deleteFile($user->store, Enum::ATTACHMENT_TYPE_BANNER);
                attachmentStore($store_data['banner'], $user->store, Enum::STORE_BANNER_IMAGE_DIR, Enum::ATTACHMENT_TYPE_BANNER);
            }

            // Store Language
            $store_lan['local'] = Enum::LANGUAGE_TYPE_ENGLISH;

            unset($data['store_lan']);
            $user->store->storeLanguages->where('local', 'en')->first()->update($store_lan);

            DB::commit();

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function deleteFile(Store $store, $type)
    {
        DB::beginTransaction();

        try {
            if($type == 'both') {
                deleteFile($store->getThumbnailAttribute());
                deleteFile($store->getBannerAttribute());
                $store->attachments()->delete();
            } else {
                if($type == Enum::ATTACHMENT_TYPE_THUMBNAIL) {
                    deleteFile($store->getThumbnailAttribute());
                } else {
                    deleteFile($store->getBannerAttribute());
                }
                $store->attachments()->where('for', $type)->delete();
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }
}
