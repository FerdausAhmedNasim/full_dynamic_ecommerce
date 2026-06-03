<?php

namespace App\Library\Services\Seller;

use Exception;
use App\Library\Enum;
use App\Models\Payout;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Library\Services\Admin\EmailService;

class PayoutService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.payout.delete', $row->id);

        if ($row->id) {

            if ($row->status == Enum::PAYOUT_STATUS_PENDING ) {
                
                if (Helper::hasAuthRolePermission('seller_payout_update')) {
                    $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="clickEditModal(' . $row->id . ')" ><i class="far fa-edit"></i> Edit</a>';
                }
    
                if (Helper::hasAuthRolePermission('seller_payout_delete')) {
                    $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
                }
                
            }
            else{
                return "<h4 class='text-center m-0 text-gray'>N/A</h4>";
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

    public function dataTable()
    {
        $data = Payout::with('seller', 'approvedBy')->where('seller_id', authSellerId())->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return getFormattedDateTime($row->created_at);
                })
                ->editColumn('amount', function ($row) {
                    return getFormattedAmount($row->amount);
                })
                ->editColumn('note', function ($row) {
                    return $this->getNote($row);
                })
                ->editColumn('approved_by', function ($row) {
                    return $row?->approvedBy?->full_name ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $this->statusHtml($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['note', 'status', 'action'])
                ->make(true);
    }

    public function getNote($row)
    {
        $html = '';
        $note = substr($row->note, 0, 30);
        $html .= "<span>$note</span>";

        $noteLength = strlen($row->note);

        if ($noteLength > 30) {
            $html .= '...<button type="button" class="btn p-0 text-primary" onClick="readMore(\''.$row->note.'\')">Read More</button>';
        }
        
        return $html;
    }

    private function statusHtml($row)
    {
        $class = [
            Enum::PAYOUT_STATUS_PENDING    => 'badge-warning',
            Enum::PAYOUT_STATUS_APPROVED   => 'badge-success',
            Enum::PAYOUT_STATUS_REJECTED   => 'badge-danger',
        ];

        return '<div class="badge ' . $class[$row->status] . '">' . Enum::getPayoutStatusType($row->status) . '</div>';
    }

    public function store(array $data): bool
    {
        try {
            $data['seller_id'] = authSellerId();

            $this->data = Payout::create($data);

            $data = [
                'user_id' => authSellerId(),
                'email'   => config('app.admin_email'),
                'subject' => 'Payout Request',
                'message' => $this->getEmailBodyMessage($data),
            ];
    
            EmailService::sendMail($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Payout $payout, array $data): bool
    {
        try {
            $this->data = $payout->update($data);

            $data = [
                'user_id' => authSellerId(),
                'email'   => config('app.admin_email'),
                'subject' => 'Payout Request',
                'message' => $this->getEmailBodyMessage($data),
            ];
    
            EmailService::sendMail($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Payout $payout): bool
    {
        try {
            $payout->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function getEmailBodyMessage($data)
    {
        $html = '';
        $html .= '<p>Seller Name: '. authSeller()->full_name .'</p>';
        $html .= '<p>Amount: '. getFormattedAmount($data['amount']) .'</p>';
        $html .= '<p>Date: '. getFormattedDateTime(now()) .'</p>';
        $html .= '<p>Note: '. $data['note'] .'</p>';

        return $html;
    }
}
