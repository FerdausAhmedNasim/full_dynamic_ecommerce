@extends('admin.layouts.master')

@section('title', settings('app_title') ? settings('app_title') : '')

@php
    use App\Library\Enum;
@endphp

@section('content')

    <div class="content-wrapper">
        <div class="content-header ">

            <div class="row">
                <div class="col-xxl-7 col-lg-5 col-md-3 d-block mb-2">
                    <h4 class="content-title text-blod" style="font-size: 20px; font-weight:900;">DASHBOARD</h4>
                </div>

                {{-- Filtering Section --}}
                <div class="col-xxl-5 col-lg-7 col-md-9 text-right">

                    <div class="row">
                        <div class="col-xxl-6 col-lg-7 col-md-7 d-flex justify-content-between mb-2">
                            <form class="mobile-res">
                                <button type="submit"
                                    class="btn btn2-secondary {{ $filterDate['today'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="today" value="1">
                                    Today
                                </button>
                            </form>

                            <form class="mobile-res">
                                <button type="submit"
                                    class="btn btn2-secondary {{ $filterDate['this_month'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="this_month" value="1">
                                    This Month
                                </button>
                            </form>

                            <form class="mobile-res">
                                <button type="submit"
                                    class="btn btn2-secondary {{ $filterDate['last_month'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="last_month" value="1">
                                    Last Month
                                </button>
                            </form>
                        </div>

                        <form enctype='multipart/form-data' id='dateForm'>
                            <div class="form-group">
                                <input type="hidden" name="from" value="">
                                <input type="hidden" name="to" value="">
                            </div>
                        </form>

                        <form class="col-xxl-6 col-md-5">
                            <div class="input-group with-icon">
                                <input type="text" name="date_range"
                                    class="form-control dateRange {{ $date_range ? 'active' : '' }}" id="daterangepicker"
                                    value="{{ $date_range }}"
                                    placeholder="{{ settings('date_format') }} - {{ settings('date_format') }}" />
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="row d-flex ml-1 mr-1 justify-content-between">
            <div class="stretch-card">
                <div class="card dashboard-card-design card-1" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Orders</p>
                                <h3 class="price-title">{{ $totalOrders }}</h3>
                            </div>
                            <div class="dashboard-icon sale-icon">
                                {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                <img src="{{ asset('assets/image/orders.png') }}" class="img-fluid" alt="Orders" width="70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card mt-4 mt-md-0">
                <div class="card dashboard-card-design card-2" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Delivered</p>
                                <h3 class="price-title">{{ $totalDelivered }}</h3>
                            </div>
                            <div class="dashboard-icon sale-icon">
                                {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                                <img src="{{ asset('assets/image/delivered.png') }}" class="img-fluid" alt="Delivered" width="70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card mt-4 mt-md-0">
                <div class="card dashboard-card-design card-3" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Sales</p>
                                <h3 class="price-title">{{ getFormattedAmount($totalSales) }}</h3>
                            </div>
                            <div class="dashboard-icon collection-icon">
                                {{-- <i class="fa-solid fa-sack-dollar"></i> --}}
                                <img src="{{ asset('assets/image/upselling.png') }}" class="img-fluid" alt="Sales" width="70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (false)
            <div class="stretch-card mt-4 mt-md-0">
                <div class="card dashboard-card-design card-3" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Profit</p>
                                <h3 class="price-title">{{ getFormattedAmount($totalProfit) }}</h3>
                            </div>
                            <div class="dashboard-icon due-icon">
                                {{-- <i class="fa-solid fa-filter-circle-dollar"></i> --}}
                                <img src="{{ asset('assets/image/profit.png') }}" class="img-fluid" alt="Profit" width="70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="stretch-card mt-4 mt-md-0">
                <div class="card dashboard-card-design card-5" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Products</p>
                                <h3 class="price-title">{{ $totalProducts }}</h3>
                            </div>
                            <div class="dashboard-icon profit-icon">
                                {{-- <i class="fa-solid fa-qrcode"></i> --}}
                                <img src="{{ asset('assets/image/products.png') }}" class="img-fluid" alt="Products" width="70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">

            {{-- Order Statistics Pie Chart --}}
            <div class="col-lg-5 col-md-5 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">
                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-solid fa-chart-pie"></i> Order Statistics</b></span>
                    </div>

                    <div id="piechart_3d" style="width: 100%; height:220px; margin-top:2%"></div>

                </div>
            </div>

            {{-- Show Total Customers, Sellers, Brands && Category --}}
            <div class="col-lg-3 col-md-3 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">
                    <a class="itemList bb mt-4" href="{{ url('/users/customers') }}" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Customers</p>
                                <h3 class="price-title">{{ $totalCustomer }}</h3>
                            </div>
                            <div class="dashboard-icon2 customer-icon">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        </div>
                    </a>

                    {{-- <a class="itemList bb" href="{{ url('/users/sellers') }}" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Sellers</p>
                                <h3 class="price-title">{{ $totalSellers }}</h3>
                            </div>
                            <div class="dashboard-icon2 brand-icon">
                                <i class="fa-solid fa-user-group"></i>
                            </div>
                        </div>
                    </a> --}}

                    <a class="itemList bb" href="{{ url('/brands') }}" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Brands</p>
                                <h3 class="price-title">{{ $totalBrands }}</h3>
                            </div>
                            <div class="dashboard-icon2 seller-icon">
                                <i class="fa-regular fa-star"></i>
                            </div>
                        </div>
                    </a>

                    <a class="itemList" href="{{ url('/category') }}" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Category</p>
                                <h3 class="price-title">{{ $totalCategories }}</h3>
                            </div>
                            <div class="dashboard-icon2 category-icon">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Customer Rating --}}
            <div class="col-lg-4 col-md-4 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">
                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-regular fa-star-half-stroke"></i> Customer Rating</b></span>
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted text-center mb-3">Average Rating {{ number_format($averageRating, 2, '.') }}
                        </h6>
                        <div class="template-demo">

                            @php
                                $rateMapping = [
                                    'rate_1' => ['rate' => 1, 'bgColor' => 'bg-secondary'],
                                    'rate_2' => ['rate' => 2, 'bgColor' => 'bg-danger'],
                                    'rate_3' => ['rate' => 3, 'bgColor' => 'bg-warning'],
                                    'rate_4' => ['rate' => 4, 'bgColor' => 'bg-info'],
                                    'rate_5' => ['rate' => 5, 'bgColor' => 'bg-success'],
                                ];
                            @endphp

                            @foreach ($ratings as $key => $rating)
                                @php
                                    $rate = $rateMapping[$key]['rate'] ?? 0;
                                    $bgColor = $rateMapping[$key]['bgColor'] ?? '';
                                    $percentage = $totalRating > 0 ? round(($rating / $totalRating) * 100) : 0;
                                @endphp

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="star-width">{{ $rate }} <i class="fa-regular fa-star"></i>
                                    </small>
                                    <div class="progress progress-lg mt-1">
                                        <div class="progress-bar {{ $bgColor }}" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                            aria-valuemin="0" aria-valuemax="100"
                                            data-sider-select-id="1214bc94-7f2c-4cbd-a2ac-88acd61da37e">
                                            {{ $percentage }}%</div>
                                    </div>
                                    <small class="value-width pl3 text-right">{{ $rating }}</small>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            {{-- Top 5 Categories --}}
            <div class="col-lg-4 col-md-4 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">

                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-solid fa-qrcode pr-1"></i> Top Categories</b></span>
                    </div>

                    @foreach ($topCategories as $key => $category)
                        <a class="itemList {{ $key == 4 ? '' : 'bb' }}" href="{{ url('/category') }}" target="_blank">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">{{ $category['name'] }}</p>
                                    <h6 class="price-title">{{ $category['total_sale'] }} Sales</h6>
                                </div>
                                <div class="display-image">
                                    <img src="{{ $category['image'] }}" alt="Preview Image" />
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if (count($topCategories) <= 0)
                        <div class="itemList text-center mt-3">
                            <p class="card-title">No Category Found!</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Top 5 Brands --}}
            <div class="col-lg-4 col-md-4 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">

                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-regular fa-star pr-1"></i> Top Brands</b></span>
                    </div>

                    @foreach ($topBrands as $key => $brand)
                        <a class="itemList {{ $key == 4 ? '' : 'bb' }}" href="{{ url('/brands') }}" target="_blank">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">{{ $brand['name'] }}</p>
                                    <h6 class="price-title">{{ $brand['total_sale'] }} Sales</h6>
                                </div>
                                <div class="display-image">
                                    <img src="{{ $brand['image'] }}" alt="Preview Image" />
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if (count($topBrands) <= 0)
                        <div class="itemList text-center mt-3">
                            <p class="card-title">No Brand Found!</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Top 5 Seller --}}
            @if (false)
            <div class="col-lg-3 col-md-3 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">

                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-solid fa-user-group"></i> Top Seller</b></span>
                    </div>

                    @foreach ($topSeller as $key => $seller)
                        <a class="itemList {{ $key == 4 ? '' : 'bb' }}"
                            href="{{ route('admin.user.seller.show', $seller['id']) }}" target="_blank">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">{{ $seller['name'] }}</p>
                                    <h6 class="price-title">{{ $seller['total_sale'] }} Sales</h6>
                                </div>
                                <div class="display-image">
                                    <img src="{{ $seller['image'] }}" alt="Preview Image" />
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if (count($topSeller) <= 0)
                        <div class="itemList text-center mt-3">
                            <p class="card-title">No Seller Found!</p>
                        </div>
                    @endif

                </div>
            </div>
            @endif

            {{-- Top 5 Products --}}
            <div class="col-lg-4 col-md-4 col-12 stretch-card">
                <div class="card dashboard-card-design mt-2 mb-4">

                    <div class="client-card-title d-block text-center card-head title-border">
                        <span><b><i class="fa-solid fa-qrcode pr-1"></i> Top Products</b></span>
                    </div>

                    @foreach ($topProduct as $key => $product)
                        <a class="itemList {{ $key == 4 ? '' : 'bb' }}" href="{{ url(config('app.url') . '/products/show/' . $product['slug']) }}" target="_blank">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">{{ $product['name'] }}</p>
                                    <h6 class="price-title">{{ $product['total_sale'] }} Sales</h6>
                                </div>
                                <div class="display-image">
                                    <img src="{{ $product['image'] }}" alt="Preview Image" />
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if (count($topProduct) <= 0)
                        <div class="itemList text-center mt-3">
                            <p class="card-title">No Product Found!</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- Latest Order --}}
        <div class="card shadow-sm">
            <div class="client-card-title d-flex justify-content-between card-head title-border">
                <span><b><i class="fa-solid fa-bag-shopping menu-icon"></i> Latest Orders</b></span>

                <a class="text-white pr-3" href="{{ route('admin.order.index') }}" target="">View More</a>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="table table-bordered ticket-data-table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Customer Mobile</th>
                            <th>Sub Total Amount</th>
                            <th>Shipping Cost</th>
                            <th>Discount Amount</th>
                            <th>Return Amount</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($orders) <= 0)
                            <tr>
                                <td colspan="9" class="text-center card-title">No Order Found!</td>
                            </tr>
                        @endif

                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.order.show', $order?->id) }}">{{ $order?->invoice_id }}</a>
                                </td>
                                <td>{{ $order?->customer ? $order?->customer?->full_name : $order?->order_person_name }}</td>
                                <td>{{ $order?->customer ? $order?->customer?->phone : $order?->order_person_phone }}</td>
                                <td>{{ getFormattedAmount($order?->sub_total_amount) }}</td>
                                <td>{{ getFormattedAmount($order?->shipping_cost) }}</td>
                                <td>{{ getFormattedAmount($order?->discount_amount) }}</td>
                                <td>{{ getFormattedAmount($order?->return_amount) }}</td>
                                <td>{{ getFormattedAmount($order?->total_amount) }}</td>
                                <td>
                                    {!! getOrderStatus($order?->order_status) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@stop

@include('admin.assets.dashboardCss')
@include('admin.assets.chart')
@include('admin.assets.date-range-picker')


@push('scripts')
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

        // Order Activities Charts
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Status', 'Order'],

                @foreach ($orderStatistics as $key => $total)
                    [
                        '{{ $key }}', {{ $total }}
                    ],
                @endforeach
            ]);

            var options = {
                chartArea: {
                    width: '70%',
                    height: '100%',
                },
                legend: {
                    position: 'right',
                    alignment: 'center',
                    textStyle: {
                        color: '#279c60',
                        fontSize: 16
                    }
                },
                slices: {
                    0: {
                        color: '#ffc107',
                    },
                    1: {
                        color: '#059669',
                    },
                    2: {
                        color: '#2563eb',
                    },
                    3: {
                        color: '#dc2626',
                    },
                },
                pieHole: 0.4,
                // pieSliceText: 'label',
                // pieSliceText: 'value',
                // pieStartAngle: 35,
                // is3D: true,
                // height: 260,
                backgroundColor: 'transparent',
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
@endpush


@push('styles')
    <style>
        @media (max-width: 767px) {
            .mobile-res button {
                padding: 12px 20px !important;
            }
        }
    </style>
@endpush