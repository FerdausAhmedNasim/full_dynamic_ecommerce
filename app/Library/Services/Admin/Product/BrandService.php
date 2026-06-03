<?php

namespace App\Library\Services\Admin\Product;

use Exception;
use App\Library\Enum;
use App\Models\Brand;
use App\Library\Helper;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class BrandService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('brand_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.brand.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('brand_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.brand.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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

    private function getActiveSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route = "'" . route('admin.brand.change_status', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('brand_status')) {
            $disabled = 'disabled';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" '. $disabled .'
                        onchange="changeActiveStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="activeSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="activeSwitch_' . $row->id . '"></label>
                </div>';
    }

    private function getFeaturedSwitch($row)
    {
        $is_check = $row->featured ? "checked" : "";
        $route1 = "'" . route('admin.brand.change_featured', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('brand_status')) {
            $disabled = 'disabled';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" '. $disabled .'
                        onchange="changeFeaturedStatus(event, ' . $route1 . ')"
                        class="custom-control-input"
                        id="featuredSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="featuredSwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $data = Brand::with('operator', 'languages')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('name', function ($row) {
                    return $row->getTranslation('title');
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->addColumn('thumbnail', function ($row) {
                    return '<img src="' . $row->getThumbnailImage() . '" alt="Preview" />';
                })
                ->editColumn('active', function ($row) {
                    return $this->getActiveSwitch($row);
                })
                ->editColumn('featured', function ($row) {
                    return $this->getFeaturedSwitch($row);
                })
                ->rawColumns(['action', 'active', 'featured', 'icon','thumbnail'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {

            $data['operator_id'] = auth()->id();
            $data['slug'] = generateUniqueSlug($data['name'], Brand::class);
            $brand = Brand::create($data);
            languageStore($data['name'], $brand);

            if (isset($data['thumbnail'])) {
                attachmentStore($data['thumbnail'], $brand, Enum::BRAND_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Brand $brand, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['slug'] = generateUniqueSlug($data['name'], Brand::class, $brand->id);
            $data['title'] = $data['name'];
            $this->data = $brand->update($data);

            languageUpdate($data, $brand);

            if (isset($data['thumbnail'])) {
                $this->deleteFile($brand);
                attachmentStore($data['thumbnail'], $brand, Enum::BRAND_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Brand $brand): bool
    {
        try {
            $this->data = $brand->update(['active' => !$brand->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeFeatured(Brand $brand): bool
    {
        try {
            $this->data = $brand->update(['featured' => !$brand->featured]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Brand $brand): bool
    {
        try {
            if($this->deleteFile($brand)) {
                $brand->delete();

                return $this->handleSuccess('Successfully deleted');
            }

            return $this->handleFailed('Not Deleted !!!');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function deleteFile(Brand $brand)
    {
        DB::beginTransaction();

        try {
            deleteFile($brand->getThumbnailAttribute());
            $brand->attachments()->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }

}
