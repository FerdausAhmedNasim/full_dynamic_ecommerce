<?php

namespace App\Library\Services\Public;

use Exception;
use App\Models\Cart;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Coupon;
use App\Library\Helper;
use App\Models\Payment;
use App\Models\Product;
use App\Models\BlackUser;
use App\Models\SellerOrder;
use App\Models\ProductStock;
use App\Models\SellerOrderDetails;
use Illuminate\Support\Facades\DB;
use App\Library\Services\Admin\BaseService;

class CheckoutService extends BaseService
{
    public function storeOrder(array $data): bool
    {
        DB::BeginTransaction();

        try {
            $data['customer_id'] = auth()?->id();

            $cartIdentifier = request()->cookie('cart_identifier');
            $query = Cart::where('cart_identifier', $cartIdentifier);

            // $getTotalQuantity = $query->sum('quantity');

            $note = 'Only Shipping Cost Collected through SSL Commerz';
            $collected_amount = 0;
            $amount_to_be_collect = 0;
            $payment_status = Enum::ORDER_PAYMENT_STATUS_UNPAID;

            // if ($data['paymentMethod'] == 'cashOnDelivery' && settings('advance_shipping_cost') == 1) {
            //     $collected_amount = $data['shippingPrice'] + $data['penalty_amount'];
            //     $amount_to_be_collect = $data['subtotalPrice'];
            //     $note = 'Only Shipping Cost Collected through SSL Commerz';
            //     $payment_type = Enum::ORDER_PAYMENT_TYPE_COD;
            // } else if ($data['paymentMethod'] == 'onlinePayment') {
            //     $collected_amount = $data['orderTotalPrice'];
            //     $note = 'Full Amount Collected through SSL Commerz';
            //     $payment_type = Enum::ORDER_PAYMENT_TYPE_DIGITAL;
            // } else {
            //     $amount_to_be_collect = $data['subtotalPrice'] + $data['shippingPrice'];
            //     $payment_type = Enum::ORDER_PAYMENT_TYPE_COD;
            // }

            $orderData = [
                'transaction_id'       => $data['transaction_id'],
                'invoice_id'           => generateInvoiceId(),
                'customer_id'          => $data['customer_id'],
                'operator_id'          => $data['customer_id'],
                'order_person_name'    => $data['orderPersonName'],
                'order_person_phone'   => $data['orderPersonPhone'],
                'order_person_address' => $data['orderPersonAddress'],
                'shipping_area'        => $data['shippingArea'],
                // 'address_id'           => $data['shippingAddress'],
                'quantity'             => $data['totalQuantity'],
                'sub_total_amount'     => $data['subtotalPrice'],
                'total_amount'         => $data['orderTotalPrice'],
                'discount_amount'      => $data['couponPrice'],
                'shipping_cost'        => $data['shippingPrice'],
                'note'                 => $note,
                'payment_status'       => $payment_status,
                'penalty_amount'       => $data['penalty_amount'],
                'collected_amount'     => $collected_amount,
                'amount_to_be_collect' => $amount_to_be_collect,
                'payment_type'         => Enum::ORDER_PAYMENT_TYPE_COD,
                // 'ezzico_discount'      => $data['ezzico_discount'],
            ];

            $order = Order::create($orderData);

            $cartItemsGroupedBySeller = $query->with(['product', 'product.seller', 'product.seller.store'])
                                ->get()
                                ->groupBy('product.seller.id');

            // foreach ($cartItemsGroupedBySeller as $seller_id => $sellerData) {
                $coupon_id = '';
                $quantity = '';
                $sub_total_amount = '';
                $discount_amount = '';
                $total_amount = '';
                // $ezzico_discount = '';

                // Loop through the array to search for the given seller_id
                foreach ($data['sellerCartData'] as $cartData) {
                    if ($cartData['seller_id'] == 2) {
                        $coupon_id = $cartData['coupon_code'] ? Coupon::where('code', $cartData['coupon_code'])->first()->id : null;
                        $quantity = $cartData['sellerQuantity'];
                        $sub_total_amount = $cartData['sellerSubTotal'];
                        $discount_amount = $cartData['seller_coupon_discount'];
                        $total_amount = $data['orderTotalPrice'];
                        // $ezzico_discount = $cartData['sellerEzzicoDiscount'];

                        break;
                    }
                }

                $sellerOrderData = [
                    'order_id'         => $order->id,
                    'seller_id'        => 2,
                    'operator_id'      => $data['customer_id'],
                    'coupon_id'        => $coupon_id,
                    'quantity'         => $quantity,
                    'sub_total_amount' => $sub_total_amount,
                    'discount_amount'  => $discount_amount,
                    'total_amount'     => $total_amount,
                    'shipping_cost'    => $data['shippingPrice'],
                    'payment_date'     =>  null,
                    'payment_type'     => Enum::ORDER_PAYMENT_TYPE_COD,
                    'payment_status'   => $payment_status,
                    // 'ezzico_discount'  => $ezzico_discount,
                ];

                $seller_order = SellerOrder::create($sellerOrderData);

                $commission_amount = 0;

                foreach ($data['orderProducts'] as $orderProduct) {
                    $cartItem = Cart::where('id', $orderProduct[1])->first();
                    $findProduct = Product::where('id', $cartItem?->product_id)->first();

                    abort_unless($findProduct, 404);

                    $findProduct->update(['current_stock' => $findProduct->current_stock - $orderProduct[0]]);

                    // Check if the variant exists && stock available or not
                    $productStockQuery = ProductStock::where('product_id', $cartItem?->product_id);

                    if (isset($cartItem->variant)) {
                        $findProductStock = $productStockQuery->where('variant_ids', $cartItem->variant)->first();
                    } else {
                        $findProductStock = $productStockQuery->first();
                    }

                    abort_unless($findProductStock, 404);

                    abort_if($findProductStock->current_stock < $cartItem->quantity, 403);

                    // Update stock
                    $findProductStock->update(['current_stock' => $findProductStock->current_stock - $orderProduct[0]]);
                    $cartItem->update(['quantity' => $orderProduct[0]]);

                    $salePrice = $cartItem->product->calculatePriceAfterDiscount($cartItem->price);

                    $sellerOrderDetailData = [
                        'seller_order_id'  => $seller_order->id,
                        'product_id'       => $cartItem->product_id,
                        'stock_variant_id' => $findProductStock?->id ?? null,
                        'quantity'         => $cartItem->quantity,
                        'product_price'    => $cartItem->price,
                        'sale_price'       => $salePrice,
                        'discount_type'    => $cartItem?->product?->productDetails?->discount_type ?? null,
                        'discount'         => $cartItem?->product?->productDetails?->discount ?? 0,
                        // 'ezzico_discount'  => $cartItem->ezzico_discount,
                        // 'shipping_cost'    => 0,
                    ];

                    SellerOrderDetails::create($sellerOrderDetailData);

                    $parentCategory = parentCategory(Product::find($cartItem->product_id)->category_id);

                    // $sellerCategory = SellerCategory::where('seller_id', $seller_id)
                    //                                 ->where('category_id', $parentCategory->id)
                    //                                 ->first();

                    // if ($cartItem->ezzico_discount == 0) {
                    //     $commission_rate = $sellerCategory?->commission_rate ?? 0;
                    //     $commission_amount += ($commission_rate / 100) * ($salePrice * $cartItem->quantity);
                    // }
                }

                $seller_order->commission_amount = $commission_amount;
                $seller_order->Save();
            // }

            // Remove Items from Cart after Completed Order
            if ($order) {
                $myCartItems = $query->get();

                foreach ($myCartItems as $cartItem) {
                    $cartItem->delete();
                }
            }

            // Payment
            $payment['type'] = Enum::PAYMENT_TYPE_SALE;
            $payment['order_id'] = $order->id;
            $payment['operator_id'] = auth()?->id();
            $payment['payment_method'] = Enum::ORDER_PAYMENT_TYPE_COD;
            $payment['amount'] = $order->collected_amount;
            $payment['transaction_id'] = $data['transaction_id'];
            $payment['note'] = $order->note;
            $payment['payment_status'] = Enum::PAYMENT_STATUS_FAILED;
            Payment::create($payment);

            // $blackLists = BlackUser::getBlackLists();
            // if ($data['penalty_amount'] > 0 && count($blackLists) >= 2) {
            //     foreach ($blackLists as $blackList) {
            //         $blackList->update([
            //             'active' => false,
            //             'penalty_payment_date' => now(),
            //         ]);
            //     }
            // }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            DB::rollback();
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
