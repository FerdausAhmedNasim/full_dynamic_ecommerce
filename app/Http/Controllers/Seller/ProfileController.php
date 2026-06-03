<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Notification;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\UserService;
use App\Http\Requests\Seller\Profile\UpdateRequest;
use App\Http\Requests\Seller\Profile\UpdateShopRequest;
use App\Http\Requests\Seller\Profile\ProfileUpdatePasswordRequest;

class ProfileController extends Controller
{
    use ApiResponse;

    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function index()
    {
        return view('seller.pages.profile.index', [
            'user'     => authUser(),
            'address'  => authUser()->userAddress,
            'employee' => authUser()->employee,
        ]);
    }

    public function shop()
    {
        return view('seller.pages.profile.shop', [
            'user' => authUser()->load('store.storeLanguage')
        ]);
    }

    public function showUpdateForm()
    {
        $user = User::getAuthUser();

        return view('seller.pages.profile.update', [
            'user'            => $user,
            'employee'        => $user->employee,
            'address'         => $user->userAddress,
            'countries'       => Helper::getCountries(),
            'jobTitles'       => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employment_type' => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'genders'         => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'locations'       => getLocations(),
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->user_service->updateProfile($request->validated());

        if($result) {
            return redirect()->route('seller.profile.index')->with('success', $this->user_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->user_service->message);
    }

    public function showShopUpdateForm()
    {
        return view('seller.pages.profile.shop_update', [
            'seller' => authUser()->load('store.storeLanguage')
        ]);
    }

    public function updateShop(UpdateShopRequest $request)
    {
        $result = $this->user_service->updateShop($request->validated());

        if($result) {
            return redirect()->route('seller.profile.shop')->with('success', $this->user_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->user_service->message);
    }

    public function showUpdatePasswordForm()
    {
        return view('seller.pages.profile.update_password', [
            'user' => User::getAuthUser(),
        ]);
    }

    public function updatePassword(ProfileUpdatePasswordRequest $request)
    {
        $result = $this->user_service->updateProfilePassword($request->validated());

        if($result) {
            return redirect()->route('seller.profile.index')->with('success', $this->user_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->user_service->message);
    }

    public function showAllNotifications()
    {
        $notifications = Notification::where('is_for_emp', 1)->latest()->get();

        return view('admin.pages.profile.all_notification', [
            'notifications' => $notifications
        ]);
    }
}
