<?php

namespace App\Library\Services\Seller\Coupon;

use Exception;
use App\Library\Enum;
use App\Models\Coupon;
use App\Library\Helper;
use App\Models\Expense;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class CouponService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.coupon.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_coupon_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('seller.coupon.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('seller_coupon_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
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

    public function dataTable()
    {
        $data = Coupon::getSellerCoupon();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('discount_type', function ($row) {
                    return ucwords($row->discount_type);
                })
                ->editColumn('discount', function ($row) {
                    if ($row->discount_type == Enum::COUPON_TYPE_PERCENTAGE) {
                        return $row->discount . '%';
                    }

                    return getFormattedAmount($row->discount);
                })
                ->editColumn('maximum_discount', function ($row) {
                    return getFormattedAmount($row->maximum_discount);
                })
                ->editColumn('start_date', function ($row) {
                    return $row->start_date ?? 'N/A';
                })
                ->editColumn('end_date', function ($row) {
                    return $row->end_date ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
       try {
            $data['seller_id'] = authSellerId();

            $this->data = Coupon::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Coupon $coupon, array $data): bool
    {
        try {
            $data['seller_id'] = authSellerId();

            $this->data = $coupon->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Coupon $coupon): bool
    {
        try {
            $coupon->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
