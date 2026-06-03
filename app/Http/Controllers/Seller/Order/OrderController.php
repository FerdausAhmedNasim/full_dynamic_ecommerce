<?php

namespace App\Http\Controllers\Seller\Order;

use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Vite;
use App\Http\Requests\Admin\Order\OrderPayRequest;
use App\Library\Services\Seller\Order\OrderService;
use App\Http\Requests\Admin\Order\OrderUpdateRequest;

class OrderController extends Controller
{
    use ApiResponse;

    private $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filterParams = $request->only(['status', 'range', 'fromDate', 'toDate']);

            return $this->order_service->dataTable($filterParams);
        }

        return view('seller.pages.order.index');
    }

    public function showUpdateForm(Order $order): View
    {
        return view('seller.pages.order.edit', [
            'order'          => $order,
            'orderDetails'   => [],
            'paymentDetails' => $order?->paymentDetails,
            'stocks'         => $order?->stocks->load('product'),
            'products'       => Product::active()->get(),
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $result = $this->order_service->edit($request->validated(), $order);

        if ($result) {
            return redirect()->route('seller.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function show(SellerOrder $sellerOrder): View
    {
        return view('seller.pages.order.show', [
            'order' => $sellerOrder->load('order.customer', 'returns.returnDetails', 'store.storeLanguage', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),
        ]);
    }

    public function pay(OrderPayRequest $request, Order $order)
    {
        $result = $this->order_service->pay($request->validated(), $order);

        if ($result) {
            return redirect()->route('seller.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function changeStatus(SellerOrder $seller_order, Request $request)
    {
        if ($seller_order->order_status == Enum::ORDER_STATUS_TYPE_NOT_RECEIVED && isset($seller_order->blackUser)) {
            return back()->with('error','Status already set not received');
        }

        $result = $this->order_service->changeStatus($seller_order, $request->status);

        if ($result) {
            return redirect()->route('seller.order.show', $seller_order->id)->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function invoiceView(SellerOrder $seller_order): View
    {
        $seller_order->load('order.customer', 'store.storeLanguage', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage');

        return view('seller.pages.order.invoice', [
            'seller_order' => $seller_order->load('order.customer', 'store.storeLanguage', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),
        ]);
    }

    public function invoiceDownload(SellerOrder $order)
    {
        $image = base64_encode(file_get_contents(settings('invoice_logo') ? public_path(settings('invoice_logo')) : resource_path('images/logo.png')));
        $invoice_date = date('jS F Y', strtotime(now()));

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true])
        ->loadView(
            'seller.pages.order.download-invoice',
            [
                'order' => $order->load('order.customer', 'store.storeLanguage', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),
                'image' => $image,
            ]
        )->setPaper('a4');

        return $pdf->download('Invoice_' . config('app.name') . '_Order_No # ' . $order->id . ' Date_' . $invoice_date . '.pdf');
    }


    //==================== Customer Orders ==================//
    public function customerOrders(Request $request, User $user)
    {
        if ($request->ajax()) {
            return $this->order_service->dataTableForCustomer($user);
        }

        return view('seller.pages.member.order.index', ['user' => $user]);
    }

    public function showCustomerOrder(Order $order): View
    {
        return view('seller.pages.member.order.show', [
            'order' => $order,
            //'orderDetails'   => $order?->orderDetails2->load('product'),
            'orderDetails' => $order,
            // 'paymentDetails' => $order?->paymentDetails,
            'paymentDetails' => $order?->payments,
            'user'           => $order->customer,
        ]);
    }
}
