<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Library\Services\Public\OrderService;

class OrderController extends Controller
{
    private $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index()
    {
        $customerId = authUser()->id;
        $order = SellerOrder::with('order', 'return', 'sellerOrderDetails')
                    ->whereHas('order', function ($query) use ($customerId) {
                        $query->where('customer_id', $customerId);
                    })
                    ->latest()
                    ->paginate(8);
      
        return view('public.member_dashboard.order.index', [
            'sellerOrders' => $order,
        ]);
    }

    public function showOrderProduct(Order $order)
    {
        return view('public.member_dashboard.order.show_order_product', [
            'order' => $order->load('sellerOrders.sellerOrderDetails.product', 'sellerOrders.seller'),
        ]);
    }

    public function orderReturnList()
    {
        $customerId = authId();
      
        return view('public.member_dashboard.order.return_list', [
            'returns' => OrderReturn::whereHas('sellerOrder.order', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->paginate(8),
        ]);
    }

    public function orderReturnShow(OrderReturn $orderReturn)
    {
        return view('public.member_dashboard.order.return_show', [
            'orderReturn' => $orderReturn->load('returnDetails.product'),
        ]);
    }

    public function orderReturn(Order $order)
    {
        $sellerOrder = $order->sellerOrders[0];

        return view('public.member_dashboard.order.order_return', [
            'order'          => $order->load('sellerOrders.store', 'sellerOrders.sellerOrderDetails.product', 'sellerOrders.seller'),
            'couponDiscount' => $sellerOrder->coupon_id ? $sellerOrder->discount_amount : 0,
        ]);
    }

    public function orderReturnStore(Request $request, SellerOrder $seller_order)
    {
        // dd($request->all());

        $result = $this->order_service->return($request->all(), $seller_order);

        if ($result) {
            return redirect()->route('dashboard.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);

    }

    public function orderCancel(Order $order)
    {
        $result = $this->order_service->cancelOrder($order);

        if ($result) {
            return redirect()->route('dashboard.order.index')->with('success', $this->order_service->message);
        }

        return back()->with('error', $this->order_service->message);

    }

    public function orderInvoice($invoice)
    {
        $order = Order::with('sellerOrders.store', 'sellerOrders.sellerOrderDetails.product', 'sellerOrders.seller', 'address')
                        ->where('invoice_id', $invoice)->first();
        $image = base64_encode(file_get_contents(settings('invoice_logo') ? public_path(settings('invoice_logo')) : resource_path('images/logo.png')));

        // dd($order->getFullAddressAttribute());

        return view('public.member_dashboard.order.invoice', [
            'order' => $order,
            'image' => $image,
        ]);
    }

    public function invoiceDownload(Order $order)
    {
        $image = base64_encode(file_get_contents(settings('invoice_logo') ? public_path(settings('invoice_logo')) : resource_path('images/logo.png')));
        $invoice_date = date('jS F Y', strtotime(now()));

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true])
        ->loadView(
            'public.member_dashboard.order.invoice_download',
            [
                'order' => $order->load('sellerOrders.store', 'sellerOrders.sellerOrderDetails.product', 'sellerOrders.seller'),
                'image' => $image,
            ]
        )->setPaper('a4');

        return $pdf->download('Invoice_' . config('app.name') . '_Order_No # ' . $order->id . ' Date_' . $invoice_date . '.pdf');
    }
}
