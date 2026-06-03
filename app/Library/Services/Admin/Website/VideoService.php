<?php

namespace App\Library\Services\Admin\Website;

use Exception;
use App\Library\Enum;
use App\Models\Video;
use App\Library\Helper;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class VideoService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('slider_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.website.video.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('slider_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.website.video.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
            }
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

    private function getActiveSwitch($row)
    {
        $is_check = $row->status ? "checked" : "";
        $route = "'" . route('admin.website.video.change_status', $row->id) . "'";
        $disabled = '';
        $isAnyActive = Video::where('status', true)->exists();

        if ($isAnyActive && !$row->status) {
            $disabled = 'disabled';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" ' . $disabled . '
                        onchange="changeActiveStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="activeSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="activeSwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Video::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('link', function ($row) {
                    return $row->link ? '<a href="' . $row->link . '" target="_blank"> Click Here </a>' : 'N/A';
                })
                ->editColumn('status', function ($row) {
                    return $this->getActiveSwitch($row);
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action', 'status', 'link'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();

            Video::create($data);

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Video $video, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $this->data = $video->update($data);

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Video $video): bool
    {
        try {
            $this->data = $video->update(['status' => !$video->status]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Video $video): bool
    {
        try {
            $video->delete();

            return $this->handleSuccess('Successfully Deleted');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
