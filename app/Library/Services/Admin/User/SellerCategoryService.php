<?php

namespace App\Library\Services\Admin\User;

use Exception;
use App\Models\Note;
use App\Library\Helper;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Models\SellerCategory;

class SellerCategoryService extends BaseService
{
    private function actionHtml($row, $id)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('note_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.user.seller.category.edit', [$id, $row->id]) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('note_delete')) {
                $actionHtml .= '<a class="dropdown-item text-danger" href="#"  onclick="confirmFormModal(\'' . route('admin.user.seller.category.delete', [$id, $row->id]) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash"></i> Delete</a>';
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
        $query = SellerCategory::with('operator', 'category');

        if($id) {
            $query->where('seller_id', $id);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('category', function ($row) {
                return $row?->category->getTranslation('title');
            })

            ->editColumn('commission_rate', function ($row) {
                return $row?->commission_rate;
            })

            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })

            ->editColumn('created_at', function ($row) {
                return isset($row->created_at) ? getFormattedDate($row->created_at) : 'N/A';
            })

            ->addColumn('action', function ($row) use ($id) {
                return $this->actionHtml($row, $id);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(array $data, $user_id): bool
    {
        try {

            $data['operator_id'] = auth()->id();
            $data['seller_id'] = $user_id;
            $sellerCategory = SellerCategory::create($data);

            $this->data = $sellerCategory;

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(array $data, SellerCategory $sellerCategory): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $sellerCategory->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
