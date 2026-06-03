<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Models\Ticket;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\TicketService;
use App\Http\Requests\Admin\Ticket\ReplyRequest;
use App\Http\Requests\Admin\Ticket\CreateRequest;
use App\Http\Requests\Admin\Ticket\UpdateRequest;
use App\Http\Requests\Admin\Ticket\UpdateAssignToRequest;

class TicketController extends Controller
{
    use ApiResponse;
    private $ticket_service;

    public function __construct(TicketService $ticket_service)
    {
        $this->ticket_service = $ticket_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->allTicketDataTable($request->status, 'my-ticket');
        }

        $count_total = $this->ticket_service->countTicket('my-ticket');

        return view('admin.pages.ticket.my_tickets', compact('count_total'));
    }

    public function allTickets(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticket_service->allTicketDataTable($request->status);
        }

        $count_total = $this->ticket_service->countTicket();

        return view('admin.pages.ticket.all_tickets', compact('count_total'));
    }

    public function showCreateForm()
    {
        return view('admin.pages.ticket.create', [
            'employees' => User::with('operator')
                        ->where('user_type', Enum::USER_TYPE_EMPLOYEE)
                        ->where('status', Enum::USER_STATUS_ACTIVE)
                        ->get(),
            'organizations' => [],
            'departments'   => getDropdown(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->ticket_service->createTicket($request->validated(), $request->ip());

        if ($result) {
            return redirect()->route('admin.ticket.all')->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function showUpdateForm(Ticket $ticket)
    {
        abort_unless($ticket, 404);

        return view('admin.pages.ticket.update', [
            'ticket'      => $ticket,
            'employees'   => User::with('operator')
                            ->where('user_type', Enum::USER_TYPE_EMPLOYEE)
                            ->where('status', Enum::USER_STATUS_ACTIVE)
                            ->get(),
            'departments' => getDropdown(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT)
        ]);
    }

    public function update(Ticket $ticket, UpdateRequest $request)
    {
        abort_unless($ticket->user, 404);
        $result = $this->ticket_service->updateTicket($ticket, $request->validated());

        if($result) {
            return redirect()->route('admin.ticket.all')->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function show(Ticket $ticket)
    {
        return view('admin.pages.ticket.show', [
            'ticket_assigns'  => $ticket->load('assigns.replies.user')->assigns,
            'employees'       => Employee::getEmployeeByStatus(Enum::USER_STATUS_ACTIVE),
            'ticket'          => $ticket,
            'solution_hour'   => (int)($ticket->replies->sum('solution_time') / 60),
            'solution_minute' => $ticket->replies->sum('solution_time') % 60 ,
        ]);
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        $result = $this->ticket_service->replyTicket($ticket, $request->validated());

        if ($result) {
            return redirect()->route('admin.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function changeAssignee(Ticket $ticket, UpdateAssignToRequest $request)
    {
        $result = $this->ticket_service->ticketChangeAssignee($ticket, $request->validated());

        if ($result) {
            return redirect()->route('admin.ticket.index')->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function changeStatus(Ticket $ticket, Request $request)
    {
        $result = $this->ticket_service->ticketChangeStatus($ticket->id, $request->status);

        if ($result) {
            return redirect()->route('admin.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function reOpen(Ticket $ticket)
    {
        $result = $this->ticket_service->ticketReOpen($ticket);

        if ($result) {
            return redirect()->route('admin.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->with('error', $this->ticket_service->message);
    }

}
