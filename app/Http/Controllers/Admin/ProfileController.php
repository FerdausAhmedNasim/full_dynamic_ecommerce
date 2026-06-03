<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Notification;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\UserService;
use App\Http\Requests\Admin\Profile\UpdateRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdatePasswrdRequest;

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
        $user = User::find(User::getAuthUser()->id);

        return view('admin.pages.profile.index', [
            'user'     => $user,
            'address'  => $user->address,
            'employee' => $user->employee,
        ]);
    }

    public function showUpdateForm()
    {
        $user = User::getAuthUser();

        return view('admin.pages.profile.update', [
            'user'               => $user,
            'employee'           => $user->employee,
            'address'            => $user->userAddress,
            'countries'          => Helper::getCountries(),
            'jobTitles'          => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employment_type'    => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'genders'            => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'locations'          => getLocations(),
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->user_service->updateProfile($request->validated());

        if($result) {
            return redirect()->route('admin.profile.index')->with('success', $this->user_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->user_service->message);
    }


    public function showUpdatePasswordForm()
    {
        return view('admin.pages.profile.update_password', [
            'user' => User::getAuthUser(),
        ]);
    }

    public function updatePassword(ProfileUpdatePasswrdRequest $request)
    {
        $result = $this->user_service->updateProfilePassword($request->validated());

        if($result) {
            return redirect()->route('admin.profile.index')->with('success', $this->user_service->message);
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
