<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;

class AttachmentService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.user.employee.attachment.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmFormModal(\'' . route('admin.user.employee.attachment.delete', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash-alt"></i> Delete</a>';
        } else {
            $actionHtml = '';
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

    private function actionHtmlForEmployee($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml = '
            <a class="dropdown-item" href="' . route('employee.attachment.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmFormModal(\'' . route('employee.attachment.delete', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash-alt"></i> Delete</a>';
        } else {
            $actionHtml = '';
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

    public function dataTable(Employee $employee)
    {
        $data = $employee->attachments;

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('attachment', function ($row) {
                    return '<a target="_blank" href="' . $row->getAttachment() . '">View</a>';
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action', 'attachment'])
                ->make(true);
    }

    public function dataTableForEmployee(Employee $employee)
    {
        $data = $employee->attachments;

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('attachment', function ($row) {
                    return '<a target="_blank" href="' . $row->getAttachment() . '">View</a>';
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtmlForEmployee($row);
                })
                ->rawColumns(['action', 'attachment'])
                ->make(true);
    }

    public function store(array $data, Employee $employee): bool
    {
        // try {
        $data['operator_id'] = auth()->id();

        if (isset($data['attachment'])) {
            attachmentStore($data['attachment'], $employee, Enum::STORE_ATTACHMENT_FILE_DIR, Enum::ATTACHMENT_TYPE_ATTACHMENT);
        }

        return $this->handleSuccess('Successfully created');
        // } catch (Exception $e) {
        //     Helper::log($e);

        //     return $this->handleException($e);
        // }
    }

    public function update(array $data, $attachment): bool
    {
        try {
            $data['operator_id'] = auth()->id();

            if (isset($data['attachment'])) {
                deleteFile($attachment->attachment);
                $data['attachment'] = $this->getAttachment($data['attachment']);
            }

            $this->data = $attachment->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public static function getAttachment($attachment): string
    {
        $file_extension = $attachment->getMimeType();
        // dd($file_extension);

        if ($file_extension == 'image/*') {
            return Helper::uploadImage($attachment, Enum::ATTACHMENT_FILE_DIR);
        }

        return Helper::uploadFile($attachment, Enum::ATTACHMENT_FILE_DIR);
    }
}
