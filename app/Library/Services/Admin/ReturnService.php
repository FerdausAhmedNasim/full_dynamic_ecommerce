<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Payment;
use App\Models\Attachment;
use App\Models\OrderReturn;
use App\Models\OrderDetails;
use App\Models\ReturnDetails;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReturnService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.return.show', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('return_show')) {
                $actionHtml .= '<a class="dropdown-item" href="' . $route . '" ><i class="far fa-eye"></i> View  </a>';
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

    public function dataTable(array $filter_params)
    {
        $query = OrderReturn::with('sellerOrder.seller', 'operator');
        
        if (isset($filter_params['status'])) {
            $query->where('status', $filter_params['status']);
        }
       
        $query->whereHas('sellerOrder', function ($q) {
            $q->where('seller_id', sellerId());
        });
        
        $data = $query->get();
        
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('invoice_id', function ($row) {
                $name = $row->invoice_id;

                return !Helper::hasAuthRolePermission('return_show') ? $name : '<a href="' . route('admin.return.show', $row->id) . '" class="text-success pr-2">' . $name . '</a>';
            })
            ->editColumn('seller_name', function ($row) {
                return $row->sellerOrder?->seller?->full_name;
            })
            ->editColumn('total_amount', function ($row) {
                return getFormattedAmount($row->total_amount);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->addColumn('status', function ($row) {
                return $row->statusHtml();
            })

            ->rawColumns(['action', 'operator', 'invoice_id', 'status'])
            ->make(true);
    }

    public function store(array $data, Order $order): bool
    {
        DB::beginTransaction();

        try {
            $return = $this->createOrderReturn($data, $order);
            // $this->updateOrder($data, $order);

            foreach ($data['product_id'] as $key => $value) {

                if ((int) $data['is_return'][$key] != 0) {
                    $orderDetails = $this->updateOrderDetails($data, $order, $key, $value);
                    $this->createReturnDetails($data, $return->id, $key, $value, $orderDetails);

                }
            }

            $this->createPayment($data['total_amount'], $return->id);
            $this->storeAttachments($data, $return);

            DB::commit();

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function updateStatus($status, OrderReturn $order_return)
    {
        $order_return->status = $status;

        return $order_return->save();
    }

    private function updateOrder(array $data, Order $order)
    {
        $order_data['operator_id'] = auth()->id();
        $order_data['total_amount'] = $order->total_amount - $data['total_amount'] + $data['refund_discount_amount'] - ($data['refund_packaging_amount'] + $data['refund_delivery_amount']);
        $order_data['sub_total_amount'] = $order->total_amount - $data['total_amount'];

        return $order->update($order_data);
    }

    private function updateOrderDetails(array $data, Order $order, $key, $value)
    {
        $order_details = OrderDetails::where([['order_id', $order->id], ['product_id', $value]])->first();
        $order_details->return_quantity = $order_details->return_quantity + $data['return_quantity'][$key];

        $this->updateStock($order_details->stock, $data['return_quantity'][$key]);

        $order_details->save();

        return $order_details->id;
    }

    private function createOrderReturn(array $data, Order $order)
    {
        $discount_amount = $data['refund_discount_amount'] ?? 0;
        $packaging_cost = $data['refund_packaging_amount'] ?? 0;
        $delivery_cost = $data['refund_delivery_amount'] ?? 0;
        $sub_total = $data['total_amount'] - $packaging_cost - $delivery_cost + $discount_amount;

        $order_return['order_id'] = $order->id;
        $order_return['operator_id'] = auth()->id();
        $order_return['invoice_id'] = generateReturnInvoiceId();
        $order_return['type'] = Enum::ORDER_TYPE_SALE;
        $order_return['cache_payment_amount'] = $data['total_amount'];
        $order_return['note'] = $data['note'];
        $order_return['refund_discount_amount'] = $discount_amount;
        $order_return['refund_packaging_amount'] = $packaging_cost;
        $order_return['refund_delivery_amount'] = $delivery_cost;
        $order_return['refund_sub_total_amount'] = $sub_total;
        $order_return['refund_total_amount'] = $data['total_amount'];
        $order_return['order_status'] = Enum::ORDER_STATUS_TYPE_PROCESSING;

        return OrderReturn::create($order_return);
    }

    private function createReturnDetails(array $data, $return_id, $key, $value, $orderDetails)
    {
        $order_details['return_id'] = $return_id;
        $order_details['product_id'] = $value;
        $order_details['quantity'] = $data['return_quantity'][$key];
        $order_details['order_details_id'] = $orderDetails;

        return ReturnDetails::create($order_details);
    }

    // private function updateStock(Stock $stock, $qty)
    // {
    //     $stock->quantity = $stock->quantity + $qty;
    //     $stock->operator_id = auth()->id();

    //     return $stock->save();

    //     return $stock;
    // }

    // private function updateStockHistory(array $data, $key, $stock)
    // {
    //     $stock_history = StockHistory::where('stock_id', $stock->id)->first();
    //     $stock_history->quantity = $stock_history->quantity + $data['return_quantity'][$key];
    //     $stock_history->operator_id = auth()->id();

    //     return $stock_history->save();
    // }

    private function createPayment($total_amount, $return_id)
    {
        $payment['type'] = Enum::PAYMENT_TYPE_SALE_RETURN;
        $payment['return_id'] = $return_id;
        $payment['operator_id'] = auth()->id();
        $payment['payment_method'] = "Manual";
        $payment['amount'] = $total_amount;

        return Payment::create($payment);
    }

    private function storeAttachments(array $data, OrderReturn $order_return)
    {
        if (isset($data['attachment'])) {
            foreach ($data['attachment'] as $index => $attachment) {
                if (isset($attachment)) {
                    $data['attachment'] = AttachmentService::getAttachment($attachment);
                }

                $attachment = new Attachment();
                $attachment->name = $data['name'][$index];
                $attachment->attachment = $data['attachment'];
                $attachment->operator_id = auth()->id();
                $order_return->attachments()->save($attachment);
            }
        }
    }

}
