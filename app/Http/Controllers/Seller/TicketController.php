<?php

namespace App\Http\Controllers\Seller;

use App\Library\Enum;
use App\Models\Ticket;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Seller\TicketService;
use App\Http\Requests\Seller\Ticket\ReplyRequest;
use App\Http\Requests\Seller\Ticket\CreateRequest;
use App\Http\Requests\Seller\Ticket\UpdateRequest;

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
            return $this->ticket_service->dataTable($request->status);
        }

        $count_total = $this->ticket_service->countTicket();

        return view('seller.pages.ticket.index', compact('count_total'));
    }

    public function showCreateForm()
    {
        return view('seller.pages.ticket.create', [
            'employees'     => Employee::getEmployeeByStatus(Enum::USER_STATUS_ACTIVE),
            'organizations' => [],
            'departments'   => getDropdown(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->ticket_service->createTicket($request->validated(), $request->ip());

        if ($result) {
            return redirect()->route('seller.ticket.index')->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function showUpdateForm(Ticket $ticket)
    {
        abort_unless($ticket->user_id == authSellerId(), 404);
        abort_unless($ticket, 404);

        return view('seller.pages.ticket.update', [
            'ticket'      => $ticket,
            'employees'   => Employee::getEmployeeByStatus(Enum::USER_STATUS_ACTIVE),
            'departments' => getDropdown(Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT),
        ]);
    }

    public function update(Ticket $ticket, UpdateRequest $request)
    {
        abort_unless($ticket->user_id == authSellerId(), 404);
        abort_unless($ticket->user, 404);

        $result = $this->ticket_service->updateTicket($ticket, $request->validated());

        if ($result) {
            return redirect()->route('seller.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function show(Ticket $ticket)
    {
        abort_unless($ticket->user_id == authSellerId(), 404);

        return view('seller.pages.ticket.show', [
            'ticket_assigns'  => $ticket->load('assigns.replies.user')->assigns,
            'employees'       => Employee::getEmployeeByStatus(Enum::USER_STATUS_ACTIVE),
            'ticket'          => $ticket,
            'solution_hour'   => (int)($ticket->replies->sum('solution_time') / 60),
            'solution_minute' => $ticket->replies->sum('solution_time') % 60,
        ]);
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        abort_unless($ticket->user_id == authSellerId(), 404);

        $result = $this->ticket_service->replyTicket($ticket, $request->validated());

        if ($result) {
            return redirect()->route('seller.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function changeStatus(Ticket $ticket, Request $request)
    {
        $result = $this->ticket_service->ticketChangeStatus($ticket, $request->status);

        if ($result) {
            return redirect()->route('seller.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ticket_service->message);
    }

    public function reOpen(Ticket $ticket)
    {
        $result = $this->ticket_service->ticketReOpen($ticket);

        if ($result) {
            return redirect()->route('seller.ticket.show', $ticket->id)->with('success', $this->ticket_service->message);
        }

        return back()->with('error', $this->ticket_service->message);
    }
}
