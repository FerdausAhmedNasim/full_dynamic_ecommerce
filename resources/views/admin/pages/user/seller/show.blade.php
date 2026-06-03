@extends('admin.pages.user.seller.layout.master')
@section('title', 'Seller Details')
@section('details', 'active')

@section('clientContent')

<div class="row d-flex ml-1 mr-1 justify-content-between">
    <div class="stretch-card">
        <div class="card dashboard-card-design card-1" style="cursor: default !important">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <p class="card-title">Total Orders</p>
                        <h3 class="price-title">{{ $totalOrders }}</h3>
                    </div>
                    <div class="dashboard-icon sale-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stretch-card">
        <div class="card dashboard-card-design card-2" style="cursor: default !important">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <p class="card-title">Total Sales</p>
                        <h3 class="price-title">{{ getFormattedAmount($totalSales) }}</h3>
                    </div>
                    <div class="dashboard-icon collection-icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stretch-card">
        <div class="card dashboard-card-design card-4" style="cursor: default !important">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <p class="card-title">Order Returns</p>
                        <h3 class="price-title">{{ getFormattedAmount($totalOrderReturns) }}</h3>
                    </div>
                    <div class="dashboard-icon expense-icon">
                        <i class="fa fa-exchange" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stretch-card">
        <div class="card dashboard-card-design card-1" style="cursor: default !important">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <p class="card-title">Balance</p>
                        <h3 class="price-title">{{ getFormattedAmount($user->balance) }}</h3>
                    </div>
                    <div class="dashboard-icon sale-icon">
                        <i class="fa-solid fa-money-check-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stretch-card">
        <div class="card dashboard-card-design card-3" style="cursor: default !important">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <p class="card-title">Total Withdraw</p>
                        <h3 class="price-title">{{ getFormattedAmount($totalWithdraw) }}</h3>
                    </div>
                    <div class="dashboard-icon due-icon">
                        <i class="fa-solid fa-filter-circle-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row" style="margin-top: 30px;">
    <div class="col-lg-6 col-md-6 col-12 stretch-card">
        <div class="card dashboard-card-design mt-2 mb-4">
            <div class="client-card-title d-block text-center text-white background-primary title-border">
                <span><b><i class="fa-regular fas fa-user"></i> Customer Details</b></span>
            </div>
            <div class="card-body" >

                <table class="table client-profile-table">
                    <tbody>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user?->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $user?->phone }}</td>
                        </tr>
                        <tr>
                            <td>DOB</td>
                            <td>{{ $user?->dob ? getFormattedDate($user->dob) : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-12 stretch-card">
        <div class="card dashboard-card-design mt-2 mb-4">
            <div class="client-card-title d-block text-center text-white background-primary title-border">
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

@endsection

@push('styles')
    <style>
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
        .progress.progress-lg {
            width: 80%;
        }
        .background-primary {
            background: #4ACE8B !important;
        }

        .card .card-body {
            padding: 0 1.25rem 1.25rem;
        }

        .table td {
            font-size: 0.875rem;
        }
        .table th,
        .table td {
            line-height: 0;
            font-weight: 500;
        }
        .br-15 {
            border-radius: 15px;
        }
        .admin-dashboard-card-design {
            cursor: pointer;
            border-radius: 20px;
            box-shadow: 3px 4px 8px #0d9953d4;
            transition: all 0.5s;
        }
        .admin-dashboard-card-design:hover {
            background: transparent;
            transform: translateY(-2%);
            box-shadow: 0px 0px 10px #00000099, inset 0px 0px 15px #0d9953;
        }
        .input-group {
            position: relative;
            .date-icon {
                z-index: 3;
                color: #fff;
                top: 0.85rem;
                right: 0.65rem;
                cursor: pointer;
                position: absolute;
            }
        }
        .title-border {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        ::placeholder {
            color: #fff !important;
            opacity: 0.6 !important;
        }

        .stretch-card {
            width: 18%;
        }
        .card-1 {
            background-color: #f0e7f99c;
        }
        .card-2 {
            background-color: #e8f9e787;
        }
        .card-3 {
            background-color: #f9f7e7a1;
        }
        .card-4 {
            background-color: #f9e7e7ad;
        }
        .card-5 {
            background-color: #e7f9f38a;
        }
        .dashboard-icon {
            font-size: 2rem;
        }
        .sale-icon i {
            color:#69b061;
        }
        .collection-icon i {
            color:#50acaa;
        }
        .due-icon i {
            color:#d4b20a;
        }
        .expense-icon i {
            color:#c04e4e;
        }
        .customer-icon i {
            color:#0bb287;
        }
        .badge-dashboard {
            background: #fff;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
        }
        .border-success {
            border: 1px solid var(--success);
        }
        .border-danger {
            border: 1px solid var(--danger);
        }
        .dateRange {
            color: white;
            border-radius: 8px !important;
            background: #4ACE8B;
        }
        /* .active {
            background-color: #089d51;
            border-color: #089d51;
        } */

        /* =============  Responsive ===========*/
        @media (max-width: 1380px) {
            .card-title{
                font-size: 1rem;
            }
            .price-title{
                font-size: 1rem;
            }
            .dashboard-icon{
                font-size: 3rem;
            }
        }
        @media (max-width: 992px) {
            .stretch-card {
                width: 49.5%;
            }
        }
        @media (max-width: 768px) {
            .stretch-card {
                width: 100%;
            }
        }
        @media (max-width: 576px) {
            .card-title{
                font-size: 1rem;
            }
            .price-title{
                font-size: 1rem;
            }
            .dashboard-icon{
                font-size: 3rem;
            }
        }

    </style>
@endpush
