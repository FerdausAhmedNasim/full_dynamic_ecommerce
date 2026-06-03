<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Vite;
use App\Library\Services\Admin\OrderService;
use App\Http\Requests\Admin\Order\OrderPayRequest;
use App\Http\Requests\Admin\Order\OrderUpdateRequest;
use App\Models\SellerOrder;

class SellerOrderController extends Controller
{
    use ApiResponse;

    private $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index(Request $request, User $user)
    {
        if ($request->ajax()) {
            return $this->order_service->sellerOrderDataTable($user->id);
        }

        return view('admin.pages.user.seller.order.index', compact('user'));
    }

    public function showUpdateForm(Order $order): View
    {
        return view('admin.pages.order.edit', [
            'order'          => $order,
            'orderDetails'   => $order?->orderDetails2->load('product', 'stock'),
            'paymentDetails' => $order?->paymentDetails,
            'stocks'         => $order?->stocks->load('product'),
            'products'       => Product::active()->get(),
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $result = $this->order_service->edit($request->validated(), $order);

        if ($result) {
            return redirect()->route('admin.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function showOrder(SellerOrder $seller_order): View
    {
        return view('admin.pages.user.seller.order.show', [
            'seller_order'   => $seller_order->load('order'),
            'orderDetails'   => $seller_order?->sellerOrderDetails->load('productLanguage', 'product'),
            'paymentDetails' => $seller_order?->payments,
            'returns'        => $seller_order->returns->load('returnDetails'),
            'return_amount'  => $seller_order->returns->sum('refund_total_amount'),
            'user'           => $seller_order->seller
        ]);
    }

    public function pay(OrderPayRequest $request, Order $order)
    {
        $result = $this->order_service->pay($request->validated(), $order);

        if ($result) {
            return redirect()->route('admin.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function changeStatus(SellerOrder $seller_order, Request $request)
    {
        $result = $this->order_service->changeStatus($seller_order, $request->payment_status);

        if ($result) {
            return redirect()->route('admin.user.seller.order.show', $seller_order->id)->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function invoiceView(Order $order): View
    {

        return view('admin.pages.order.invoice', [
            'order'        => $order->load('orderDetails2.product', 'customer'),
            'orderDetails' => $order?->orderDetails2->load('stock', 'product'),
        ]);
    }

    public function invoiceDownload(Order $order)
    {
        $image = base64_encode(file_get_contents(settings('invoice_logo') ? public_path(settings('invoice_logo')) : resource_path('images/logo.png')));
        $invoice_date = date('jS F Y', strtotime(now()));

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true])
        ->loadView(
            'admin.pages.order.download-invoice',
            [
                'order'        => $order->load('orderDetails2.product', 'customer'),
                'orderDetails' => $order?->orderDetails2->load('stock', 'product'),
                'image'        => $image,
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

        return view('admin.pages.member.order.index', ['user' => $user]);
    }

    public function showCustomerOrder(Order $order): View
    {
        return view('admin.pages.member.order.show', [
            'order'        => $order,
            'orderDetails' => $order?->orderDetails2->load('product'),
            // 'paymentDetails' => $order?->paymentDetails,
            'paymentDetails' => $order?->payments,
            'user'           => $order->customer,
        ]);
    }
}
