@extends('seller.layouts.master')

@section('title', __('Referral / Clients Details'))

@section('content')

<div class="content-wrapper" id="reloadShowDiv">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.referral.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Referral / Clients Details')) }}</h4>
        </div>

    </div>
    <div class="row">
        <div class="col-xxl-4 col-xl-5 col-lg-12 col-md-12 pb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @php
                                        use App\Library\Enum;
                                        if ($referral->status == Enum::REFERRAL_STATUS_PENDING)
                                            $class = 'badge-secondary';
                                        else if ($referral->status == Enum::REFERRAL_STATUS_ENROLLED)
                                            $class = 'badge-success';
                                        else if ($referral->status == Enum::REFERRAL_STATUS_DECLINED)
                                            $class = 'badge-danger';
                                        else if ($referral->status == Enum::REFERRAL_STATUS_DISCHARGE)
                                            $class = 'badge-info';
                                    @endphp

                                    <div class="badge {{ $class }}">
                                        {{ ucwords(Enum::getReferralStatus($referral->status)) }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Client</td><td>{{ $referral?->client?->user?->full_name }}</td>
                            </tr>

                            @if($referral->parent_name)
                            <tr>
                                <td>Parent Name</td>
                                <td> {{ $referral->parent_name }} </td>
                            </tr>
                            @endif

                            <tr>
                                <td>Referral From</td>
                                <td>
                                    @if($referral->referral_employee_id)
                                        {{-- <a href="{{ route('admin.seller.show', $referral->referral_employee_id) }}" target="_blank"> --}}
                                            {{ $referral?->employee->user?->full_name }}
                                        {{-- </a> --}}
                                    @else
                                        <span style="line-height:1.6;"><b>Name:</b> {{ $referral->referral_from_name }}</span><br/>
                                        <span style="line-height:1.6;"><b>Address:</b> {{ $referral->referral_from_address }}</span><br/>
                                        <span style="line-height:1.6;"><b>Note:</b> {{ $referral->referral_from_note }}</span><br/>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Refer To</td>
                                <td>
                                    @if($referral->refer_to)
                                        {{-- <a href="{{ route('admin.seller.show', $referral->refer_to) }}" target="_blank"> --}}
                                            {{ $referral->referTo->user?->full_name }}
                                        {{-- </a> --}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Service</td>
                                <td> {{ $referral->service->name }} </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Referral Reason</td>
                                <td style="white-space: unset;"> {{ $referral->reason }} </td>
                            </tr>
                            <tr>
                                <td>Date Time</td>
                                <td> {{ getFormattedDateTime($referral->date_time) }} </td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td> {{ $referral?->operator?->full_name }} </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4">

                        @if ($referral->status != Enum::REFERRAL_STATUS_DECLINED && $referral->status != Enum::REFERRAL_STATUS_DISCHARGE && $referral->refer_to == auth()->user()->employee->id)
                        <button class="btn btn-sm mb-2 mr-2 btn-secondary "
                            onclick="clickChangeStatusAction({{ $referral->id }})">
                            <i class="fas fa-power-off"></i> Change Status
                        </button>
                        @endif

                        @if ($referral->status == Enum::REFERRAL_STATUS_PENDING && $referral->refer_to == auth()->user()->employee->id)
                        <button class="btn btn-sm mb-2 mr-2 btn2-secondary "
                            onclick="clickRereferAction({{ $referral->id }})">
                            <i class="fa-solid fa-repeat"></i> Re-refer
                        </button>
                        @endif

                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body table-responsive">
                    <h4>Attachment</h4>
                    <hr>
                    <table class="table org-data-table table-bordered">
                        @foreach ($attachments as $attachment)
                            <tbody>
                                <tr>
                                    <td>{{ $attachment->name }}</td>
                                    <td>
                                        <a target="_blank" href="{{ $attachment->getAttachment() }}">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>

        <div class="col-xxl-8 col-xl-7 col-lg-12 col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="add-items mb-0">
                        {!! $referral->note !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('seller.pages.referral.partial.rerefer_modal')

@stop

@push('scripts')
@vite('resources/employee_assets/js/referral/show.js')
@endpush
