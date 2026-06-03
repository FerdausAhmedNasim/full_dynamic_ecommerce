<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Helper;
use App\Models\ContactMessage;
use Yajra\DataTables\Facades\DataTables;

class ContactUsService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.contactUs.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('contact_us_index')) {
                $actionHtml .= '<button class="dropdown-item text-success" onclick="showModal(\'' . $row->id . '\');"><i class="fa fa-eye"></i> Show </button>';
            }

            if (Helper::hasAuthRolePermission('contact_us_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
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

    private function getRepliedSwitch($row)
    {
        $is_check = $row->is_replied ? "checked" : "";
        $route = "'" . route('admin.contactUs.change_reply_status', $row->id) . "'";
        $disabled = "";

        if (! Helper::hasAuthRolePermission('contact_us_status')) {
            $disabled = "disabled";
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" ' . $disabled . '
                        onchange="changeRepliedStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="activeSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="activeSwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = ContactMessage::get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->editColumn('is_replied', function ($row) {
                return $this->getRepliedSwitch($row);
            })
            ->editColumn('created_at', function ($row) {
                return getFormattedDateTime($row->created_at);
            })
            ->rawColumns(['action','is_replied'])
            ->make(true);
    }

    public function changeStatus(ContactMessage $contact_message)
    {
        abort_unless($contact_message, 404);

        try {
            $this->data = $contact_message->update(['is_replied' => !$contact_message->is_replied]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
