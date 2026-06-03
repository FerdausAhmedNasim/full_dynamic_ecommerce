<?php

namespace App\Library\Services\Admin;

use App\Library\Helper;
use App\Models\Subscriber;
use Yajra\DataTables\Facades\DataTables;

class SubscriberService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '<i class="fa fa-xmark"></i>';
        $route = route('admin.subscriber.delete', $row->id);

        if (Helper::hasAuthRolePermission('subscriber_delete')) {
            $actionHtml = '<button class="btn btn-sm mb-2 mr-2 btn-danger tooltip-danger" tooltip="Delete" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> </button>';
        }

        return $actionHtml;
    }

    public function dataTable()
    {
        $data = Subscriber::get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
