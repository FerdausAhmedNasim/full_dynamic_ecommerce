<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Account;
use App\Models\Address;
use App\Models\Payment;
use App\Models\BlackUser;
use App\Models\OrderReturn;
use App\Models\SellerOrder;
use App\Models\OrderDetails;
use App\Models\ProductStock;
use App\Models\ReturnDetails;
use App\Models\CourierPricingPlan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderService extends BaseService
{
    private function actionHtml($row, $customerId = null)
    {
        $actionHtml = '';

        if ($row->id) {
            if ($customerId) {
                if (Helper::hasAuthRolePermission('order_show')) {
                    $actionHtml .= '<a class="dropdown-item" href="' . route('admin.user.customer.order.show', $row->id) . '" ><i class="far fa-eye"></i> View </a>';
                }
            } else {
                if (Helper::hasAuthRolePermission('order_show')) {
                    $actionHtml .= '<a class="dropdown-item" href="' . route('admin.order.show', $row->id) . '" ><i class="far fa-eye"></i> View </a>';
                }
            }

            if (Helper::hasAuthRolePermission('order_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.order.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('return_create') && $row->order_status == Enum::ORDER_STATUS_TYPE_DELIVERED) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.order.return', $row->id) . '" ><i class="fa fa-reply"></i></i> Return</a>';
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

    public function getPaymentStatus($status)
    {
        $class = 'badge-success';

        if (Enum::ORDER_PAYMENT_STATUS_UNPAID == $status) {
            $class = 'badge-secondary';
        } elseif (Enum::ORDER_PAYMENT_STATUS_REFUNDED == $status) {
            $class = 'badge-danger';
        }

        return '<div class="badge ' . $class . '">' . Enum::getPaymentStatusType($status) . '</div>';
    }

    public function dataTable($params)
    {
        $query = SellerOrder::with('order', 'order.customer', 'return', 'operator');

        if (isset($params['status']) && count($params['status'])) {
            $query->whereIn('order_status', $params['status']);
        }

        $query = $this->orderByRange($params['range'], $query);

        if (isset($params['fromDate'], $params['toDate']) && $params['fromDate'] && $params['toDate']) {
            $query->whereBetween('created_at', [$params['fromDate'], $params['toDate']]);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('customer_id', function ($row) {
                return $row?->order->customer ? $row?->order->customer?->full_name : $row?->order->order_person_name;
            })
            ->addColumn('invoice_id', function ($row) {
                $name = $row?->order?->invoice_id;

                return !Helper::hasAuthRolePermission('order_show') ? $name : '<a href="' . route('admin.order.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
            })
            ->editColumn('date_time', function ($row) {
                return getFormattedDateTime($row->order->created_at);
            })
            ->editColumn('sub_total_amount', function ($row) {
                return getFormattedAmount($row->order->sub_total_amount);
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row->order->total_amount);
            })
            ->editColumn('discount_amount', function ($row) {
                return getFormattedAmount($row->order->discount_amount);
            })
            ->addColumn('order_status', function ($row) {
                return getOrderStatus($row->order->order_status);
            })
            ->addColumn('payment_status', function ($row) {
                return getOrderPaymentStatus($row->order->payment_status);
            })
            ->addColumn('return_status', function ($row) {
                return $row->return?->status ? '<a href="'. route('admin.return.show', $row->return?->id) .'">'. $row->return?->statusHtml() .'</a>' : 'N/A';
            })
            ->editColumn('payment_type', function ($row) {
                return Enum::getOrderPaymentType($row->order->payment_type);
            })
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->addColumn('customer_mobile', function ($row) {
                return $row?->order->customer ? $row?->order->customer?->phone : $row?->order->order_person_phone;
            })
            ->rawColumns(['action', 'operator', 'invoice_id', 'order_status', 'payment_status', 'return_status','payment_type'])
            ->make(true);
    }

    public function orderByRange($range, $query)
    {
        if (!$range) {
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
                return $query->orderBy('total_amount', 'desc');

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

    public function edit(array $data, SellerOrder $order): bool
    {
        DB::beginTransaction();

        try {
            $quantity = $data['quantity'];
            $totalShippingCost = 0;

            foreach ($data['product_id'] as $key => $product_id) {
                $orderProduct = $order->sellerOrderDetails->where('product_id', $product_id)->first();

                $totalWeight = $orderProduct->load('product')->product->weight * $orderProduct->quantity;
                $customerAddress = $order->order->address;
                $sellerAddress = Address::where('user_id', $order->seller->id)->first();

                $extra_cost = 0;

                if ($customerAddress?->location == Enum::INSIDE_DHAKA) {
                    $extra_cost = settings('extra_charge_for_inside_dhaka');
                } elseif ($customerAddress?->location == Enum::OUTSIDE_DHAKA) {
                    $extra_cost = settings('extra_charge_for_outside_dhaka');
                } elseif ($customerAddress?->location == Enum::SUBURBS) {
                    $extra_cost = settings('extra_charge_for_sub_dhaka');
                }

                $pickupLocation = $sellerAddress->location;
                $deliveryLocation = $customerAddress?->location;

                $pricingPlan = CourierPricingPlan::where('pickup_location', $pickupLocation)
                        ->where('delivery_location', $deliveryLocation)
                        ->where('active', true)
                        ->where(function($query) use ($totalWeight) {
                            $query->where('min_weight', '<=', $totalWeight)
                                ->where('max_weight', '>=', $totalWeight)
                                ->orWhere('max_weight', '<', $totalWeight);
                        })
                        ->orderBy('max_weight', 'desc')
                        ->first();

                    if ($pricingPlan) {
                        if ($totalWeight <= $pricingPlan->max_weight) {
                            $shippingCost = $pricingPlan->price;
                        } else {
                            // Calculate the additional cost for weights over max_weight
                            $extraWeight = $totalWeight - $pricingPlan->max_weight;
                            $extraCost = (float) $extraWeight * (float) $extra_cost;
                            $shippingCost = $pricingPlan->price + $extraCost;
                        }

                        $totalShippingCost += $shippingCost;
                    }

                $updated = $orderProduct->update([
                    'quantity' => $quantity[$key],
                ]);
            }

            $totalAmount = 0;
            $subTotalAmount = 0;
            $totalQuantity = 0;

            if ($updated) {
                foreach ($order->sellerOrderDetails as $key => $orderDetail) {
                    $totalQuantity += $orderDetail->quantity;
                    $subTotalAmount += $orderDetail->quantity * $orderDetail->sale_price;
                    $totalAmount += $orderDetail->quantity * $orderDetail->sale_price;
                }
            }
          
            $order->update([
                'quantity' => $totalQuantity,
               'sub_total_amount' => $subTotalAmount,
               'total_amount' => $totalAmount + $totalShippingCost,
               'shipping_cost' => $totalShippingCost,
            ]);

            $order->order->update([
                'quantity' => $totalQuantity,
               'sub_total_amount' => $subTotalAmount,
               'total_amount' => $totalAmount + $totalShippingCost,
               'shipping_cost' => $totalShippingCost,
            ]);

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

    // private function updateOrderDetails(array $data, Order $order, $key, $value)
    // {
    //     $order_details = OrderDetails::where([['order_id', $order->id],['product_id', $value]])->first();
    //     $qty = $order_details->quantity - (int)$data['quantity'][$key];

    //     $this->updateStock($order_details->stock, $qty);

    //     $order_details->quantity = $data['quantity'][$key];
    //     $order_details->sale_price = $data['sale_price'][$key];

    //     return $order_details->save();
    // }

    // private function updateStock(Stock $stock, $qty)
    // {
    //     $stock->quantity = $stock->quantity + ($qty);
    //     $stock->operator_id = auth()->id();

    //     return $stock->save();
    // }

    private function updatePayment(array $data, Order $order)
    {
        $payment['operator_id'] = auth()->id();
        $payment['amount'] = $data['total_amount'];

        return Payment::where('order_id', $order->id)->first()->update($payment);
    }

    private function deleteDeletedProducts(array $data, Order $order)
    {
        foreach ($data['deleted_product'] ?? [] as $key => $value) {
            $order_details = OrderDetails::where([['order_id', $order->id], ['product_id', $value]])->first();

            $this->updateStock($order_details->stock, $order_details->quantity);

            $order_details->delete();
        }

        return true;
    }

    public function pay(array $data, Order $order): bool
    {
        DB::beginTransaction();

        try {
            $due = $order->due_amount - (float) $data['total_amount'];
            $order_data['operator_id'] = auth()->id();
            $order_data['due_amount'] = $due;
            $order_data['payment_status'] = $due < 1 ? Enum::ORDER_PAYMENT_STATUS_PAID : Enum::ORDER_PAYMENT_STATUS_UNPAID;
            $order->update($order_data);

            $paymentDetails = [];

            foreach ($data['payment_type'] ?? [] as $key => $value) {

                if ($data['amount'][$key] <= 0) {
                    continue;
                }

                $paymentDetails = [
                    'type' => Enum::PAYMENT_TYPE_SALE,
                    'operator_id' => authId(),
                    'order_id' => $order->id,
                    'payment_method' => $value,
                    'amount' => $data['amount'][$key],
                    'transaction_id' => $data['trx_id'][$key],
                    'order_status' => $order->order_status,
                ];

                Payment::create($paymentDetails);
            }

            if (count($paymentDetails)) {
                Account::create([
                    'branch_id' => $order->branch_id,
                    'operator_id' => authId(),
                    'amount' => $data['total_amount'],
                ]);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');

        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(SellerOrder $order, string $status)
    {
        DB::beginTransaction();

        try {
            // if ($status == Enum::ORDER_STATUS_TYPE_NOT_RECEIVED) {
            //     BlackUser::create([
            //         'user_id' => $order->order->customer_id,
            //         'seller_order_id' => $order->id,
            //         'shipping_cost' => $order->order->shipping_cost,
            //     ]);
            // }

            // if ($status == Enum::ORDER_STATUS_TYPE_CANCELED) {
            //     foreach($order->load('sellerOrders.sellerOrderDetails.product')->sellerOrders as $key => $sellerOrder) {
            //         foreach ($sellerOrder->sellerOrderDetails->load('product', 'sellerOrder.seller') as $orderDetails) {
            //             $product = $orderDetails->product;
            //             $product->update(['current_stock' => $product->current_stock + $orderDetails->quantity]);
            //             $findProductStock = ProductStock::find($orderDetails->stock_variant_id);
            //             $findProductStock->update(['current_stock' => $findProductStock->current_stock + $orderDetails->quantity]);
            //         }
    
            //         $sellerOrder->update(['order_status' => Enum::ORDER_STATUS_TYPE_CANCELED]);
            //     }
    
            //     $order->update(['order_status' => Enum::ORDER_STATUS_TYPE_CANCELED]);
            // }
            $order->update(['order_status' => $status]);
            $order->order->update(['order_status' => $status]);

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changePaymentStatus(SellerOrder $order, string $status)
    {
        try {
            $order->update(['payment_status' => $status]);
            $order->order->update(['payment_status' => $status]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    //=================== Customer Orders ======================//
    public function dataTableForCustomer(User $user)
    {
        $customerId = $user->id;
        $data = SellerOrder::with('order', 'order.operator', 'return', 'sellerOrderDetails')
                            ->whereHas('order', function ($query) use ($customerId) {
                                $query->where('customer_id', $customerId);
                            })
                            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('sub_total_amount', function ($row) {
                return getFormattedAmount($row->sub_total_amount);
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row->total_amount);
            })
            ->editColumn('discount_amount', function ($row) {
                return getFormattedAmount($row->discount_amount);
            })
            ->editColumn('shipping_cost', function ($row) {
                return getFormattedAmount($row->shipping_cost);
            })
            ->editColumn('order_status', function ($row) {
                return getOrderStatus($row->order_status);
            })
            ->editColumn('payment_status', function ($row) {
                return $this->getPaymentStatus($row->payment_status);
            })
            ->addColumn('return_status', function ($row) {
                return $row->return?->status ? '<a href="'. route('admin.return.show', $row->return?->id) .'">'. $row->return?->statusHtml() .'</a>' : 'N/A';
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->order->operator?->full_name;
            })
            ->addColumn('action', function ($row) use ($user) {
                return $this->actionHtml($row->order, $user->id);
            })
            ->editColumn('invoice_id', function ($row) use ($user) {
                return '<a href="' . route('admin.user.customer.order.show', $row->id) . '" > ' . $row->order->invoice_id . ' </a>';
            })

            ->rawColumns(['action', 'operator_id', 'invoice_id', 'order_status', 'return_status', 'payment_status'])
            ->make(true);
    }

    // =================== Order Return====================== //
    public function return (array $data, SellerOrder $order): bool
    {
        DB::beginTransaction();
      
        try {
            $subTotal = $order->coupon_id ? $data["sub_total"] : array_sum($data["sub_total"]);

            $return['invoice_id'] = generateReturnInvoiceId();
            $return['seller_order_id'] = $order->id;
            $return['operator_id'] = authId();
            $return['sub_total_amount'] = $subTotal;
            $return['coupon_discount'] = $data['coupon_discount'];
            $return['total_amount'] = $data['total_amount'];
            $return['payment_transaction_id'] = mt_rand(10000000, 99999999);
            $return['note'] = $data['note'];

            $order_return = OrderReturn::create($return);

            foreach ($data['quantity'] as $key => $details_id) {

                if ((int) $data['is_return'][$key] == 1) {
                    $return_details['product_id'] = $data['product_id'][$key];
                    $return_details['return_id'] = $order_return->id;
                    $return_details['seller_order_details_id'] = $data['seller_order_details'][$key];
                    $return_details['quantity'] = $data['quantity'][$key];
                    $return_details['sale_price'] = $data['sale_price'][$key];

                    ReturnDetails::create($return_details);
                }
            }

            $status = array_sum($data['quantity']) == $order->quantity ? Enum::ORDER_STATUS_TYPE_RETURNED : Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED;
            $order->update(['order_status' => $status]);
            $order->order->update(['order_status' => $status]);

            // event(new StatusChanged($order));

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }

    //=================== Seller  Orders ======================//

    private function sellerActionHtml($row, $customerId = null)
    {
        $actionHtml = '';

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_show')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.user.seller.order.show', $row->id) . '" ><i class="far fa-eye"></i> View </a>';
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

    public function sellerOrderDataTable($seller_id = null)
    {
        $query = SellerOrder::with('order.customer', 'seller', 'operator');

        if ($seller_id) {
            $query->where('seller_id', $seller_id);
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_id', function ($row) {
                return $row?->customer?->full_name ?? 'N/A';
            })
            ->addColumn('invoice_id', function ($row) {
                $name = $row?->invoice_id;

                return !Helper::hasAuthRolePermission('order_show') ? $name : '<a href="' . route('admin.user.seller.order.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
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

            ->editColumn('order_status', function ($row) {
                return getOrderStatus($row->order_status);
            })
            ->editColumn('payment_status', function ($row) {
                return $this->getPaymentStatus($row->payment_status);
            })
            ->editColumn('payment_type', function ($row) {
                return Enum::getOrderPaymentType($row->payment_type);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->addColumn('action', function ($row) {
                return $this->sellerActionHtml($row);
            })

            ->rawColumns(['action', 'operator', 'order_status', 'payment_status', 'invoice_id'])
            ->make(true);
    }
}
