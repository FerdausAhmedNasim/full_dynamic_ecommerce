<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\Note;
use App\Library\Helper;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NoteService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('note_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="#" onclick="show(\'' . $row->id . '\')"><i class="fas fa-eye"></i> View </a>';
            }

            if (Helper::hasAuthRolePermission('note_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.user.seller.note.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('note_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="#"  onclick="confirmFormModal(\'' . route('admin.user.seller.note.delete', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash"></i> Delete</a>';
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

    public function dataTable($id = null)
    {
        $query = Note::with('operator', 'user');

        if($id) {
            $query->where('user_id', $id);
        }
        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('description', function ($row) {
                return  Str::limit($row?->description, 20);
            })

            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })

            ->editColumn('created_at', function ($row) {
                return isset($row->created_at) ? getFormattedDate($row->created_at) : 'N/A';
            })

            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(array $data, $user_id): bool
    {
        try {

            $data['operator_id'] = auth()->id();
            $data['user_id'] = $user_id;
            $note = Note::create($data);

            $this->data = $note;

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(array $data, Note $note): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $note->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
