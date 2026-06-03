<?php

namespace App\Http\Controllers\Public;

use App\Library\Enum;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $sslc = new SslCommerzNotification();

        $order = Order::where('transaction_id', $tran_id)->first();

        if ($order->payment_status == Enum::ORDER_PAYMENT_STATUS_UNPAID) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                $status = $order->amount_to_be_collect > 0 ? Enum::ORDER_PAYMENT_STATUS_PARTIAL : Enum::ORDER_PAYMENT_STATUS_PAID;
                
                // Update Order Payment Status
                $order->update([
                    'payment_status' => $status
                ]);

                // Update Seller Order Payment Status
                foreach ($order->sellerOrders as $sellerOrder) {
                    $sellerOrder->update([
                        'payment_status' => $status == Enum::ORDER_PAYMENT_STATUS_PARTIAL ? Enum::ORDER_PAYMENT_STATUS_UNPAID : $status,
                    ]);
                }

                // Update Payment Status
                $payment = Payment::where('transaction_id', $tran_id)->first();

                $payment->update([
                    'payment_status' => Enum::PAYMENT_STATUS_SUCCESS,
                ]);

                return redirect()->route('confirm.order')->with('success', 'Order is Successfully Placed');
                // echo "<br >Transaction is successfully Completed";
            }
        } else if ($order->payment_status == Enum::ORDER_PAYMENT_STATUS_PAID || $order->payment_status == Enum::ORDER_PAYMENT_STATUS_PARTIAL) {
            // echo "Transaction is successfully Completed";
            return redirect()->route('confirm.order')->with('success', 'Order is Successfully Placed');
        } else {
            // echo "Invalid Transaction";
            return redirect()->route('public.home')->with('error', 'Invalid Transaction');
        }
    }

    public function fail(Request $request)
    {
        return redirect()->route('public.home')->with('error', 'Invalid Transaction');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('public.home')->with('error', 'Transaction Canceled');
    }

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');

            $order = Order::where('transaction_id', $tran_id)->first();

            if ($order->payment_status == Enum::ORDER_PAYMENT_STATUS_UNPAID) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order->amount, $order->currency);

                if ($validation == TRUE) {
                    // Update Order Payment Status
                    $status = $order->amount_to_be_collect > 0 ? Enum::ORDER_PAYMENT_STATUS_PARTIAL : Enum::ORDER_PAYMENT_STATUS_PAID;

                    $order->update([
                        'payment_status' => $status
                    ]);

                    // Update Seller Order Payment Status
                    foreach ($order->sellerOrders as $sellerOrder) {
                        $sellerOrder->update([
                            'payment_status' => $status == Enum::ORDER_PAYMENT_STATUS_PARTIAL ? Enum::ORDER_PAYMENT_STATUS_UNPAID : $status,
                        ]);
                    }

                    // Update Payment Status
                    $payment = Payment::where('transaction_id', $tran_id)->first();

                    $payment->update([
                        'payment_status' => Enum::PAYMENT_STATUS_SUCCESS,
                    ]);

                    return redirect()->route('confirm.order')->with('success', 'Order is Successfully Placed');
                    echo "Transaction is successfully Completed";
                }
            } else if ($order->payment_status == Enum::ORDER_PAYMENT_STATUS_PAID || $order->payment_status == Enum::ORDER_PAYMENT_STATUS_PARTIAL) {
                return redirect()->route('confirm.order')->with('success', 'Transaction is already successfully Completed');
            } else {
                return redirect()->route('public.home')->with('error', 'Invalid Transaction');
            }
        } else {
            return redirect()->route('public.home')->with('error', 'Invalid Data');
        }
    }
}
