
@extends('seller.layouts.master')

@section('title', __('Referrals / Clients'))
@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Referrals / Clients')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">

                <div id="filterArea" class="d-inline-flex justify-content-start">
                <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
                    @php $active_status = \App\Library\Enum::REFERRAL_STATUS_PENDING; @endphp
                    @foreach(\App\Library\Enum::getReferralStatus() as $key => $value)
                    <li class="nav-item">
                        <a class="nav-link tab-menu {{$key == \App\Library\Enum::REFERRAL_STATUS_PENDING ? 'active' : ''}}"
                            href="#" onclick="filterStatus('{{$key}}')">{{$value}}
                        </a>
                    </li>
                    @endforeach
                </ul>
                <input type="hidden" id="status" value="{{ $active_status }}">
            </div>
                    <div class="text-center pb-2">
                        <div class="mb-3">
                            <table class="table table-bordered" id="referralDataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client Name</th>
                                        <th>Refer From</th>
                                        <th>Services</th>
                                        <th>Parent Name</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Declined By</th>
                                        <th>Operator</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/employee_assets/js/referral/index.js')
@endpush
