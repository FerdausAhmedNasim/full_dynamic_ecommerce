@extends('public.member_dashboard.dashboard_master')

@section('title', __('Dashboard'))

@section('dashboard', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-home">
    <div class="title">
        <h2>My Dashboard</h2>
        <span class="title-leaf">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg#leaf') }}"></use>
            </svg>
        </span>
    </div>

    <div class="dashboard-user-name">
        <h6 class="text-content">Hello, <b class="text-title">{{AuthUser()->full_name}}</b></h6>
        <p class="text-content">From your My Account Dashboard you have the ability to
            view a snapshot of your recent account activity and update your account
            information. Select a link below to view or edit information.</p>
    </div>

    <div class="total-box">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="total-contain">
                    <img src="{{ Vite::asset(Enum::USER_ORDER_IMAGE_PATH) }}" class="img-1 blur-up lazyload" alt="">
                    <img src="{{ Vite::asset(Enum::USER_ORDER_IMAGE_PATH) }}" class="blur-up lazyload" alt="">
                    <div class="total-detail">
                        <h5>Total Order</h5>
                        <h3>{{ $total_order }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="total-contain">
                    <img src="{{ Vite::asset(Enum::USER_PENDING_IMAGE_PATH) }}" class="img-1 blur-up lazyload" alt="">
                    <img src="{{ Vite::asset(Enum::USER_PENDING_IMAGE_PATH) }}" class="blur-up lazyload" alt="">
                    <div class="total-detail">
                        <h5>Total Processing Order</h5>
                        <h3>{{ $total_order }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="total-contain">
                    <img src="{{ Vite::asset(Enum::USER_WISHLIST_IMAGE_PATH) }}" class="img-1 blur-up lazyload" alt="">
                    <img src="{{ Vite::asset(Enum::USER_WISHLIST_IMAGE_PATH) }}" class="blur-up lazyload" alt="">
                    <div class="total-detail">
                        <h5>Total Wishlist</h5>
                        <h3>{{ $total_wishlist }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-title">
        <h3>Recent Orders</h3>
    </div>

    <div class="row g-4">
        <div class="col-12">
        <div class="table-responsive" style="min-height: 400px;">
            <table class="table order-table">
                <tbody>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Return Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="text-start">
                            {{$order->order->invoice_id}}
                        </td>
                        
                        <td class="text-start">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>

                        <td class="text-start">
                            {!! getOrderStatus($order->order_status) !!}
                        </td>

                        <td class="text-start">
                            {!! getOrderPaymentStatus($order?->payment_status) !!}
                        </td>

                        <td class="text-start">
                            {!! $order?->return?->status ? '<a href="'. route('dashboard.order.return.show', $order->return?->id) .'">'. $order?->return?->statusHtml() .'</a>' : "N/A" !!}
                        </td>

                        <td class="text-start d-flex justify-content-start">
                            <div class="dropdown">
                                <button style="background-color: #0baf9a; color: #fff; padding: 6px; font-size: 14px;" class="btn dropdown-toggle" type="button" id="dropdownActiove" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-tools me-1"></i> Action
                                </button>
                                <ul style="min-width: 6rem; font-size: 14px;" class="dropdown-menu" aria-labelledby="dropdownActiove">
                                    <a class="dropdown-item" href="{{ route('dashboard.order.products', $order->order->id) }}">
                                        <i class="fa fa-eye"></i> Show
                                    </a>


                                    <a class="dropdown-item" href="{{ route('dashboard.order.return', $order->order->id) }}">
                                        <i class="fa fa-reply"></i> Return
                                    </a>


                                    <a class="dropdown-item" href="{{ route('dashboard.order.invoice', $order->order->invoice_id) }}">
                                        <i class="fa fa-download"></i> Download Invoice
                                    </a>
                                </ul>
                              </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-danger{
        background-color: red;
    }
    .badge-info{
        background-color: #00b0b6;
    }
    .badge-warning{
        background-color: #ffc107;
    }
    .badge-success{
        background-color: #198754;
    }
</style>
@endpush