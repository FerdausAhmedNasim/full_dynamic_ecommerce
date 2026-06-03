@extends('admin.pages.user.customer.layout.master')

@section('title', 'Customer Details')

@section('clientContent')

<div class="row">
    <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 stretch-card">
        <div class="card box-shadow card-design mt-2 mb-2">
            <div class="client-card-title">
                <span>Customer Details</span>
            </div>
            <div class="card-body client-card-body py-2" >

                <table class="table client-profile-table">
                    <tbody>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user?->email ?? 'N/A' }}</td>
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

    <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12 stretch-card">
        <div class="card box-shadow card-design mt-2 mb-2 d-flex justify-content-center">
            <div class="row d-flex ml-3 mr-3 justify-content-between">

                <div class="stretch-card">
                    <div class="card admin-dashboard-card-design mt-2 mb-2 card-1" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Sales</p>
                                    <h4 class="price-title">{{ getFormattedAmount($user->totalSale()) }}</h4>
                                    {{-- <h4 class="badge badge-dashboard text-success mt-2 border-success">
                                        <i class="fa-solid fa-sort-up"></i> 15.78%
                                    </h4> --}}
                                </div>
                                <div class="dashboard-icon sale-icon">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card admin-dashboard-card-design mt-2 mb-2 card-2" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Collections</p>
                                    <h4 class="price-title">{{ getFormattedAmount($user->totalCollection()) }}</h4>
                                    {{-- <h4 class="badge badge-dashboard text-danger mt-2 border-danger">
                                        <i class="fa-solid fa-sort-down"></i> -19.07%
                                    </h4> --}}
                                </div>
                                <div class="dashboard-icon collection-icon">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stretch-card">
                    <div class="card admin-dashboard-card-design mt-2 mb-2 card-3" style="cursor: default !important">
                        <div class="card-body pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <p class="card-title">Dues</p>
                                    <h4 class="price-title">{{ getFormattedAmount($user->totalDue()) }}</h4>
                                </div>
                                <div class="dashboard-icon due-icon">
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('styles')
    <style>
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
            width: 31%;
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
            font-size: 3rem;
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
