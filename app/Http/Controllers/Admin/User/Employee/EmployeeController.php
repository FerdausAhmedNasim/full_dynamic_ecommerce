<?php

namespace App\Http\Controllers\Admin\User\Employee;

use App\Models\Area;
use App\Models\Role;
use App\Library\Enum;
use App\Models\Thana;
use App\Library\Helper;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\TicketService;
use App\Http\Requests\Admin\Employee\CreateRequest;
use App\Http\Requests\Admin\Employee\UpdateRequest;
use App\Library\Services\Admin\User\EmployeeService;

class EmployeeController extends Controller
{
    use ApiResponse;

    private $employee_service;
    private $ticket_service;

    public function __construct(EmployeeService $employee_service, TicketService $ticket_service)
    {
        $this->employee_service = $employee_service;
        $this->ticket_service = $ticket_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);

            return $this->employee_service->dataTable($filter_request);
        }

        return view('admin.pages.user.employee.index');
    }

    public function show(Employee $employee)
    {
        abort_unless($employee->user, 404);

        $employee->load('user');
        $address = $employee?->user?->userAddress;

        return view('admin.pages.user.employee.show', [
            'employee'          => $employee,
            'user'              => $employee->user,
            'emergency_contact' => $employee?->user?->emergency,
            'user_id'           => $employee?->user_id,
            'user_household'    => $employee?->user?->houseHold,
            'countries'         => Helper::getCountries(),
            'stock_status'      => Enum::getStockStatus(),
            'health'            => $employee?->user?->health,
            'user_type'         => 'employee',
            'roles'             => Role::getEmployeeRoles(true),
            'address'           => $address->load('area.thana', 'area.district', 'area.division'),
            'count_total'       => $this->ticket_service->countUserTicket($employee?->user?->id),
            'divisions'         => Division::active()->get(),
            'districts'         => District::where('division_id', $address->area->division_id)->active()->get(),
            'thanas'            => Thana::where('district_id', $address->area->district_id)->active()->get(),
            'areas'             => Area::where('thana_id', $address->area->thana_id)->active()->get(),
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.user.employee.create', [
            'countries'       => Helper::getCountries(),
            'divisions'       => Division::active()->get(),
            'roles'           => Role::getEmployeeRoles(true),
            'genders'         => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'       => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes' => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'       => getLocations(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->employee_service->createEmployee($request->validated());

        if ($result) {
            return redirect()->route('admin.user.employee.index', $this->employee_service->data)->with('success', $this->employee_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }

    public function showUpdateForm(Employee $employee)
    {
        abort_unless($employee->user, 404);

        return view('admin.pages.user.employee.update', [
            'employee'        => $employee,
            'user'            => $employee->user,
            'countries'       => Helper::getCountries(),
            'roles'           => Role::getEmployeeRoles(true),
            'genders'         => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'jobTitles'       => getDropdown(Enum::CONFIG_DROPDOWN_JOB_TITLE),
            'employmentTypes' => getDropdown(Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS),
            'locations'       => getLocations(),

        ]);
    }

    public function update(UpdateRequest $request, Employee $employee)
    {
        abort_unless($employee->user, 404);

        $result = $this->employee_service->updateEmployee($employee, $request->validated());

        if ($result) {
            return redirect()->route('admin.user.employee.show', $employee->id)->with('success', $this->employee_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->employee_service->message);
    }

    public function securityUpdate(Employee $employee, Request $request)
    {
        abort_unless($employee->user, 404);

        $this->validate($request, [
            'role_id' => 'required',
        ]);

        $employee?->user?->roles()->sync($request->role_id);

        return redirect(route('admin.user.employee.show', $employee->id) . '#security')->with('success', 'Successfully Updated');
    }

    public function ticketIndex(Employee $employee, Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->userTicketDataTable($request->status, $employee?->user?->id);
        }

        return redirect(route('admin.user.employee.show', $employee->id) . '#ticket');
    }
}
