<?php

namespace App\Library\Services\Public;

use Exception;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Helper;
use App\Models\OrderReturn;
use App\Models\SellerOrder;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use App\Models\ReturnDetails;
use Illuminate\Support\Facades\DB;
use App\Events\Order\StatusChanged;
use App\Library\Services\Admin\BaseService;

class OrderService extends BaseService
{
    //=================== Order Return======================//
    public function return(array $data, SellerOrder $seller_order): bool
    {
        DB::beginTransaction();
        // dd($data);

        try {
            $subTotal = $seller_order->coupon_id ? $data["sub_total"] : array_sum($data["sub_total"]);

            $return['invoice_id'] = generateReturnInvoiceId();
            $return['seller_order_id'] = $seller_order->id;
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

            $status = array_sum($data['quantity']) == $seller_order->quantity ? Enum::ORDER_STATUS_TYPE_RETURNED : Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED;
            $seller_order->update(['order_status' => $status]);
            $seller_order->order->update(['order_status' => $status]);

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
         } catch (Exception $e) {

             return $this->handleException($e);
         }
    }
    //=================== Seller  Orders ======================//

    public function cancelOrder(Order $order): bool
    {
        DB::BeginTransaction();

        try {
            $data['customer_id'] = auth()->id();

            foreach($order->load('sellerOrders.sellerOrderDetails.product')->sellerOrders as $key => $sellerOrder) {

                foreach ($sellerOrder->sellerOrderDetails->load('product', 'sellerOrder.seller') as $orderDetails) {
                    $product = $orderDetails->product;
                    $product->update(['current_stock' => $product->current_stock + $orderDetails->quantity]);
                    $findProductStock = ProductStock::find($orderDetails->stock_variant_id);
                    $findProductStock->update(['current_stock' => $findProductStock->current_stock + $orderDetails->quantity]);

                }

                $sellerOrder->update(['order_status' => Enum::ORDER_STATUS_TYPE_CANCELED]);
            }

            $order->update(['order_status' => Enum::ORDER_STATUS_TYPE_CANCELED]);

            DB::commit();

            return $this->handleSuccess('Successfully Canceled');

        } catch (Exception $e) {
            DB::rollback();
            Helper::log($e);

            return $this->handleException($e);
        }
    }

}
