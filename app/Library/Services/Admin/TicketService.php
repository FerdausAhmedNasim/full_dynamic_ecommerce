<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Ticket;
use App\Library\Helper;
use App\Models\Location;
use App\Models\TicketReply;
use App\Models\TicketAssign;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\Ticket\CreatedEvent;
use App\Events\Ticket\RepliedEvent;
use App\Events\Ticket\AssignedEvent;
use Yajra\DataTables\Facades\DataTables;

class TicketService extends BaseService
{
    private function filter(string $status = null, string $type = null)
    {
        $query = Ticket::with('employee', 'createBy')
            ->when($type === 'my-ticket', function ($query) {
                return $query->where('assign_to_id', auth()->id());
            });

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = $row->created_by == User::getAuthUser()->id ? route('admin.ticket.update', $row->id) : '#';

        if ($row->id) {
            if ($row->status != Enum::TICKET_STATUS_CLOSED && Helper::hasAuthRolePermission('ticket_reply')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ticket.show', $row->id) . '" ><i class="fas fa-reply"></i> Reply </a>';
            }

            if (Helper::hasAuthRolePermission('ticket_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . $route . '" ><i class="fa fa-edit"></i> Edit </a>';
            }

            if ($row->status == Enum::TICKET_STATUS_CLOSED && Helper::hasAuthRolePermission('ticket_reopen')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ticket.reopen', $row->id) . '"> <i class="fas fa fa-envelope-open"></i> Reopen </a>';
            }
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    private function statusHtml($row)
    {
        $statusClassMapping = [
            Enum::TICKET_STATUS_OPEN   => 'badge-success',
            Enum::TICKET_STATUS_HOLD   => 'badge-warning',
            Enum::TICKET_STATUS_CLOSED => 'badge-danger',
            Enum::TICKET_STATUS_NEW    => 'badge-info',
        ];

        $status = $row->status;
        $class = $statusClassMapping[$status] ?? 'badge-secondary';
        $statusText = Enum::getTicketStatus($status);

        return '<div class="badge ' . $class . '">' . $statusText . '</div>';
    }

    public function allTicketDataTable(string $status, string $type = null)
    {
        $data = $this->filter($status, $type);
        $user_role = User::getAuthUserRole();

        return Datatables::of($data)
            ->addColumn('priority', function ($row) {
                return Enum::getTicketPriority($row->priority);
            })
            ->addColumn('subject', function ($row) {
                if (Helper::hasAuthRolePermission('ticket_show')) {
                    return  '<a href="' . route('admin.ticket.show', $row->id) . '" class="text-success pr-2">' . $row->subject . '</a>';
                } 

                return $row->subject;
            })
            ->addColumn('assign_to', function ($row) {
                return $row->assign_to_id != null ? $row?->employee?->full_name : 'N/A';
            })
            ->addColumn('created_by', function ($row) {
                return $row->created_by != null ? $row?->createBy?->full_name : 'N/A';
            })
            ->addColumn('last-reply', function ($row) {
                $lr = $row->updated_at->diffForHumans();

                return $lr;
            })
            ->addColumn('status', function ($row) {
                return $this->statusHtml($row);
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })
            ->rawColumns(['action', 'created_at', 'assign_to', 'subject', 'status'])
            ->make(true);
    }

    public function countTicket(string $type = null)
    {
        $query = Ticket::select('status', DB::raw('count(*) as total'));

        if ($type == 'my-ticket') {
            $query->where('assign_to_id', auth()->id());
        }

        $data = $query->groupBy('status')->pluck('total', 'status')->toArray();
        $total = Enum::getTicketStatus();

        foreach ($total as $key => $value) {
            $total[$key] = $data[$key] ?? 0;
        }

        return $total;
    }

    public function createTicket(array $data, $ip): bool
    {
        DB::beginTransaction();

        try {
            $location = Location::where('ip', $ip)->first();
            $find_user = User::find($data['user_id']);
            $data['full_name'] = $find_user?->full_name;

            if (isset($data['attachment'])) {
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $data['ip'] = $ip;
            $data['location'] = $location ? $location->name : 'Remote';

            $ticket_data = Ticket::create($data);

            $assign_data['assigned_to'] = auth()->id();
            $assign_data['notes'] = "New Ticket Create";

            $this->ticketChangeAssignee($ticket_data, $assign_data);

            if (auth()->user()->user_type == Enum::USER_TYPE_SUPER_ADMIN) {
                $data['status'] = (string) Enum::TICKET_STATUS_NEW;
            }

            event(new CreatedEvent($ticket_data));

            DB::commit();

            return $this->handleSuccess('Successfully created', $ticket_data);
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function updateTicket(Ticket $ticket, array $data): bool
    {
        DB::beginTransaction();

        try {
            $find_user = User::find($data['user_id']);
            $data['full_name'] = $find_user?->full_name;

            if (isset($data['attachment'])) {
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $ticket->update($data);

            event(new CreatedEvent($ticket));
            DB::commit();

            return $this->handleSuccess('Successfully updated', $ticket);
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function replyTicket(Ticket $ticket, array $data)
    {
        DB::beginTransaction();

        try {
            $find_user = User::getAuthUser();
            $data['user_id'] = $find_user->id;
            $data['user_name'] = $find_user?->full_name;
            $data['is_admin_reply'] = $find_user->user_type == 'admin' ? 1 : 0;
            $data['ticket_assign_id'] = $ticket->assign_id;
            $data['ticket_id'] = $ticket->id;

            if (isset($data['attachment'])) {
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $ticket_data = TicketReply::create($data);

            event(new RepliedEvent($ticket_data));

            $ticket->updated_at = Carbon::now();
            $ticket->save();

            DB::commit();

            return $this->handleSuccess('Successfully Replied', $ticket_data);
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function ticketChangeAssignee(Ticket $ticket, array $data)
    {
        DB::beginTransaction();

        try {
            $status = Enum::TICKET_STATUS_OPEN;

            if ($data['assigned_to'] == 1) {
                $status = Enum::TICKET_STATUS_NEW;
            }

            $ticket->update([
                'status' => (string) $status,
            ]);

            $assigner = User::getAuthUser();
            $data['assigned_by'] = $assigner->id;
            $data['assigned_by_name'] = $assigner?->full_name;

            $assignee = User::find($data['assigned_to']);
            $data['assign_to_name'] = $assignee?->full_name;

            $data['ticket_id'] = $ticket->id;

            $assign_data = TicketAssign::create($data);

            $ticket_data = $ticket->update([
                'assign_to_id' => $data['assigned_to'],
                'assign_id'    => $assign_data->id,
            ]);

            event(new AssignedEvent($ticket));

            DB::commit();

            return $this->handleSuccess('Successfully Updated', $ticket_data);
        } catch (Exception $e) {
            Helper::log($e);
            DB::rollBack();

            return $this->handleException($e);
        }
    }

    public function ticketChangeStatus(int $ticket, string $status)
    {
        $ticket = Ticket::find($ticket);

        try {
            $ticket->status = $status;
            $ticket->save();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function ticketReOpen(Ticket $ticket)
    {
        try {
            $this->data = $ticket->update(['status' => Enum::TICKET_STATUS_OPEN]);

            return $this->handleSuccess('Successfully Re-Opened');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }



    // User / Employee Ticket
    private function filterUserTicket(string $status = null, $user_id)
    {
        $query = Ticket::with('employee', 'createBy')

        ->where(function ($query) use ($user_id) {
            $query->where('assign_to_id', $user_id)
                  ->orWhere('user_id', $user_id);
        });

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function userTicketDataTable(string $status, $user_id)
    {
        $data = $this->filterUserTicket($status, $user_id);
        $user_role = User::getAuthUserRole();

        return Datatables::of($data)
            ->addColumn('priority', function ($row) {
                return Enum::getTicketPriority($row->priority);
            })
            ->addColumn('subject', function ($row) {
                return  '<a href="' . route('admin.ticket.show', $row->id) . '" class="text-success pr-2">' . $row->subject . '</a>';
            })
            ->addColumn('assign_to', function ($row) {
                return $row->assign_to_id != null ? $row?->employee?->full_name : 'N/A';
            })
            ->addColumn('created_by', function ($row) {
                return $row->created_by != null ? $row?->createBy?->full_name : 'N/A';
            })
            ->addColumn('last-reply', function ($row) {
                $lr = $row->updated_at->diffForHumans();

                return $lr;
            })
            ->addColumn('status', function ($row) {
                return $this->statusHtml($row);
            })
            ->addColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->addColumn('action', function ($row) use ($user_role) {
                return $this->actionHtml($row, $user_role);
            })
            ->rawColumns(['action', 'created_at', 'assign_to', 'subject', 'status'])
            ->make(true);
    }

    public function countUserTicket($user_id)
    {
        $query = Ticket::select('status', DB::raw('count(*) as total'));

        $query->where('assign_to_id', $user_id)->orWhere('user_id', $user_id);

        $data = $query->groupBy('status')->pluck('total', 'status')->toArray();
        $total = Enum::getTicketStatus();

        foreach ($total as $key => $value) {
            $total[$key] = $data[$key] ?? 0;
        }

        return $total;
    }
}
