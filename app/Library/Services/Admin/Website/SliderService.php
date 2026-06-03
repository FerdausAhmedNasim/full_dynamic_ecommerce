<?php

namespace App\Library\Services\Admin\Website;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class SliderService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('slider_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.website.slider.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('slider_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.website.slider.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.website.slider.change_status', $row->id) . "'";
        $disabled = '';

        if (! Helper::hasAuthRolePermission('slider_status')) {
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
        $data = Slider::with('operator')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('order', function ($row) {
                    return $row->order != 99 ? $row->order : '--';
                })

                ->addColumn('background', function ($row) {
                    return '<img src="' . $row->getBackgroundImage() . '" alt="Preview" />';
                })

                ->editColumn('link', function ($row) {
                    return $row->link ? '<a href="' . $row->link . '" target="_blank"> Click Here </a>' : 'N/A';
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

                ->rawColumns(['action', 'active','background','link'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['order'] = isset($data['order']) ? $data['order'] : 99;

            $slider = Slider::create($data);

            if (isset($data['background'])) {
                attachmentStore($data['background'], $slider, Enum::SLIDER_BACKGROUND_IMAGE_DIR, Enum::ATTACHMENT_TYPE_BACKGROUND);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Slider $slider, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $this->data = $slider->update($data);

            if (isset($data['background'])) {
                $this->deleteFile($slider);
                attachmentStore($data['background'], $slider, Enum::SLIDER_BACKGROUND_IMAGE_DIR, Enum::ATTACHMENT_TYPE_BACKGROUND);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Slider $slider): bool
    {
        try {
            $this->data = $slider->update(['active' => !$slider->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeFeatured(Slider $slider): bool
    {
        try {
            $this->data = $slider->update(['featured' => !$slider->featured]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Slider $slider): bool
    {
        try {
            if($this->deleteFile($slider)) {
                $slider->delete();

                return $this->handleSuccess('Successfully Deleted');
            }

            return $this->handleFailed('Not Deleted !!!');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function deleteFile(Slider $slider)
    {
        DB::beginTransaction();

        try {
            deleteFile($slider->getBackgroundImage());
            $slider->attachments()->where('for', Enum::ATTACHMENT_TYPE_BACKGROUND)->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }
}
