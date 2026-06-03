<?php

namespace App\Library\Services\Seller\Order;

use App\Events\Order\StatusChanged;
use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Stock;
use App\Library\Helper;
use App\Models\Account;
use App\Models\Payment;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Models\BlackUser;
use App\Models\SellerOrder;

class OrderService extends BaseService
{
    private function actionHtml($row, $customerId = null)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_order_show')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('seller.order.show', $row->id) . '" ><i class="far fa-eye"></i> View </a>';
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

    public function dataTable($params)
    {
        $query = SellerOrder::with('order.customer')
                    ->where('seller_id', authSellerId());

        if (isset($params['status']) && count($params['status'])) {
            $query->whereIn('order_status', $params['status']);
        }

        $query = $this->orderByRange($params['range'], $query);

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        return Datatables::of($query->get())
                ->addIndexColumn()
                ->editColumn('customer_id', function ($row) {
                    return $row?->order->customer?->full_name ?? 'N/A';
                })
                ->addColumn('invoice_id', function ($row) {
                    $name = $row?->order->invoice_id;

                    return !Helper::hasAuthRolePermission('seller_order_show') ? $name : '<a href="' . route('seller.order.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
                })
                ->editColumn('date_time', function ($row) {
                    return getFormattedDateTime($row->created_at);
                })
                ->editColumn('sub_total_amount', function ($row) {
                    return getFormattedAmount($row->sub_total_amount);
                })
                ->editColumn('total_amount', function ($row) {
                    return getFormattedAmount($row->total_amount);
                })
                ->editColumn('discount_amount', function ($row) {
                    return getFormattedAmount($row->discount_amount);
                })
                ->addColumn('order_status', function ($row) {
                    return getOrderStatus($row->order_status);
                })
                ->addColumn('payment_status', function ($row) {
                    return getOrderPaymentStatus($row->payment_status);
                })
                ->editColumn('payment_type', function ($row) {
                    return Enum::getOrderPaymentType($row->payment_type);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->addColumn('customer_mobile', function ($row) {
                    return $row?->order->customer?->phone;
                })
                ->rawColumns(['action','operator','invoice_id', 'order_status', 'payment_status'])
                ->make(true);
    }

    public function orderByRange($range, $query)
    {
        if (! $range) {
            return $query;
        }

        switch ($range) {
            case 'latest_on_top':
                return $query->orderByDesc('id');

                break;
            case 'oldest_on_top':
                return $query->orderBy('id');

                break;
            case 'total_low_high':
                return $query->orderBy('total_amount');

                break;
            case 'total_high_low':
                return $query->orderByDesc('total_amount');

                break;
            case 'quantity_low_high':
                return $query->orderBy('quantity');

                break;
            case 'quantity_high_low':
                return $query->orderByDesc('quantity');

                break;
            default:
                return $query;
        }
    }

    public function edit(array $data, Order $order): bool
    {
        DB::beginTransaction();

        try {
            $this->updateOrder($data, $order);

            foreach ($data['product_id'] as $key => $value) {
                // $stock = $this->updateStock($data, $order, $key, $value);
                $this->updateOrderDetails($data, $order, $key, $value);
            }

            // $this->updatePayment($data, $order);

            $this->deleteDeletedProducts($data, $order);
            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    private function updateOrder(array $data, Order $order)
    {
        $discount_amount = $data['discount_amount'] ?? 0;
        $packaging_cost = $data['packaging_cost'] ?? 0;
        $delivery_cost = $data['delivery_cost'] ?? 0;
        $sub_total = $data['total_amount'] - $packaging_cost - $delivery_cost + $discount_amount;

        $order_data['operator_id'] = auth()->id();
        $order_data['note'] = $data['note'];
        $order_data['due_amount'] = $data['total_amount'];
        $order_data['sub_total_amount'] = $sub_total;
        $order_data['total_amount'] = $data['total_amount'];
        $order_data['discount_amount'] = $discount_amount;
        $order_data['packaging_cost'] = $packaging_cost;
        $order_data['delivery_cost'] = $delivery_cost;

        return $order->update($order_data);
    }

    private function updateOrderDetails(array $data, Order $order, $key, $value)
    {
        $order_details = OrderDetails::where([['order_id', $order->id],['product_id', $value]])->first();
        $qty = $order_details->quantity - (int)$data['quantity'][$key];

        $this->updateStock($order_details->stock, $qty);

        $order_details->quantity = $data['quantity'][$key];
        $order_details->sale_price = $data['sale_price'][$key];

        return $order_details->save();
    }

    private function updateStock(Stock $stock, $qty)
    {
        $stock->quantity = $stock->quantity + ($qty);
        $stock->operator_id = auth()->id();

        return $stock->save();
    }

    private function updatePayment(array $data, Order $order)
    {
        $payment['operator_id'] = auth()->id();
        $payment['amount'] = $data['total_amount'];

        return Payment::where('order_id', $order->id)->first()->update($payment);
    }

    private function deleteDeletedProducts(array $data, Order $order)
    {
        foreach($data['deleted_product'] ?? [] as $key => $value) {
            $order_details = OrderDetails::where([['order_id', $order->id],['product_id', $value]])->first();

            $this->updateStock($order_details->stock, $order_details->quantity);

            $order_details->delete();
        }

        return true;
    }

    public function pay(array $data, Order $order): bool
    {
        DB::beginTransaction();

        try {
            $due = $order->due_amount - (float)$data['total_amount'];
            $order_data['operator_id'] = auth()->id();
            $order_data['due_amount'] = $due;
            $order_data['payment_status'] = $due < 1 ? Enum::ORDER_PAYMENT_STATUS_PAID : Enum::ORDER_PAYMENT_STATUS_PARTIAL;
            $order->update($order_data);

            $paymentDetails = [];

            foreach ($data['payment_type'] ?? [] as $key => $value) {

                if ($data['amount'][$key] <= 0) {
                    continue;
                }

                $paymentDetails = [
                    'type'           => Enum::PAYMENT_TYPE_SALE,
                    'operator_id'    => authId(),
                    'order_id'       => $order->id,
                    'payment_method' => $value,
                    'amount'         => $data['amount'][$key],
                    'transaction_id' => $data['trx_id'][$key],
                    'order_status'   => $order->order_status,
                ];

                Payment::create($paymentDetails);
            }

            if (count($paymentDetails)) {
                Account::create([
                    'branch_id'   => $order->branch_id,
                    'operator_id' => authId(),
                    'amount'      => $data['total_amount']
                ]);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');

        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(SellerOrder $seller_order, string $status)
    {
        try {
            $seller_order->update(['order_status' => $status]);

            if (count($seller_order->order->sellerOrders) == 1) {
                $seller_order->order->update(['order_status' => $status]);
            } else {
                event(new StatusChanged($seller_order));
            }

            if ($status == Enum::ORDER_STATUS_TYPE_NOT_RECEIVED) {
                BlackUser::create([
                    'user_id'         => $seller_order->order->customer_id,
                    'seller_order_id' => $seller_order->id,
                    'shipping_cost'   => $seller_order->shipping_cost,
                ]);
            }

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    //=================== Customer Orders ======================//
    public function dataTableForCustomer(User $user)
    {
        $data = Order::where('type', Enum::ORDER_TYPE_SALE)
                    ->where('customer_id', $user->id)
                    ->with('branch', 'operator', 'payments')
                    ->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('branch_id', function ($row) {
                    return $row?->branch?->name ?? 'N/A';
                })
                ->editColumn('sub_total_amount', function ($row) {
                    return getFormattedAmount($row->sub_total_amount);
                })
                ->editColumn('total_amount', function ($row) {
                    return getFormattedAmount($row->total_amount);
                })
                ->editColumn('vat_amount', function ($row) {
                    return getFormattedAmount($row->vat_amount);
                })
                ->editColumn('discount_amount', function ($row) {
                    return getFormattedAmount($row->discount_amount);
                })
                ->editColumn('due_amount', function ($row) {
                    return getFormattedAmount($row->due_amount);
                })
                ->editColumn('packaging_cost', function ($row) {
                    return getFormattedAmount($row->packaging_cost);
                })
                ->editColumn('delivery_cost', function ($row) {
                    return getFormattedAmount($row->delivery_cost);
                })
                ->editColumn('other_cost', function ($row) {
                    return getFormattedAmount($row->other_cost);
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) use ($user) {
                    return $this->actionHtml($row, $user->id);
                })
                ->editColumn('invoice_id', function ($row) use ($user) {
                    return '<a href="' . route('admin.user.customer.order.show', $row->id) . '" > ' . $row->invoice_id . ' </a>';
                })

                ->rawColumns(['action', 'operator', 'invoice_id'])
                ->make(true);
    }
}
