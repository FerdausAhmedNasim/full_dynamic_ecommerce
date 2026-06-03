@extends('public.member_dashboard.dashboard_master')

@section('title', 'My Return List')
@section('order_return', 'active')

@section('member_content')

@php
use \App\Library\Enum;
@endphp

<div class="dashboard-order">
    <div class="title">
        <h2>My Return List</h2>
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
                        {{-- <th>Order Invoice</th> --}}
                        <th class="text-center">Status</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                    @foreach ($returns as $return)
                    <tr>
                        <td class="text-start">
                            {{ $return->invoice_id }}
                        </td>
                        {{-- <td class="text-start">
                            #{{ $return->sellerOrder->order->invoice_id }}
                        </td> --}}

                        <td class="text-center">
                            {!! \App\Library\Html::ReturnStatus($return->status) !!}
                        </td>

                        <td class="text-center">
                            {{ getFormattedAmount($return->total_amount) }}
                        </td>

                        <td class="text-center">
                            <a class="dropdown-item text-success" href="{{ route('dashboard.order.return.show', $return->id) }}">
                                <i data-feather="eye" class="edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($returns->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">

                <li class="page-item {{ $returns->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $returns->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($returns->getUrlRange(1, $returns->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $returns->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                <li class="page-item {{ $returns->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $returns->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>

            </ul>
        </nav>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@endpush
