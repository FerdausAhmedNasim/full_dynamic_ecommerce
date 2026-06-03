<?php

namespace App\Library\Services\Admin\User;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Library\Enum;
use App\Models\Store;
use App\Library\Helper;
use App\Models\StoreLanguage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Library\Services\Admin\EmailService;

class SellerService extends BaseService
{
    private function filter(array $params)
    {
        $query = User::with('operator', 'store.storeLanguage')
                       ->where('users.user_type', Enum::USER_TYPE_SELLER);

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
            if (Helper::hasAuthRolePermission('seller_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.user.seller.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('seller_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.user.seller.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
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

    private function getActiveSwitch($row)
    {
        $is_disabled = "disabled";
        $route = '';
        $is_check = '';

        if (Helper::hasAuthRolePermission('seller_update') && !$row->deleted_at) {
            $is_check = $row?->store(true)?->active ? "checked" : "";
            $route = "'" . route('admin.user.seller.store.status.change', $row?->store(true)?->id) . "'";
            $is_disabled = "";
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeActiveStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="activeSwitch_' . $row->id . '" ' . $is_check . '  ' . $is_disabled . '>
                    <label class="custom-control-label" for="activeSwitch_' . $row->id . '"></label>
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
            $class = 'badge-danger';
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
            ->editColumn('name', function ($row) use ($user_role) {
                $name = $row?->full_name;

                return !Helper::hasAuthRolePermission('seller_show') || $row->deleted_at || $row->id == null ? $name : '<a href="' . route('admin.user.seller.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
            })

            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })

            ->editColumn('operator', function ($row) {
                return $row?->operator?->full_name;
            })

            ->editColumn('dob', function ($row) {
                return getFormattedDate($row->dob);
            })

            ->editColumn('status', function ($row) {
                return $this->statusHtml($row);
            })

            ->addColumn('shop_name', function ($row) {
                return $row?->store(true)?->getTranslation('store_name');
            })

            ->addColumn('shop_status', function ($row) {
                return $this->getActiveSwitch($row);
            })

            ->rawColumns(['name', 'status', 'action','shop_name','shop_status'])
            ->make(true);
    }

    public function createSeller(array $data): bool
    {
        DB::beginTransaction();

        try {
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = auth()->id();
            $user_data['status'] = Enum::USER_STATUS_PENDING;
            $user_data['password'] = bcrypt($user_data['password']);
            $user_data['user_type'] = Enum::USER_TYPE_SELLER;

            if (isset($user_data['avatar'])) {
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            unset($data['user']);
            $user = User::create($user_data);

            // Store
            $store_lan = $data['store_lan'];

            $store_data = $data['store'];
            $store_data['seller_id'] = $user->id;
            $store_data['slug'] = generateUniqueSlug($store_lan['store_name'], Store::class);

            unset($data['store']);
            $store = Store::create($store_data);

            if (isset($store_data['logo'])) {
                attachmentStore($store_data['logo'], $store, Enum::STORE_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            if (isset($store_data['banner'])) {
                attachmentStore($store_data['banner'], $store, Enum::STORE_BANNER_IMAGE_DIR, Enum::ATTACHMENT_TYPE_BANNER);
            }

            // Store Language
            $store_lan['local'] = Enum::LANGUAGE_TYPE_ENGLISH;
            $store_lan['store_id'] = $store->id;

            unset($data['store_lan']);
            StoreLanguage::create($store_lan);

            // Roles
            if (isset($data['role_id'])) {
                $user->roles()->attach($data['role_id']);
            }

            $dataForAdmin = [
                'email'   => config('app.admin_email'),
                'subject' => 'Seller Create',
                'message' => 'Seller Account Created Successfully.',
            ];
            EmailService::sendMail($dataForAdmin);

            if (!empty($user_data['email'])) {
                $dataForSeller = [
                    'email'   => $user_data['email'],
                    'subject' => 'Seller Create',
                    'message' => 'Create Your Account Successfully.',
                ];
            }
            EmailService::sendMail($dataForSeller);
            
            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function updateSeller(User $user, array $data)
    {
        DB::beginTransaction();
        $lang = 'en';

        try {
            $user_data = $data['user'];
            $user_data['phone'] = $data['mobile'];
            $user_data['dob'] = $data['dob'];
            $user_data['operator_id'] = auth()->id();

            if (isset($user_data['avatar'])) {
                deleteFile($user->avatar);
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            unset($data['user']);
            $user->update($user_data);

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
            $user->store->storeLanguages->where('local', $lang)->first()->update($store_lan);

            if (isset($data['role_id'])) {
                $user->roles()->detach();
                $user->roles()->attach($data['role_id']);
            }

            DB::commit();

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeShopStatus(Store $store): bool
    {
        try {
            $this->data = $store->update(['active' => !$store->active]);

            return $this->handleSuccess('Successfully Updated');
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

    //From Website
    public function becomeSellerRequest(array $data): bool
    {
        DB::beginTransaction();

        try {
            $user_data = $data['user'];
            $user_data['operator_id'] = auth()->id() ?? null;
            $user_data['status'] = Enum::USER_STATUS_PENDING;
            $user_data['password'] = bcrypt($user_data['password']);
            $user_data['user_type'] = Enum::USER_TYPE_SELLER;

            if (isset($user_data['avatar'])) {
                $user_data['avatar'] = Helper::uploadImage($user_data['avatar'], Enum::USER_AVATAR_DIR, 200, 200);
            }

            unset($data['user']);
            $user = User::create($user_data);

            // Roles
            $role = Role::where('for', 'seller')->first();
            $user->roles()->attach($role);
            $user->permissions()->attach($role->permissions);

            // Store
            $store_lan = $data['store_lan'];

            $store_data = $data['store'];
            $store_data['seller_id'] = $user->id;
            $store_data['slug'] = generateUniqueSlug($store_lan['store_name'], Store::class);

            unset($data['store']);
            $store = Store::create($store_data);

            if (isset($store_data['logo'])) {
                attachmentStore($store_data['logo'], $store, Enum::STORE_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            // Store Language
            $store_lan['local'] = Enum::LANGUAGE_TYPE_ENGLISH;
            $store_lan['store_id'] = $store->id;

            unset($data['store_lan']);
            StoreLanguage::create($store_lan);

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }
}
