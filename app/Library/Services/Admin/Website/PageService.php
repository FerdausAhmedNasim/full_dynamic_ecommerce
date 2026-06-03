<?php

namespace App\Library\Services\Admin\Website;

use Exception;
use App\Models\Page;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Attachment;
use App\Models\PageLanguage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class PageService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            if(Helper::hasAuthRolePermission('page_update')) {
                $actionHtml = '<a class="dropdown-item" href="' . route('admin.website.page.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }
            // $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.website.page.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $route = "'" . route('admin.website.page.change_status', $row->id) . "'";
        $disabled = '';

        if(! Helper::hasAuthRolePermission('page_update')) {
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

    private function getLink($row)
    {
        $link = config('app.url') . '/page/' . $row->link;

        return '<a class="text-primary" target="_blank" href="' . $link . '">' . $link . '</a>';
    }

    public function dataTable()
    {
        $data = Page::with('operator', 'languages')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('active', function ($row) {
                    return $this->getActiveSwitch($row);
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })

                ->addColumn('title', function ($row) {
                    return $row->getTranslation('title');
                })

                ->editColumn('link', function ($row) {
                    return $this->getLink($row);
                })

                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'active','link'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            $data['link'] = generateUniqueSlug($data['title'], Page::class, '', 'link');
            $page = Page::create($data);

            $data['page_id'] = $page->id;
            $data['local'] = 'en';
            PageLanguage::create($data);

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Page $page, array $data): bool
    {
        DB::beginTransaction();

        try {
            $data['operator_id'] = auth()->id();
            // $data['link'] = generateUniqueSlug($data['title'], Page::class, $page->id, 'link');

            // Image
            if (isset($data['image'])) {
                deleteFile($page->image);
                
                $data['image'] = Helper::uploadImage($data['image'], Enum::ABOUT_US_IMAGE_PATH, 770, 450);
            }

            $page->update($data);

            $data['local'] = 'en';
            $page_language = PageLanguage::where('page_id', $page->id)->where('local', $data['local'])->first();

            if ($page_language) {
                $page_language->update($data);
            } else {
                $data['page_id'] = $page->id;
                PageLanguage::create($data);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Page $page): bool
    {
        try {
            $this->data = $page->update(['active' => !$page->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Page $page): bool
    {
        try {
            $page->delete();

            return $this->handleSuccess('Successfully Deleted');

        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
