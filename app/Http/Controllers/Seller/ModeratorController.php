<?php

namespace App\Http\Controllers\Seller;

use App\Models\Area;
use App\Models\Role;
use App\Models\User;
use App\Library\Enum;
use App\Models\Thana;
use App\Library\Helper;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\TicketService;
use App\Library\Services\Seller\ModeratorService;
use App\Http\Requests\Seller\Moderator\CreateRequest;
use App\Http\Requests\Seller\Moderator\UpdateRequest;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;

class ModeratorController extends Controller
{
    use ApiResponse;
    private $moderator_service;
    private $ticket_service;

    public function __construct(ModeratorService $moderator_service, TicketService $ticket_service)
    {
        $this->moderator_service = $moderator_service;
        $this->ticket_service = $ticket_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);

            return $this->moderator_service->dataTable($filter_request);
        }

        return view('seller.pages.moderator.index');
    }

    public function show(Employee $employee)
    {
        abort_unless($employee->user, 404);
        $employee->load('user');
        $address = $employee?->user?->userAddress;

        return view('seller.pages.moderator.show', [
            'employee'          => $employee,
            'user'              => $employee->user,
            'emergency_contact' => $employee?->user?->emergency,
            'user_id'           => $employee?->user_id,
            'user_household'    => $employee?->user?->houseHold,
            'countries'         => Helper::getCountries(),
            'stock_status'      => Enum::getStockStatus(),
            'health'            => $employee?->user?->health,
            'user_type'         => 'employee',
            'roles'             => Role::where('seller_id', authSellerId())->get(),
            'address'           => $employee?->user?->userAddress,
            'count_total'       => 0,
            'divisions'         => Division::active()->get(),
            'districts'         => District::where('division_id', $address->area->division_id)->active()->get(),
            'thanas'            => Thana::where('district_id', $address->area->district_id)->active()->get(),
            'areas'             => Area::where('thana_id', $address->area->thana_id)->active()->get(),
        ]);
    }

    public function showCreateForm()
    {
        return view('seller.pages.moderator.create', [
            'countries'       => Helper::getCountries(),
            'roles'           => Role::where('seller_id', authSellerId())->get(),
            'genders'         => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'       => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes' => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'       => getLocations(),
            'divisions'       => Division::active()->get(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->moderator_service->create($request->validated());

        if ($result) {
            return redirect()->route('seller.moderator.index', $this->moderator_service->data)->with('success', $this->moderator_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->moderator_service->message);
    }

    public function showUpdateForm(Employee $employee)
    {
        abort_unless($employee->user, 404);

        return view('seller.pages.moderator.update', [
            'employee'        => $employee,
            'user'            => $employee->user,
            'countries'       => Helper::getCountries(),
            'roles'           => Role::where('seller_id', authSellerId())->get(),
            'genders'         => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'       => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes' => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'       => getLocations(),
        ]);
    }

    public function update(Employee $employee, UpdateRequest $request)
    {
        abort_unless($employee->user, 404);
        $result = $this->moderator_service->updateEmployee($employee, $request->validated());

        if ($result) {
            return redirect()->route('seller.moderator.show', $employee->id)->with('success', $this->moderator_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->moderator_service->message);
    }

    public function updateStatusApi(Request $request, User $user)
    {
        $result = $this->moderator_service->updateStatus($user, $request->status);

        if($request->ajax()) {
            return $result ? Response::success($this->moderator_service->message) : Response::error($this->moderator_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->moderator_service->message);
    }

    public function updatePasswordApi(User $user, UpdatePasswordRequest $request)
    {
        $result = $this->moderator_service->updatePassword($user, $request->validated());

        if($request->ajax()) {
            return $result ? Response::success($this->moderator_service->message) : Response::error($this->moderator_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->moderator_service->message);
    }

    public function deleteApi(Request $request, User $user)
    {
        if (count($user->orders)) {
            if ($request->ajax()) {
                return Response::error('Customer could not deleted because of having orders.');
            }

            return redirect()->back()->with('error', 'Customer could not deleted because of having orders.');
        }

        $result = $this->moderator_service->deleteUser($user);

        if($request->ajax()) {
            return $result ? Response::success($this->moderator_service->message) : Response::error($this->moderator_service->message);
        }

        return redirect()->route('seller.moderator.index')->with($result ? 'success' : 'error', $this->moderator_service->message);
    }

    public function restoreApi(Request $request, $id)
    {
        $result = $this->moderator_service->restoreUser($id);

        if($request->ajax()) {
            return $result ? Response::success($this->moderator_service->message) : Response::error($this->moderator_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->moderator_service->message);
    }

    public function securityUpdate(Employee $employee, Request $request)
    {
        abort_unless($employee->user, 404);

        $this->validate($request, [
            'role_id' => 'required',
        ]);

        $employee?->user?->roles()->sync($request->role_id);

        return redirect(route('seller.moderator.show', $employee->id) . '#security')->with('success', 'Successfully Updated');
    }

    public function ticketIndex(Employee $employee, Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->userTicketDataTable($request->status, $employee?->user?->id);
        }

        return redirect(route('seller.moderator.show', $employee->id) . '#ticket');
    }
}
