<?php

namespace App\Library\Services\Seller;

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
use App\Library\Services\Admin\BaseService;

class TicketService extends BaseService
{
    private function filter(string $status = null, int $assign_to_id = null)
    {
        $query = Ticket::with('createBy', 'employee')->where('user_id', authSellerId());

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }


    private function actionHtml($row, $assign_to_id = null)
    {
        $actionHtml = '';

        if ($row->status != Enum::TICKET_STATUS_CLOSED) {
            if ($assign_to_id) {
                if (Helper::hasAuthRolePermission('seller_ticket_reply')) {
                    $btn = '<a href="' . route('seller.ticket.show', $row->id) . '" class="edit btn btn-sm btn-info pr-2"> <i class="fas fa-reply"></i> Reply </a>';
                }
            } else {
                if (Helper::hasAuthRolePermission('seller_ticket_reply')) {
                    $actionHtml .= '<a href="' . route('seller.ticket.show', $row->id) . '" class="dropdown-item text-primary"> <i class="fas fa-reply"></i> Reply </a>';
                }

                if (Helper::hasAuthRolePermission('seller_ticket_update')) {
                    $actionHtml .= '<a href="' . route('seller.ticket.update', $row->id) . '" class="dropdown-item text-secondary"> <i class="far fa-edit"></i> Edit</a>';
                }

                $btn = '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                    ' . $actionHtml . '
                    </div>
                </div>';

                return $btn;
            }
        } elseif ($row->status == Enum::TICKET_STATUS_CLOSED) {
            if (Helper::hasAuthRolePermission('seller_ticket_reopen')) {
                return $actionHtml .= '<a href="' . route('seller.ticket.reopen', $row->id) . '" class="edit btn btn-sm btn-info pr-2"> <i class="fas fa fa-envelope-open"></i> Reopen </a>';
            }
        } else {
            if (Helper::hasAuthRolePermission('seller_ticket_reply')) {
                return $actionHtml .= '<a href="javascript:void(0)" class="btn btn-sm btn2-secondary disabled"> <i class="fas fa-reply"></i> Reply </a>';
            }
        }
    }

    private function statusHtml($row)
    {
        $class = [
            Enum::TICKET_STATUS_OPEN   => 'badge-success',
            Enum::TICKET_STATUS_HOLD   => 'badge-info',
            Enum::TICKET_STATUS_CLOSED => 'badge-danger',
            Enum::TICKET_STATUS_NEW    => 'badge-warning',
        ];

        return '<div class="badge ' . $class[$row->status] . '">' . Enum::getTicketStatus($row->status) . '</div>';
    }

    public function dataTable(string $status)
    {
        $data = $this->filter($status);

        return Datatables::of($data)
                ->addColumn('priority', function ($row) {
                    return Enum::getTicketPriority($row->priority);
                })
                ->addColumn('subject', function ($row) {
                    return  '<a href="' . route('seller.ticket.show', $row->id) . '" class="text-success pr-2">' . $row->subject . '</a>';
                })
                ->addColumn('assign_to', function ($row) {
                    return $row->assign_to_id != null ? $row?->employee?->full_name : 'N/A';
                })
                ->addColumn('created_by', function ($row) {
                    return $row->created_by != null ? $row?->createBy?->full_name : 'N/A';
                })
                ->addColumn('last-reply', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('status', function ($row) {
                    return $this->statusHtml($row);
                })
                ->addColumn('created_at', function ($row) {
                    return getFormattedDateTime($row->created_at);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action', 'created_at', 'assign_to', 'subject' ,'status'])
                ->make(true);
    }

    public function countTicket()
    {
        $query = Ticket::select('status', DB::raw('count(*) as total'))
                            ->where('user_id', authSellerId());

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
            $data['full_name'] = authSeller()?->full_name;

            if (isset($data['attachment'])) {
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $data['ip'] = $ip;
            $data['location'] = $location ? $location->name : 'Remote';
            $data['user_id'] = authSellerId();
            $ticket_data = Ticket::create($data);

            $assign_data['assigned_to'] = 1;
            $assign_data['notes'] = "New Ticket Create";

            $this->ticketChangeAssignee($ticket_data, $assign_data);

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
            $data['full_name'] = authSeller()?->full_name;

            if (isset($data['attachment'])) {
                $data['attachment'] = Helper::uploadFile($data['attachment'], Enum::TICKET_ATTACHMENT_DIR);
            }

            $ticket->update($data);

            event(new CreatedEvent($ticket));
            DB::commit();

            return $this->handleSuccess('Successfully created', $ticket);
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
            $find_user = authSeller();
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
            $assigner = authSeller();
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

    public function ticketChangeStatus(Ticket $ticket, int $status)
    {
        try {
            $ticket->update(['status' => $status]);

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

}
