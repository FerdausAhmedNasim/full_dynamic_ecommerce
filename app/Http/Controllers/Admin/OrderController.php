<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Store;
use App\Models\Address;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Traits\ApiResponse;
use App\Models\CourierPricingPlan;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\OrderService;
use App\Http\Requests\Admin\Order\OrderPayRequest;
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
        $filterParams = $request->only(['status', 'range', 'fromDate', 'toDate']);

        $stores = Store::select('id')->with('storeLanguage:store_name,store_id')
                    ->get();

        if ($request->ajax()) {
            return $this->order_service->dataTable($filterParams);
        }

        return view('admin.pages.order.index', compact('stores'));
    }

    public function createForm () {
        return view('admin.pages.order.purchase.create');
    }

    public function showUpdateForm(SellerOrder $order): View
    {
        return view('admin.pages.order.edit', [
            'order' => $order->load('sellerOrderDetails.product'),
        ]);
    }

    public function update(Request $request, SellerOrder $order)
    {
        $result = $this->order_service->edit($request->all(), $order);

        if ($result) {
            return redirect()->route('admin.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function deleteOrderProduct(Request $request, SellerOrder $order)
    {
        $orderProduct = $order->sellerOrderDetails->where('id', $request->detail_id)->first();
        $totalAmount = $orderProduct->sale_price * $orderProduct->quantity;

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
        $totalShippingCost = 0;

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
        
        $order->update([
            'sub_total_amount' => $order->sub_total_amount - $totalAmount,
            'total_amount' => $order->total_amount - $totalAmount - $totalShippingCost,
            'quantity' => $order->quantity - $orderProduct->quantity,
            'shipping_cost' => $order->shipping_cost - $totalShippingCost,
        ]);

        $updated = $order->order->update([
            'sub_total_amount' => $order->order->sub_total_amount - $totalAmount,
            'total_amount' => $order->order->total_amount - $totalAmount - $totalShippingCost,
            'quantity' => $order->order->quantity - $orderProduct->quantity,
            'shipping_cost' => $order->order->shipping_cost - $totalShippingCost,
        ]);

        if ($updated) {
            $result = $orderProduct->delete();

            if ($result) {
                return response()->json(['status' => 'success'], 200);
            }
        }

        return response()->json(['status' => 'error'], 404);
    }

    public function show(SellerOrder $order): View
    {
        return view('admin.pages.order.show', [
            'order' => $order->load('order', 'order.customer', 'order.returns.returnDetails', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),
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

    public function changeStatus(SellerOrder $order, Request $request)
    {
        // if ($order->order_status == Enum::ORDER_STATUS_TYPE_NOT_RECEIVED && isset($order->blackUser)) {
        //     return back()->with('error','Status already set not received');
        // }

        $result = $this->order_service->changeStatus($order, $request->status);

        if ($result) {
            return redirect()->route('admin.order.show', $order->id)->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    public function changePaymentStatus(SellerOrder $order, Request $request)
    {
        $result = $this->order_service->changePaymentStatus($order, $request->status);

        if ($result) {
            return redirect()->route('admin.order.show', $order->id)->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);
    }

    // Return 
    public function showCreateForm(SellerOrder $order): View
    {
        return view('admin.pages.order.order_return', [
            'sellerOrder'    => $order,
            'orderDetails'   => $order?->sellerOrderDetails->load('product'),
            'paymentDetails' => $order?->paymentDetails,
            'order_status'   => Enum::getOrderStatusType(),
            'couponDiscount' => $order->coupon_id ? $order->discount_amount : 0,
        ]);
    }

    public function orderReturnStore(Request $request, SellerOrder $order)
    {
        $result = $this->order_service->return($request->all(), $order);

        if ($result) {
            return redirect()->route('admin.order.index')->with('success', $this->order_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->order_service->message);

    }

    public function shippingMarkPaid(Order $order)
    {
        $order->payment_status = Enum::ORDER_PAYMENT_STATUS_PARTIAL;
        $order->save();

        return back()->with('success', 'Order marked as shipping cost paid.');
    }

    public function invoiceView(SellerOrder $order): View
    {
        return view('admin.pages.order.invoice', [
            'order' => $order->load('order', 'order.customer', 'order.returns.returnDetails', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),
        ]);
    }

    public function invoiceDownload(SellerOrder $order)
    {
        $image = base64_encode(file_get_contents(settings('invoice_logo') ? public_path(settings('invoice_logo')) : resource_path('images/logo.png')));
        $invoice_date = date('jS F Y', strtotime(now()));

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true])
        ->loadView(
            'admin.pages.order.download-invoice',
            [
                'order' => $order->load('order', 'order.customer', 'order.returns.returnDetails', 'sellerOrderDetails.product', 'sellerOrderDetails.productLanguage'),

                //'order'        => $order->load('orderDetails2.product', 'customer'),
                //'orderDetails' => $order?->orderDetails2->load('stock', 'product'),
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

        return view('admin.pages.user.customer.order.index', ['user' => $user]);
    }

    public function showCustomerOrder(Order $order): View
    {
        return view('admin.pages.user.customer.order.show', [
            'order'        => $order,
            'sellerOrders' => $order?->sellerOrders->load( 'sellerOrderDetails.product.productLanguages'),
            // 'paymentDetails' => $order?->paymentDetails,
            'paymentDetails' => $order?->payments,
            'user'           => $order->customer,
        ]);
    }
}
