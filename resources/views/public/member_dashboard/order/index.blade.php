@extends('public.member_dashboard.dashboard_master')

@section('title', __('Orders'))

@section('order', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-order">
    <div class="title">
        <h2>My Orders History</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <div class="order-tab dashboard-bg-box">
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
                    @foreach ($sellerOrders as $sellerOrder)
                    <tr>
                        <td class="text-start">
                            {{$sellerOrder->order->invoice_id}}
                        </td>
                        <td class="text-start">
                            ${{ number_format($sellerOrder->total_amount, 2) }}
                        </td>

                        <td class="text-start">
                            {!! getOrderStatus($sellerOrder->order_status) !!}
                        </td>

                        <td class="text-start">
                            {!! getOrderPaymentStatus($sellerOrder->payment_status) !!}
                        </td>

                        <td class="text-start">
                            {!! $sellerOrder?->return?->status ? '<a href="'. route('dashboard.order.return.show', $sellerOrder->return?->id) .'">'. $sellerOrder?->return?->statusHtml() .'</a>' : "N/A" !!}
                        </td>

                        <td class="text-start d-flex justify-content-start">
                            <div class="dropdown">
                                <button style="background-color: #0baf9a; color: #fff; padding: 6px; font-size: 14px;" class="btn dropdown-toggle" type="button" id="dropdownActiove" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-tools me-1"></i> Action
                                </button>
                                <ul style="min-width: 6rem; font-size: 14px;" class="dropdown-menu" aria-labelledby="dropdownActiove">
                                    <a class="dropdown-item" href="{{ route('dashboard.order.products', $sellerOrder->order->id) }}">
                                        <i class="fa fa-eye"></i> Show
                                    </a>

                                    @if($sellerOrder->order_status == \App\Library\Enum::ORDER_STATUS_TYPE_DELIVERED)
                                    <a class="dropdown-item" href="{{ route('dashboard.order.return', $sellerOrder->order->id) }}">
                                        <i class="fa fa-reply"></i> Return
                                    </a>
                                    @endif

                                    @if($sellerOrder->order_status != \App\Library\Enum::ORDER_STATUS_TYPE_CANCELED)
                                    <a class="dropdown-item" href="{{ route('dashboard.order.invoice', $sellerOrder->order->invoice_id) }}">
                                        <i class="fa fa-download"></i> Download Invoice
                                    </a>
                                    @endif
                                </ul>
                              </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($sellerOrders->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $sellerOrders->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $sellerOrders->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($sellerOrders->getUrlRange(1, $sellerOrders->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $sellerOrders->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                <li class="page-item {{ $sellerOrders->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $sellerOrders->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>

            </ul>
        </nav>
        @endif
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