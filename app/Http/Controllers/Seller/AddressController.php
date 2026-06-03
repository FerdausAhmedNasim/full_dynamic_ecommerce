<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
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

    public function store(User $user, AddressUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $user->id;

        $result = Address::create($data);

        if ($result) {
            return redirect(route('seller.moderator.show', $user?->employee->id) . '#address')->with('success', 'Successfully Created');
        }

        return back()->withInput($request->all())->with('error', 'Something is Wrong');
    }

    public function update(AddressUpdateRequest $request, Address $address): RedirectResponse
    {
        $result = $address->update($request->validated());
        $user = $address->user;

        if ($result) {
            return redirect(route('seller.moderator.show', $user?->employee->id) . '#address')->with('success', 'Successfully Updated');
        }

        return back()->withInput($request->all())->with('error', 'Something is Wrong');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $address->delete();

        return redirect()->route('address.index');
    }
}
