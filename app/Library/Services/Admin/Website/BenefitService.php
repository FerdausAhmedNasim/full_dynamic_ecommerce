<?php

namespace App\Library\Services\Admin\Website;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Benefit;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class BenefitService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml = '
            <a class="dropdown-item" href="' . route('admin.website.benefit.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>
            <a class="dropdown-item text-danger" href="' . route('admin.website.benefit.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.website.benefit.change_status', $row->id) . "'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeActiveStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="activeSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="activeSwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Benefit::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('order', function ($row) {
                    return $row->order != 99 ? $row->order : '--';
                })

                ->addColumn('image', function ($row) {
                    return '<img src="' . $row->getImage() . '" alt="Preview" />';
                })

                ->editColumn('active', function ($row) {
                    return $this->getActiveSwitch($row);
                })

                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'active','image'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['order'] = isset($data['order']) ? $data['order'] : 99;

            $benefit = Benefit::create($data);

            if (isset($data['image'])) {
                attachmentStore($data['image'], $benefit, Enum::BENEFIT_ICON_IMAGE_DIR, Enum::ATTACHMENT_TYPE_ICON);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Benefit $benefit, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $this->data = $benefit->update($data);

            if (isset($data['image'])) {
                $this->deleteFile($benefit);
                attachmentStore($data['image'], $benefit, Enum::BENEFIT_ICON_IMAGE_DIR, Enum::ATTACHMENT_TYPE_ICON);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Benefit $benefit): bool
    {
        try {
            $this->data = $benefit->update(['active' => !$benefit->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeFeatured(Benefit $benefit): bool
    {
        try {
            $this->data = $benefit->update(['featured' => !$benefit->featured]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Benefit $benefit): bool
    {
        try {
            if($this->deleteFile($benefit)) {
                $benefit->delete();

                return $this->handleSuccess('Successfully Deleted');
            }

            return $this->handleFailed('Not Deleted !!!');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function deleteFile(Benefit $benefit)
    {
        DB::beginTransaction();

        try {
            deleteFile($benefit->getImage());
            $benefit->attachments()->where('for', Enum::ATTACHMENT_TYPE_ICON)->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }
}
