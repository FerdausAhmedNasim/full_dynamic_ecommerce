<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Address;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Address\AddressUpdateRequest;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = Address::all();

        return view('address.index', compact('addresses'));
    }

    public function store($user_type, AddressUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $user_type;

        $result = Address::create($data);
        $user = $result->user;

        if ($result) {
            if ($user->user_type == Enum::USER_TYPE_EMPLOYEE) {
                return redirect(route('admin.user.employee.show', $user?->employee->id) . '#address')->with('success', 'Successfully Updated');
            } elseif ($user->user_type == Enum::USER_TYPE_CUSTOMER || $user->user_type == Enum::USER_TYPE_DAY_MEMBER) {
                return redirect(route('admin.member.show.address', $user?->member->id))->with('success', 'Successfully Updated');
            } elseif ($user->user_type == Enum::USER_TYPE_SKIPPER) {
                return redirect(route('admin.skipper.show.address', $user?->id))->with('success', 'Successfully Updated');
            } else {
                return redirect()->back()->with('success', 'Successfully Updated');
            }
        }

        return back()->withInput($request->all())->with('error', 'Something is Wrong');
    }

    public function update($user_type, AddressUpdateRequest $request, Address $address): RedirectResponse
    {
        $result = $address->update($request->validated());
        $user = $address->user;

        if ($result) {
            if ($user->user_type == Enum::USER_TYPE_EMPLOYEE) {
                return redirect(route('admin.user.employee.show', $user?->employee->id) . '#address')->with('success', 'Successfully Updated');
            } elseif ($user->user_type == Enum::USER_TYPE_CUSTOMER || $user->user_type == Enum::USER_TYPE_DAY_MEMBER) {
                return redirect(route('admin.member.show.address', $user?->member->id))->with('success', 'Successfully Updated');
            } elseif ($user->user_type == Enum::USER_TYPE_SKIPPER) {
                return redirect(route('admin.skipper.show.address', $user?->id))->with('success', 'Successfully Updated');
            } else {
                return redirect()->back()->with('success', 'Successfully Updated');
            }
        }

        return back()->withInput($request->all())->with('error', 'Something is Wrong');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $address->delete();

        return redirect()->route('address.index');
    }
}
