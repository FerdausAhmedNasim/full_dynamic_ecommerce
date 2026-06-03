<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Models\Area;
use App\Library\Enum;
use App\Models\Thana;
use App\Models\Address;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Public\Address\CreateRequest;
use App\Http\Requests\Public\Address\UpdateRequest;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('user', 'area.thana', 'area.district', 'area.division')->where('user_id', authUser()->id)->get();

        return view('public.member_dashboard.address.index', [
            'addresses' => $addresses
        ]);
    }

    public function showCreateForm()
    {
        return view('public.member_dashboard.address.create');
    }

    public function divisionWiseDistrict(Request $request)
    {
        $districts = District::where('division_id', (int)$request->division_id)->where('active', true)->get();
        $options = '';

        if (count($districts) > 0) {
            $options = '<option value="" disabled selected="">Choose Your District</option>';

            foreach ($districts as $district) {
                $options .= '<option value="' . $district->id . '">
                    ' . $district->en_name . '
                </option>';
            }
        }

        return json_encode($options);
    }

    public function districtWiseThana(Request $request)
    {
        $thanas = Thana::where('district_id', (int)$request->district_id)
            ->where('active', true)->get();
        $options = '';

        if (count($thanas) > 0) {
            $options = '<option value="" disabled selected="">Choose Your Thana</option>';

            foreach ($thanas as $thana) {
                $options .= '<option value="' . $thana->id . '">
                    ' . $thana->en_name . '
                </option>';
            }
        }

        return json_encode($options);
    }

    public function thanaWiseArea(Request $request)
    {
        $areas = Area::where('thana_id', (int)$request->thana_id)
            ->where('active', true)->get();
        $options = '';

        if (count($areas) > 0) {
            $options = '<option value="" disabled selected="">Choose Your Area</option>';

            foreach ($areas as $area) {
                $options .= '<option value="' . $area->id . '">
                    ' . $area->en_name . '
                </option>';
            }
        }

        return json_encode($options);
    }

    public function createAddress(CreateRequest $request)
    {
        abort_unless(authUser(), 404);
        $oldAddress = Address::where('user_id', authUser()->id)->get();
        
        $data = $request->validated();
        $data['primary'] = count($oldAddress) < 1 ? Enum::DEFAULT_SHIPPING_ACTIVE : Enum::DEFAULT_SHIPPING;
        $data['location'] = Address::determineLocation($data);

        $result = Address::create($data);

        if ($result) {
            return redirect()->back()->with("success", "Successfully Created");
        }

        return back()->withInput($request->all())->with('error');
    }

    public function showUpdateForm(Address $address)
    {
        return view('public.member_dashboard.address.update', [
            "address"   => $address,
            'divisions' => Division::active()->get(),
            'districts' => District::where('division_id', $address->area->division_id)->active()->get(),
            'thanas'    => Thana::where('district_id', $address->area->district_id)->active()->get(),
            'areas'     => Area::where('thana_id', $address->area->thana_id)->active()->get(),
        ]);
    }

    public function updateAddress(UpdateRequest $request, Address $address)
    {
        abort_unless(authUser(), 404);

        $data = $request->validated();
        $data['location'] = Address::determineLocation($data);

        $result = $address->update($data);

        if ($result) {
            return redirect()->back()->with("success", "Successfully Update Address");
        }

        return back()->withInput($request->all())->with('error', "Address Not Updated");
    }

    public function makeDefaultShipping(Address $address)
    {
        abort_unless($address, 404);

        if ($address->primary) {
            return redirect()->route('dashboard.address.index', ["addresses" => Address::where('user_id', authUser()->id)->get()])->with("success");
        }
        $defaultShipping_address = Address::where("primary", Enum::DEFAULT_SHIPPING_ACTIVE)->where("user_id", authUser()->id)->first();
        $address['primary'] = Enum::DEFAULT_SHIPPING_ACTIVE;

        if ($defaultShipping_address) {
            $defaultShipping_address['primary'] = Enum::DEFAULT_SHIPPING;
            $defaultShipping_address->update();
        }
        $result = $address->update();

        if ($result) {
            return redirect()->route('dashboard.address.index', ["addresses" => Address::where('user_id', authUser()->id)->get()])->with("success");
        }

        return back()->withInput([$address])->with('error');
    }

    public function destroy(Address $address): RedirectResponse
    {
        abort_unless($address, 404);
        $address->delete();

        return redirect()->route('dashboard.address.index', [
            "addresses" => Address::where('user_id', authUser()->id)->get()
        ])->with('success', "Successfully Delete");
    }
}
