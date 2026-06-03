<?php

namespace App\Http\Controllers\Public;

use DB;
use App\Models\Cart;
use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Models\Coupon;
use App\Library\Helper;
use App\Models\Address;
use App\Models\BlackUser;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Public\CheckoutService;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Http\Requests\Public\Address\CreateRequest;
use App\Http\Requests\Public\Address\UpdateRequest;

class CheckoutController extends Controller
{
    use ApiResponse;

    private $checkout_service;

    public function __construct(CheckoutService $checkout_service)
    {
        $this->checkout_service = $checkout_service;
    }

    public function checkout()
    {
        $cartIdentifier = request()->cookie('cart_identifier');

        $cartDataBySeller = Cart::with(['product', 'product.seller.coupons', 'product.seller.store'])
                            ->where('cart_identifier', $cartIdentifier)
                            ->get()
                            ->groupBy('product.seller.id');

        if (!count($cartDataBySeller)) {
            return redirect()->route('public.home')->with('error', 'Your Cart is Empty');
        }

        $penaltyAmount = 0;
        $checkFraudUser = BlackUser::active()->where('user_id', auth()->id())->get();

        if (count($checkFraudUser) >= 2) {
            $penaltyAmount = settings('penalty_amount') ?? 0;
        }

        $address = collect();
        if (auth()->user()) {
            $address = Address::with('user', 'area', 'thana', 'thana.district', 'area.division', 'thana.district.division')
                    ->where('user_id', authUser()->id)
                    ->get();
        }

        return view('public.pages.checkout.checkout', [
            'cartDataBySeller'  => $cartDataBySeller,
            'penaltyAmount'     => $penaltyAmount,
            'totalShippingCost' => Helper::calculateShippingCost(),
            'addresses'         => $address,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->where('seller_id', $request->sellerId)->first();

        if ($coupon) {
            if ($request->subTotal < $coupon->minimum_shopping) {
                $minimumShopping = getFormattedAmount($coupon->minimum_shopping);

                return response()->json(['success' => false, 'message' => "You have to purchase minimum amount: $minimumShopping "]);
            }

            $discount = $coupon->discount;

            if ($coupon->discount_type == Enum::DISCOUNT_TYPE_PERCENTAGE) {
                $discount = ($request->subTotal * $discount) / 100;
                
                if ($coupon->maximum_discount) {
                    if ($discount > $coupon->maximum_discount) {
                        $discount = $coupon->maximum_discount;
                    }
                }
            }

            if ($coupon->discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                
                if ($coupon->maximum_discount) {
                    if ($discount > $coupon->maximum_discount) {
                        $discount = $coupon->maximum_discount;
                    }
                }
            }

            return response()->json(['success' => true, 'discount_amount' => (int) $discount]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }
    }


    public function placeOrder(Request $request)
    {
        $cart_array = json_decode($request->cart_json, true);
        $cart_array['transaction_id'] = uniqid();

        $total_amount = 0;

        // check total amount is less than 10 or not, if yes then show error because you cant not pay less than 10
        // if ($cart_array['paymentMethod'] == 'cashOnDelivery' && settings('advance_shipping_cost') == 1) {
        //     $total_amount = $cart_array['shippingPrice'] + $cart_array['penalty_amount'];

        //     if ($total_amount < 10) {
        //         return response()->json(['success' => false, 'message' => 'Opps! something went wrong']);
        //     }

        // } else if ($cart_array['paymentMethod'] == 'onlinePayment') {
        //     $total_amount = $cart_array['orderTotalPrice'];

        //     if ($total_amount < 10) {
        //         return response()->json(['success' => false, 'message' => 'Opps! something went wrong']);
        //     }
        // }

        // store data in database
        $result = $this->checkout_service->storeOrder($cart_array);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Order is Successfully Placed']);
        } 
        // else if ($result) {
        //     // SSLCommerze info and make payment
        //     $post_data = array();
        //     $post_data['total_amount'] = $total_amount; # You cant not pay less than 10
        //     $post_data['currency'] = "BDT";
        //     $post_data['tran_id'] = $cart_array['transaction_id'];

        //     # CUSTOMER INFORMATION
        //     $customer = auth()->user();
        //     $post_data['cus_name'] = 'Demo Customer';
        //     $post_data['cus_email'] = 'demo@gmail.com';
        //     $post_data['cus_add1'] = 'Demo Customer Address';
        //     $post_data['cus_add2'] = "";
        //     $post_data['cus_city'] = "";
        //     $post_data['cus_state'] = "";
        //     $post_data['cus_postcode'] = "";
        //     $post_data['cus_country'] = "Bangladesh";
        //     $post_data['cus_phone'] = '01717000000';
        //     $post_data['cus_fax'] = "";

        //     # SHIPMENT INFORMATION
        //     $post_data['ship_name'] = "Store Test";
        //     $post_data['ship_add1'] = "Dhaka";
        //     $post_data['ship_add2'] = "Dhaka";
        //     $post_data['ship_city'] = "Dhaka";
        //     $post_data['ship_state'] = "Dhaka";
        //     $post_data['ship_postcode'] = "1000";
        //     $post_data['ship_phone'] = "";
        //     $post_data['ship_country'] = "Bangladesh";

        //     $post_data['shipping_method'] = "NO";
        //     $post_data['product_name'] = "Computer";
        //     $post_data['product_category'] = "Goods";
        //     $post_data['product_profile'] = "physical-goods";

        //     $sslc = new SslCommerzNotification();
        //     $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        //     if (!is_array($payment_options)) {
        //         print_r($payment_options);
        //         $payment_options = array();
        //     }
        // }
        else {
            return response()->json(['success' => false, 'message' => 'Order is not Placed.']);
        }
    }

    public function confirmOrder()
    {
        // if (!auth()->check()) {
        //     return redirect()->route('login')->with('error', 'You must have to login first.');
        // }

        $order = Order::with('customer', 'sellerOrders.sellerOrderDetails.product.seller.store')
            ->where('customer_id', auth()->id())
            ->latest()
            ->first();

        session()->flash('success', 'Order Placed Successfully Completed.');

        return view('public.pages.checkout.invoice', [
            'order' => $order
        ]);
    }

    public function makeDefaultShipping(Request $request)
    {
        $address = Address::where('user_id', authUser()->id)->where('id', $request->id)->first();

        if ($address->primary) {
            return response()->json([
                'message' => 'Already Active Shipping'
            ]);
        }
        $defaultShipping_address = Address::where("primary", Enum::DEFAULT_SHIPPING_ACTIVE)->where("user_id", authUser()->id)->first();
        $address['primary'] = Enum::DEFAULT_SHIPPING_ACTIVE;

        if ($defaultShipping_address) {
            $defaultShipping_address['primary'] = Enum::DEFAULT_SHIPPING;
            $defaultShipping_address->update();
        }

        $result = $address->update();

        $totalShippingCost = Helper::calculateShippingCost();

        if ($result) {
            return response()->json([
                'address' => $address,
                'totalShippingCost' => $totalShippingCost
            ]);
        }

        return response()->json([
            'message' => 'Shipping Address is not updated something wrong'
        ]);
    }

    public function createAddress(CreateRequest $request)
    {
        DB::beginTransaction();

        if (! authUser()) {
            $findUser = User::where('user_type', Enum::USER_TYPE_CUSTOMER)
                    ->where('phone', $request->phone)
                    ->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $data = $request->all();
                $data['password'] = bcrypt($request->phone);
                $data['user_type'] = Enum::USER_TYPE_CUSTOMER;
                $data['status'] = Enum::USER_STATUS_ACTIVE;
                $user = User::create($data);
    
                Auth::login($user);
            }
        }

        abort_unless(authUser(), 404);

        if ($request->validated()) {
            $address_data = $request->validated();
            $oldAddress = Address::where('user_id', authUser()->id)->get();
            
            $address_data['primary'] = count($oldAddress) < 1 ? Enum::DEFAULT_SHIPPING_ACTIVE : Enum::DEFAULT_SHIPPING;
            $address_data['user_id'] = authUser()->id;
            $address_data['location'] = Address::determineLocation($address_data);
            $result = Address::create($address_data);

            DB::commit();

            if ($result) {
                return redirect()->route('checkout', ["addresses" => Address::where('user_id', authUser()->id)->get()])->with("success");
            }
        }

        return back()->withInput($request->all())->with('error');
    }

    public function updateAddress(UpdateRequest $request, Address $address)
    {
        abort_unless(authUser(), 404);
        $address_data = $request->validated();
        $address_data['location'] = Address::determineLocation($address_data);
        $result = $address->update($address_data);

        if ($result) {
            return redirect()->route('checkout', ["addresses" => Address::where('user_id', authUser()->id)->get()])->with("success");
        }

        return back()->withInput($request->all())->with('error');
    }

    public function destroy(Address $address): RedirectResponse
    {
        abort_unless($address, 404);
        $address->delete();

        return redirect()->route('checkout', [
            "addresses" => Address::where('user_id', authUser()->id)->get()
        ])->with('success', "Successfully Delete");
    }
}
