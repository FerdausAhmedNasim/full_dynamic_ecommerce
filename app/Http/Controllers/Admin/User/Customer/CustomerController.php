<?php

namespace App\Http\Controllers\Admin\User\Customer;

use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\CreateRequest;
use App\Http\Requests\Admin\Member\UpdateRequest;
use App\Library\Services\Admin\User\CustomerService;

class CustomerController extends Controller
{
    use ApiResponse;

    private $customer_service;

    public function __construct(CustomerService $customer_service)
    {
        $this->customer_service = $customer_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);

            return $this->customer_service->dataTable($filter_request);
        }

        return view('admin.pages.user.customer.index');
    }

    public function show(User $user)
    {
        abort_unless($user, 404);

        return view('admin.pages.user.customer.show', compact('user'));
    }

    public function showCreateForm()
    {
        return view('admin.pages.user.customer.create', [
            'countries' => Helper::getCountries(),
            'genders'   => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->customer_service->createMember($request->validated());

        if ($result) {
            return redirect()->route('admin.user.customer.index')->with('success', $this->customer_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->customer_service->message);
    }

    public function showUpdateForm(User $user)
    {
        abort_unless($user, 404);

        return view('admin.pages.user.customer.edit', [
            'user'      => $user,
            'countries' => Helper::getCountries(),
            'genders'   => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
        ]);
    }

    public function update(User $user, UpdateRequest $request)
    {
        abort_unless($user, 404);
        $result = $this->customer_service->updateMember($user, $request->validated());

        if ($result) {
            return redirect()->route('admin.user.customer.index')->with('success', $this->customer_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->customer_service->message);
    }
}
