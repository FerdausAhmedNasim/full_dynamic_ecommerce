<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;

class PaymentService extends BaseService
{
    // For Filtering
    private function filter(array $params)
    {
        $query = Payment::select('*');

        if (isset($params['type'])) {
            $query->where('payment_type', $params['type']);
        }

        return $query->get();
    }

    private function getActionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.blog.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('blog_show')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('admin.blog.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>';
            }

            if (Helper::hasAuthRolePermission('blog_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.blog.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('blog_delete')) {
                $actionHtml .= '<button class="dropdown-item" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
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

    private function statusHtml($row)
    {
        if ($row->payment_status == Enum::PAYMENT_STATUS_FAILED) {
            $class = 'badge-danger';
            $status = Enum::getPaymentStatus(Enum::PAYMENT_STATUS_FAILED);
        } else {
            $class = 'badge-success';
            $status = Enum::getPaymentStatus(Enum::PAYMENT_STATUS_SUCCESS);
        }

        return '<div class="badge ' . $class . '"><strong class="px-2">' . $status . '</strong></div>';
    }

    public function dataTable(array $params)
    {
        $data = $this->filter($params);

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('amount', function ($row) {
                return formatPrice($row->amount) ?? 'N/A';
            })

            ->addColumn('payment_by', function ($row) {
                return $row->payment_by ? $row->paymentBy->user->full_name : 'N/A';
            })

            ->addColumn('payment_taken_by', function ($row) {
                return $row->payment_by ? $row->takenBy->full_name : 'N/A';
            })

            ->addColumn('action', function ($row) {
                return $this->getActionHtml($row);
            })

            ->addColumn('payment_status', function ($row) {
                return $this->statusHtml($row);
            })

            ->rawColumns(['title', 'action', 'payment_status'])
            ->make(true);
    }

    public function create(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $data['post_type'] = Enum::POST_TYPE_BLOG;
            $data['tags'] = isset($data['tags']) ? json_encode($data['tags']) : null;

            if (isset($data['featured_image'])) {
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::BLOG_FEATURE_IMAGE, 800, 500);
            }

            $this->data = Post::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Post $blog, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            $data['tags'] = isset($data['tags']) ? json_encode($data['tags']) : null;

            if (isset($data['featured_image'])) {
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::BLOG_FEATURE_IMAGE, 800, 500);
            }

            $this->data = $blog->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
