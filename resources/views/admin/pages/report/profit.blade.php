@extends('admin.layouts.master')

@section('title', 'Profit Reports')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Profit Reports' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                    <div class="row">

                        <form enctype='multipart/form-data' id='dateForm'>
                            <div class="form-group">
                                <input type="hidden" name="from" value="">
                                <input type="hidden" name="to" value="">
                            </div>
                        </form>

                        <form class="col-xxl-6 col-md-5">
                            <div class="input-group with-icon">
                                <input type="text" name="date_range"
                                    class="form-control dateRange {{ $data['date_range'] ? 'active' : '' }}" id="daterangepicker"
                                    value="{{ $data['date_range'] }}"
                                    placeholder="{{ settings('date_format') }} - {{ settings('date_format') }}" />
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <hr>

            <div class="row d-flex ml-1 mr-1 justify-content-between">
                <div class="stretch-card">
                    <div class="card dashboard-card-design sales-card" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Sales</p>
                                    <h3 class="price-title">{{ getFormattedAmount($data['totalSales']) }}</h3>
                                </div>
                                <div class="dashboard-icon sale-icon">
                                    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                    <img src="{{ asset('assets/image/upselling.png') }}" class="img-fluid" alt="Sales" width="80">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card dashboard-card-design purchase-card" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Purchase</p>
                                    <h3 class="price-title">{{ getFormattedAmount($data['totalPurchase']) }}</h3>
                                </div>
                                <div class="dashboard-icon purchase-icon">
                                    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                    <img src="{{ asset('assets/image/purchase.png') }}" class="img-fluid" alt="Purchase" width="80">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card dashboard-card-design return-card" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Return</p>
                                    <h3 class="price-title">{{ getFormattedAmount($data['totalReturn']) }}</h3>
                                </div>
                                <div class="dashboard-icon return-icon">
                                    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                    <img src="{{ asset('assets/image/return.png') }}" class="img-fluid" alt="Return" width="80">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card dashboard-card-design purchase-card" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Purchase Return </p>
                                    <h3 class="price-title">{{ getFormattedAmount($data['totalReturnPurchase']) }}</h3>
                                </div>
                                <div class="dashboard-icon purchase-icon">
                                    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                    <img src="{{ asset('assets/image/returnPurchase.png') }}" class="img-fluid" alt="Purchase Return" width="80">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card dashboard-card-design profit-card" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Profit</p>
                                    <h3 class="price-title">{{ getFormattedAmount($data['netProfit']) }}</h3>
                                </div>
                                <div class="dashboard-icon profit-icon">
                                    {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                    <img src="{{ asset('assets/image/profit.png') }}" class="img-fluid" alt="Profit" width="80">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="card shadow-sm">
                <div class="client-card-title d-flex justify-content-between text-white background-primary title-border">
                    <span><b><i class="fa-solid fa-bag-shopping menu-icon"></i> Orders Wise Profit</b></span>
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable" class="table table-bordered ticket-data-table text-center">
                        <thead>
                            <tr>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center">Shipping Cost</th>
                                <th class="text-center">Coupon Discount</th>
                                <th class="text-center">Total Amount</th>
                                <th class="text-center">Purchase Cost</th>
                                <th class="text-center">Return Amount</th>
                                <th class="text-center">Purchase Return</th>
                                <th class="text-center">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (count($data['sellerOrders']) <= 0)
                                <tr>
                                    <td colspan="9" class="text-center card-title">No Order Found!</td>
                                </tr>
                            @endif --}}

                            @php
                                $totalQuantity = 0;
                                $totalSubTotals = 0;
                                $totalShipping = 0;
                                $totalDiscount = 0;
                                $totalAmounts = 0;
                                $totalPurchases = 0;
                                $totalReturns = 0;
                                $totalPurchaseReturn = 0;
                                $totalProfits = 0;
                            @endphp
    
                            @foreach ($data['sellerOrders']->load('order') as $sellerOrder)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.order.show', $sellerOrder->id) }}">{{ $sellerOrder->order->invoice_id }}</a>
                                    </td>
                                    <td>{{ $sellerOrder->quantity }}</td>
                                    <td>{{ getFormattedAmount($sellerOrder->sub_total_amount) }}</td>
                                    <td>{{ getFormattedAmount($sellerOrder->shipping_cost) }}</td>
                                    <td>{{ getFormattedAmount($sellerOrder->discount_amount) }}</td>
                                    <td>{{ getFormattedAmount($sellerOrder->total_amount) }}</td>
                                    <td>
                                        @php
                                            $purchase = $data['purchaseByOrder'][$sellerOrder->id] ?? 0;
                                        @endphp

                                        {{ getFormattedAmount($purchase) }}
                                    </td>
                                    <td>
                                        @php
                                            $return = $data['returnByOrder'][$sellerOrder->id] ?? 0;
                                        @endphp

                                        {{ getFormattedAmount($return) }}
                                    </td>
                                    <td>
                                        @php
                                            $purchaseReturn = $data['returnPurchaseByOrder'][$sellerOrder->id] ?? 0;
                                        @endphp

                                        {{ getFormattedAmount($purchaseReturn) }}
                                    </td>
                                    <td>
                                        @php
                                            $sales = $sellerOrder->total_amount - $sellerOrder->shipping_cost;
                                            $profit = $sales - $return - ($purchase - $purchaseReturn) ?? 0;
                                        @endphp

                                        @if ($profit > 0)
                                            <span class="text-success">
                                                {{-- <i class="fa-solid fa-arrow-up"></i> --}}
                                                <strong>{{ getFormattedAmount($profit) }}</strong>
                                            </span>
                                        @else 
                                            <span class="text-danger">
                                                {{-- <i class="fa-solid fa-arrow-down"></i> --}}
                                                <strong>{{ getFormattedAmount($profit) }}</strong>
                                            </span>
                                        @endif
                                    </td>

                                    @php
                                        $totalQuantity += $sellerOrder->quantity;
                                        $totalSubTotals += $sellerOrder->sub_total_amount;
                                        $totalShipping += $sellerOrder->shipping_cost;
                                        $totalDiscount += $sellerOrder->discount_amount;
                                        $totalAmounts += $sellerOrder->total_amount;
                                        $totalPurchases += $purchase;
                                        $totalReturns += $return;
                                        $totalPurchaseReturn += $purchaseReturn;
                                        $totalProfits += $profit;
                                    @endphp

                                </tr>
                            @endforeach   
                            
                        </tbody>

                        @if (count($data['sellerOrders']) > 0)
                        <tfoot>
                            <tr>
                                <th class="text-center">Total</th>
                                <th class="text-center">{{ $totalQuantity }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalSubTotals) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalShipping) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalDiscount) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalAmounts) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalPurchases) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalReturns) }}</th>
                                <th class="text-center">{{ getFormattedAmount($totalPurchaseReturn) }}</th>
                                <th class="text-center">
                                    @if ($totalProfits < 0)
                                        <span class="text-danger">
                                            {{-- <i class="fa-solid fa-arrow-down"></i> --}}
                                            {{ getFormattedAmount($totalProfits) }}
                                        </span>
                                    @else 
                                        {{ getFormattedAmount($totalProfits) }}
                                    @endif
                                </th>
                            </tr>
                        </tfoot>
                        @endif

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@include('admin.assets.date-range-picker')

@push('scripts')
    @vite('resources/admin_assets/js/pages/report/profit.js')

    <script type="text/javascript">
        // Start Date Range picker & submit from
        $(function() {
            var options = {};
            options.opens = 'left',
                options.locale = {
                    format: inputDateFormat,
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    firstDay: 1
                }

            $('#daterangepicker').daterangepicker(options, function(start, end, label) {
                $('#dateForm').find('input[name="from"]').val(start.format('YYYY-MM-DD'));
                $('#dateForm').find('input[name="to"]').val(end.format('YYYY-MM-DD'));

                $('#dateForm').submit();
            });

            // Date range value clear
            // $('#daterangepicker').val("");
            $('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
                $('#daterangepicker').val("");
            });

        });
        // End Date Range picker
    </script>
@endpush


@push('styles')
    <style>
        .stretch-card {
            width: 19%;
        }
        .dashboard-card-design {
            cursor: pointer !important;
            border-radius: 20px;
            box-shadow: 3px 4px 8px #0d9953d4;
            transition: all 0.5s;
        }
        .dashboard-card-design:hover {
            background: transparent;
            transform: translateY(-2%);
            box-shadow: 0px 0px 10px #00000099, inset 0px 0px 15px #0d9953;
        }
        .dashboard-card-design tr td {
            font-size: 1.025rem;
            line-height: 0.75rem;
        }

        .profit-card {
            background-color: #e7f9f38a;
        }
        .sales-card {
            background-color: #e8f9e787;
        }
        .purchase-card {
            background-color: #f9f7e7a1;
        }
        .return-card {
            background-color: #f9e7e79c;
        }

        .dashboard-icon {
            font-size: 3rem;
        }

        .sale-icon i {
            color:#50acaa;
        }
        .purchase-icon i {
            color:#d4b20a;
        }
        .return-icon i {
            color:#c04e4e;
        }
        .profit-icon i {
            color:#69b061;
        }

    </style>
@endpush