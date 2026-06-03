<?php

namespace App\Library\Services\Admin\Product;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class CategoryService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('category_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.category.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('category_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.category.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $route = "'" . route('admin.category.change_status', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('category_status')) {
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
        $route1 = "'" . route('admin.category.change_featured', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('category_status')) {
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
        $data = Category::with('operator', 'parent', 'languages')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('parent_id', function ($row) {
                    return $row->parent_id ? $row->parent->getTranslation('title') : '--';
                })
                ->addColumn('name', function ($row) {
                    return $row->getTranslation('title');
                })
                ->editColumn('order', function ($row) {
                    return $row->order != 99 ? $row->order : '--';
                })

                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })

                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->addColumn('thumbnail', function ($row) {
                    return '<img src="' . $row->getThumbnailImage() . '" alt="Preview" />';
                })
                ->addColumn('icon', function ($row) {
                    return '<img src="' . $row->getIconImage() . '" alt="Preview" />';
                })
                ->editColumn('active', function ($row) {
                    return $this->getActiveSwitch($row);
                })
                ->editColumn('featured', function ($row) {
                    return $this->getFeaturedSwitch($row);
                })
                ->rawColumns(['action', 'active', 'featured', 'icon', 'parent_id','thumbnail'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['slug'] = generateUniqueSlug($data['name'], Category::class);
            $data['order'] = isset($data['order']) ? $data['order'] : 99;

            $category = Category::create($data);
            languageStore($data['name'], $category);

            if (isset($data['thumbnail'])) {
                attachmentStore($data['thumbnail'], $category, Enum::CATEGORY_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            if (isset($data['icon'])) {
                attachmentStore($data['icon'], $category, Enum::CATEGORY_ICON_IMAGE_DIR, Enum::ATTACHMENT_TYPE_ICON);
            }
            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Category $category, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['slug'] = generateUniqueSlug($data['name'], Category::class);
            $data['title'] = $data['name'];

            $this->data = $category->update($data);
            languageUpdate($data, $category);


            if (isset($data['thumbnail'])) {
                $this->deleteFile($category, Enum::ATTACHMENT_TYPE_THUMBNAIL);
                attachmentStore($data['thumbnail'], $category, Enum::CATEGORY_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            if (isset($data['icon'])) {
                $this->deleteFile($category, Enum::ATTACHMENT_TYPE_ICON);
                attachmentStore($data['icon'], $category, Enum::CATEGORY_ICON_IMAGE_DIR, Enum::ATTACHMENT_TYPE_ICON);
            }
            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Category $category): bool
    {
        try {
            $this->data = $category->update(['active' => !$category->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeFeatured(Category $category): bool
    {
        try {
            $this->data = $category->update(['featured' => !$category->featured]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Category $category): bool
    {
        try {
            if($this->deleteFile($category, 'both')) {
                $category->delete();

                return $this->handleSuccess('Successfully deleted');
            }

            return $this->handleFailed('Not Deleted !!!');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function deleteFile(Category $category, $type)
    {
        DB::beginTransaction();

        try {
            if($type == 'both') {
                deleteFile($category->getThumbnailAttribute());
                deleteFile($category->getIconAttribute());
                $category->attachments()->delete();
            } else {
                if($type == Enum::ATTACHMENT_TYPE_THUMBNAIL) {
                    deleteFile($category->getThumbnailAttribute());
                } else {
                    deleteFile($category->getIconAttribute());
                }
                $category->attachments()->where('for', $type)->delete();
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }
}
