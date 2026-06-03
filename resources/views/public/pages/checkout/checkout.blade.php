@extends('public.layout.master')
    @section('title', 'Checkout')
@section('content')

{!! \App\Library\Html::breadcrumbsSection('Checkout') !!}

<section class="checkout-section section-b-space pt-4">
    <div class="container-fluid-lg">

        <form>
            <div class="row g-sm-4 g-3">
                <div class="col-lg-7">
                    {{-- <div class="address-add shadow-lg">
                        <button data-bs-toggle="modal" data-bs-target="#add_address">
                            <i class="fa fa-location-dot"></i>
                            <span>Add Address</span>
                        </button>
                    </div>

                    <div class="row g-sm-4 g-3 mt-0">
                        @if ($addresses->count() > 0)
                        @foreach ($addresses as $address)
                        <div class="col-xl-6 col-md-6">
                            <label for="defaultShipping{{ $address->id }}" class="w-100 h-100">
                                <div class="address-box {{ $address->primary ? 'active' : '' }}  shadow-lg h-100">
                                    <div class="position-relative">
                                        <div class="table-responsive address-table">
                                            <table class="table m-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Shipping Address</strong> :
                                                        </td>
                                                        <td>{{ $address->full_address }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="position-absolute end-0 top-0 me-2">
                                                <div class="dropdown">
                                                    <button class=" btn p-1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>

                                                            <ul class="dropdown-menu address-dropdown">
                                                                <div><a class="dropdown-item theme-color" data-bs-toggle="modal"
                                                                        data-bs-target="#update-address{{ $address->id }}">Edit</a>
                                                                </div>
                                                                <div><a class="dropdown-item text-danger"
                                                                        href="{{ route('checkout.address.delete', $address->id) }}">Delete</a>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="position-absolute top-0">
                                                        <div class="address-form-check m-0">
                                                            <input class="getAddress d-none" type="radio" value="{{ $address->id }}"
                                                                name="defaultShipping" id="defaultShipping{{ $address->id }}" {{
                                                                $address->primary ? 'checked' : '' }}>

                                                                @if($address->primary)
                                                                    <span class="deliver-card-active active">
                                                                        <span class="active-icon"><i class="fa-solid fa-check"></i></i></span>
                                                                    </span>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <div class="col-xl-4 col-md-6 shadow-lg p-2 text-center mx-auto">
                                <h3>Address are not available......</h3>
                            </div>
                        @endif
                    </div> --}}

                    @php
                        $orderSubTotal = 0;
                        $shipping = 0;
                        $couponDiscount = 0;
                        $orderTotal = 0;
                        $ezzicoDiscount = 0;
                        $isPickupHub = false;
                    @endphp

                    @foreach ($cartDataBySeller as $seller_id => $sellerData)
                        <div class="checkout-items shadow-lg">
                            @php
                                $totalItem = 0;
                                $subtotal = 0;
                                $saved = 0;
                                $sellerQuantity = 0;
                                $sellerEzzicoDiscount = 0;

                                $seller = \App\Models\User::with('userAddress')->find($seller_id);
                                $isPickupHub = $seller && $seller->userAddress ? true : false;

                                $coupon = $sellerData->first()->product->seller->coupons->where('active', true)->where('start_date', '<=', now()) ->where('end_date', '>=', now());
                            @endphp

                            <div class="checked-item">

                                @foreach ($sellerData as $cartItem)
                                    <div class="row pb-2 mb-2 border-bottom cart-items">
                                        <div class="col-md-7">
                                            <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                                                <div class="text-start mb-2 mb-md-0" style="width: 70px">
                                                    <img alt="user" class="img-fluid blur-up lazyload"
                                                        src="{{ $cartItem->product->getThumbnailImage() }}">
                                                </div>
                                                
                                                <input type="hidden" name="cart_id" class="cart_id" value="{{ $cartItem->id }}">

                                                <div class="text-start">
                                                    <p class="m-0">{{ $cartItem->product->getTranslation('title') }}</p>
                                                    @if ($cartItem->variant)
                                                        <small>{{ getProductVariantValue($cartItem->variant) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="h-100 d-flex justify-content-between align-items-center">
                                                <td class="quantity product_qnt">
                                                    <h4 class="table-title text-content">Qty</h4>
                                                    <div class="quantity-price">
                                                        <div class="cart_qty">
                                                            <div class="input-group">
                                                                <button type="button" class="btn qty-left-minus" data-type="minus"
                                                                    data-field="">
                                                                    <i class="fa fa-minus ms-0"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input" type="text"
                                                                    name="quantity" value="{{ $cartItem->quantity }}">
                                                                <button type="button" class="btn qty-right-plus" data-type="plus"
                                                                    data-field="">
                                                                    <i class="fa fa-plus ms-0"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="price" class="unitPrice"
                                                        value="{{ $cartItem->product->calculatePriceAfterDiscount($cartItem->price) }}">
                                                    <input type="hidden" name="current_stock" class="current_stock"
                                                        value="{{ $cartItem->product->current_stock }}">
                                                </td>

                                                <button class="border-0 ms-4 bg-transparent text-danger remove"
                                                    data-cart-item-id="{{ $cartItem->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                                <div class="price-col">
                                                    @if ($cartItem->product->has_discount)
                                                    <span class="price-box">
                                                        <del>{{ getFormattedAmount($cartItem->price) }}</del>
                                                    </span>
                                                    <br>
                                                    @endif

                                                    <input type="hidden" id="discountPrice" value="{{ $cartItem->price - $cartItem->product->calculatePriceAfterDiscount($cartItem->price) }}">
                                                    
                                                    <span class="ms-2 productPrice">{{
                                                        getFormattedAmount($cartItem->product->calculatePriceAfterDiscount($cartItem->price)
                                                        - $cartItem->ezzico_discount) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $totalItem = count($sellerData);

                                        $itemTotalAfterDiscount = 0;
                                        $itemTotalAfterDiscount = $cartItem->quantity *
                                        $cartItem->product->calculatePriceAfterDiscount($cartItem->price) - $cartItem->quantity *
                                        $cartItem->ezzico_discount;
                                        $subtotal += $itemTotalAfterDiscount;

                                        $itemTotalWithoutDiscount = $cartItem->quantity * $cartItem->price;
                                        $discountedAmount = $itemTotalWithoutDiscount - $itemTotalAfterDiscount;
                                        $saved += $discountedAmount;

                                        $sellerQuantity += $cartItem->quantity;
                                        $ezzicoDiscount += ($cartItem->quantity * $cartItem->ezzico_discount);
                                        $sellerEzzicoDiscount += ($cartItem->quantity * $cartItem->ezzico_discount);
                                    @endphp
                                @endforeach

                                <div class="d-flex justify-content-between align-items-center gap-3 mt-3 sellerItemFooter">
                                    <div></div>
                                    {{-- <div class="delivery-card">
                                        <span class="deliver-card-active">
                                            <span class="active-icon"><i class="fa-solid fa-check"></i></i></span>
                                        </span>
                                        <div class="delivery-title d-flex justify-content-between align-items-center gap-2">
                                            <h4>Delivery Title</h4>
                                            <span>৳85</span>
                                        </div>
                                        <p>Receive by 2 Apr - 9 Apr</p>
                                    </div> --}}

                                    @if (count($coupon) > 0)
                                    <div class="coupon-cart">
                                        <input type="hidden" name="seller_id" value="{{ $seller_id }}" class="seller_id">
                                        <input type="hidden" name="sub_total" value="{{ $subtotal }}" class="sub_total">
                                        <input type="hidden" name="seller_coupon_discount" value="0"
                                            class="seller_coupon_discount">

                                        <div class="coupon-box input-group">
                                            <input type="text" class="form-control coupon-apply" name="coupon_code"
                                                placeholder="Enter Coupon Code Here...">
                                            <button class="btn-apply">Apply</button>
                                        </div>
                                    </div>
                                    @else
                                    <input type="hidden" name="seller_id" value="{{ $seller_id }}" class="seller_id">
                                    <input type="hidden" name="sub_total" value="{{ $subtotal }}" class="sub_total">
                                    <input type="hidden" name="seller_coupon_discount" value="0"
                                        class="seller_coupon_discount">
                                    <input type="hidden" class="form-control coupon-apply" name="coupon_code" value="">
                                    @endif

                                    <input type="hidden" name="seller_sub_total" value="{{ $subtotal }}"
                                        class="seller_sub_total">
                                    <input type="hidden" name="seller_quantity" value="{{ $sellerQuantity }}"
                                        class="seller_quantity">
                                        
                                    <input type="hidden" name="seller_ezzico_discount" class="seller_ezzico_discount"
                                        value="{{ $sellerEzzicoDiscount }}">

                                    <div class="total-price text-right">
                                        {{-- <div class="shop-total-info">
                                            <span>{{ $totalItem }} Item(s).&nbsp;Subtotal:</span>
                                            <span class="shop-amount">{{ getFormattedAmount($subtotal) }}</span>
                                        </div> --}}
                                        <div>
                                            <h6 class="coupon-discount theme-color"></h6>

                                            @if($saved > 0)
                                            <h6 class="theme-color">Saved <span class="savePrice">{{ getFormattedAmount($saved) }}</span></h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @php
                                $orderSubTotal += $subtotal;
                            @endphp

                        </div>
                    @endforeach


                    {{-- <div class="row g-sm-4 g-3 mt-0">

                        @if (! settings('full_payment'))
                        <div class="col-xl-3 col-md-3">
                            <label for="cashOnDelivery" class="w-100">
                                <div class="payment-method-box shadow-lg active">
                                    <div class="position-relative">
                                        <div class="table-responsive address-table">
                                            <table class="table m-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Cash On Delivery</strong> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="position-absolute top-0">
                                                <div class="form-check m-0">
                                                    <span class="deliver-card-active active1">
                                                        <span class="active-icon"><i class="fa-solid fa-check"></i></i></span>
                                                    </span>
                                                    <input checked class="form-check-input payment_method d-none" type="radio" name="payment_method" id="cashOnDelivery" value="cashOnDelivery">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endif

                        <div class="col-xl-3 col-md-3">
                            <label for="onlinePayment" class="w-100">
                                <div class="payment-method-box shadow-lg">
                                    <div class="position-relative">
                                        <div class="table-responsive address-table">
                                            <table class="table m-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Online Payment</strong> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="position-absolute top-0">
                                                <div class="form-check m-0">
                                                    <input class="form-check-input payment_method d-none" type="radio" name="payment_method" id="onlinePayment" value="onlinePayment">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </div> --}}
                    <div class="summery-box p-4 shadow-lg mt-4">
                        <h3 class="text-center mb-2">Order Summary</h3> <hr>

                        <div class="my-3">
                            <h5>Select Delivery Area</h5>
                            <label for="inside_dhaka" class="p-3 border rounded-3 mt-3 d-block w-100">
                                <input type="radio" checked data-cost="{{ settings('inside_dhaka') }}" name="shippingArea" id="inside_dhaka" value="inside_dhaka">
                                <label for="inside_dhaka">Inside Dhaka {{ settings('inside_dhaka') ? getFormattedAmount(settings('inside_dhaka')) : '৳70'}}</label>
                            </label>
                            <label for="outside_dhaka" class="p-3 border rounded-3 mt-2 d-block w-100">
                                <input type="radio" data-cost="{{ settings('outside_dhaka') }}" name="shippingArea" id="outside_dhaka" value="outside_dhaka">
                                <label for="outside_dhaka">Outside Dhaka {{ settings('outside_dhaka') ? getFormattedAmount(settings('outside_dhaka')) : '৳150'}}</label>
                            </label>
                        </div>

                        <ul class="summery-total">
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price subtotal-price">{{ getFormattedAmount($orderSubTotal) }}</h4>
                            </li>

                            <li>
                                <h4>Shipping</h4>
                                <h4 class="price shipping-price">{{ getFormattedAmount($totalShippingCost) }}</h4>
                            </li>

                            @if($penaltyAmount > 0)
                                <li>
                                    <h4>Penalty </h4>
                                    <h4 class="price penalty-charge">{{ getFormattedAmount($penaltyAmount) }}</h4>
                                </li>
                            @endif

                            <li>
                                <h4>Coupon Discount</h4>
                                <h4 class="price coupon-price mb-2">{{ getFormattedAmount($couponDiscount) }}</h4>
                            </li>

                            <input type="hidden" name="ezzico_discount" class="ezzico_discount"
                                value="{{ $ezzicoDiscount }}">

                            <input type="hidden" name="totalQuantity" class="totalQuantity">

                            <li class="list-total mt-3">
                                <h4>Total</h4>
                                @php
                                    $orderTotal = $orderSubTotal + $shipping - $couponDiscount;
                                @endphp
                                <h4 class="price total-price orderTotalPrice">{{ getFormattedAmount($orderTotal) }}</h4>
                            </li>
                        </ul>

                        <input type="hidden" name="advance_shipping_cost" value="{{ settings('advance_shipping_cost') }}" id="advance_shipping_cost">

                    </div>
                </div>

                <input type="hidden" name="pickup_hub" value="{{ $isPickupHub }}">

                <div class="col-lg-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Shipping Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-xxl-12 mb-4">
                                    <div class="form-floating theme-form-floating form-group @error('name') error @enderror">
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name') }}" placeholder="{{ __('Name') }}" required>
                                        <label for="name">Name</label>
                                    </div>
                                    @error('name')
                                        <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                        
                                <div class="col-xxl-12 mb-4">
                                    <div class="form-floating theme-form-floating form-group @error('phone') error @enderror">
                                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}"
                                            placeholder="{{ __('Phone') }}" required>
                                        <label for="phone">Phone</label>
                                    </div>
                                    @error('phone')
                                        <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                        
                                <div class="col-xxl-12 mb-4">
                                    <div class="form-floating theme-form-floating form-group @error('address') error @enderror">
                                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}"
                                            placeholder="{{ __('Address') }}" required>
                                        <label for="address">Address</label>
                                    </div>
                                    @error('address')
                                        <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <p style=" font-size: 16px">আপনার অর্ডারটি নিশ্চিত করতে নাম, মোবাইল নাম্বার, বিভাগ, জেলা, থানা সঠিকভাবে পূরণ করুন এবং অ্যাড বাটন এ ক্লিক করুন। প্রয়োজনে ফোন করুন 01575468540।</p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold btn-place-order btn2"
                                    token="if you have any token validation"
                                    postdata="your javascript arrays or objects which requires in backend"
                                    order="If you already have the transaction generated for current order"
                                    endpoint="{{ url('/place-order') }}"> Place Order
                                </button>
                            </div>
                            {{-- @if(authUser())
                                @include('public.member_dashboard.address.partials.create_form')
                            @else
                                @include('public.pages.checkout.partials.create_form')
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- @include('public.pages.checkout.partials.addressModal')
@include('public.pages.checkout.partials.updateAddress') --}}

@include('public.assets.sslCommerz')

@endsection

@push('scripts')
    @vite('resources/frontend_assets/js/pages/checkout/checkout.js');

    <script>
        let addresses = @json($addresses);
        
        if (addresses.length < 1) {
            document.addEventListener("DOMContentLoaded", function () {
                const modalElement = new bootstrap.Modal(document.getElementById('add_address'));
                modalElement.show();
            });   
        }
    </script>
@endpush

@push('styles')
    <style>
        .price-col {
            width: 8rem;
            text-align: right;
        }

        .btn-apply {
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 0 1.5rem;
            border-radius: 4px;
            background: var(--theme-color);
        }

        .text-right {
            text-align: right;
        }
        .checkout-section .payment-method-box {
            padding: 8px;
            border: 1px solid #dadada;
            border-radius: 6px;
            cursor: pointer;
        }
        .checkout-section .payment-method-box.active {
            border: 1px solid var(--primary-color);
        }
        .checkout-section .payment-method-box .address-table td {
            border: none;
        }
        #sslczPayBtn {
            height: auto !important;
            padding: calc(8px + (11 - 8) * ((100vw - 320px) / (1920 - 320))) calc(16px + (24 - 16) * ((100vw - 320px) / (1920 - 320)));
        }
        #sslczPayBtn:before {
            background: none !important;
        }
        #sslczPayBtn:after {
            background: none !important;
        }

        label {
            font-size: 16px;
            font-weight: 500;
        }

        input[type="radio"] {
            display: none;
        }
        input[type="radio"] + label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            padding-left: 30px;
            position: relative;
        }
        input[type="radio"] + label::before {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color); 
            border-radius: 50%;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: #fff;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input[type="radio"]:checked + label::before {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        input[type="radio"]:checked + label::after {
            content: '';
            width: 10px;
            height: 10px;
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s;
        }
    </style>
@endpush
